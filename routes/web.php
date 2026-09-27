<?php

use App\Http\Controllers\admin\admissionController;
use App\Http\Controllers\admin\hostelController;
use App\Http\Controllers\admin\invoiceController;
use App\Http\Controllers\admin\staffController;
use App\Http\Controllers\admin\studentController;
use App\Http\Controllers\authController;
use App\Http\Controllers\staff\attendanceController;
use App\Http\Controllers\staff\enquiryController;
use App\Http\Controllers\staff\paymentController;
use App\Http\Controllers\staff\studentMenuController;
use App\Http\Controllers\student\indexController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'auth.sign_in')->name('signin');

Route::view('signup', 'auth.sign_up');

Route::get('forgot', function () {
    return view('auth.forgot');
})->name('forgot');

Route::post('signup', [authController::class, 'register'])->name('signup.submit');

Route::post('signin', [authController::class, 'login'])->name('signin.submit');
Route::post('/forgot-password/send', [authController::class, 'sendResetLink'])->name('password.email');

Route::get('reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('reset-password', [authController::class, 'resetPassword'])->name('password.update');

Route::post('/logout', [authController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::prefix('admin')->group(function () {
        Route::get('index', [admissionController::class, 'adminIndexShow'])->name('admin.show');

        Route::get('admission', [admissionController::class, 'admissionFormShow'])->name('admin.admission.form');
        Route::post('admission/submit', [admissionController::class, 'submitAdminForm'])->name('admin.admission.submit');

        Route::get('student', [studentController::class, 'studentView'])->name('admin.student.show');
        Route::post('admission/{id}/approve', [studentController::class, 'approve'])->name('admin.admission.approve');

        Route::get('/student/edit/{id}', [studentController::class, 'edit'])->name('student.edit');
        Route::get('/get-empty-beds/{room_id}', [studentController::class, 'getEmptyBeds']);

        Route::post('/student/update/{id}', [studentController::class, 'update'])->name('student.update');
        Route::delete('/student/delete/{id}', [studentController::class, 'destroy'])->name('student.delete');
        Route::get('/student/payment/{id}/pdf', [studentController::class, 'generatePDF'])->name('admin.student.payment.pdf');
        Route::get('student-payments', [studentController::class, 'studentPayments'])->name('admin.student.payments');
        Route::get('student/details/{admission_id}', [studentController::class, 'fullDetails'])->name('student.full.details');


        Route::prefix('staff')->group(function () {
            Route::get('/', [staffController::class, 'staffView'])->name('admin.staff.show');
            Route::get('/create', [StaffController::class, 'create'])->name('staff.create');
            Route::post('/admin/staff', [StaffController::class, 'store'])->name('staff.store');
            Route::get('/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
            Route::put('/update/{id}', [StaffController::class, 'update'])->name('staff.update');
            Route::delete('/delete/{id}', [StaffController::class, 'destroy'])->name('staff.destroy');

            Route::post('staff/{id}/approve', [studentController::class, 'approve'])->name('admin.staff.admission.approve');

            Route::post('/salary/pay', [staffController::class, 'paySalary'])->name('staff.salary.pay');
            Route::get('/salary/history', [staffController::class, 'salaryHistory'])->name('admin.staff.salary.history');

            Route::get('attendance-history', [staffController::class, 'staffAttendanceHistory'])->name('admin.staff.attendance.history');
            Route::get('/payment/{id}/pdf', [staffController::class, 'generateSalarySlipPDF'])->name('admin.staff.payment.pdf');
        });

        Route::prefix('hostel')->group(function () {
            Route::view('room', 'admin.hostel.new_room')->name('admin.hostel.newroom');
            Route::post('room/submit', [hostelController::class, 'roomSubmit'])->name('admin.hostel.newroom.submit');

            Route::get('room-allocation', [hostelController::class, 'roomAllocationView'])->name('room.allocation');
            Route::post('allocate-room', [hostelController::class, 'allocateRoom'])->name('room.allocate');

            Route::post('edit-allocation', [hostelController::class, 'editAllocation'])->name('room.edit.allocate');
            Route::post('room/remove', [hostelController::class, 'removeAllocation'])->name('room.remove.allocate');

            Route::get('/hostel/deleted-items', [HostelController::class, 'showDeletedItems'])->name('admin.hostel.deleted.items');
            Route::post('/bed/delete', [HostelController::class, 'deleteBed'])->name('bed.delete');
            Route::get('/bed/restore/{id}', [HostelController::class, 'restoreBed'])->name('bed.restore');
            Route::get('/bed/permanent-delete/{id}', [HostelController::class, 'permanentDelete'])->name('bed.permanent.delete');

            Route::post('/room/delete', [HostelController::class, 'delete'])->name('room.delete');
            Route::get('/room/restore/{id}', [HostelController::class, 'restore'])->name('room.restore');
            Route::post('/room/{id}/add-bed', [HostelController::class, 'storeBed'])->name('bed.store');
            Route::post('/room/{room}/bed/add-manual', [HostelController::class, 'addBedForm'])->name('bed.add.form');
            Route::get('/room/permanent-delete/{id}', [HostelController::class, 'roomPermanentDelete'])->name('room.permanent.delete');
        });

        Route::get('enquiries', [admissionController::class, 'viewEnquiries'])->name('admin.enquiries');
        Route::put('enquiries/{id}/reply', [admissionController::class, 'updateRemarks'])->name('admin.enquiries.reply');
        Route::delete('enquiries/{id}/delete', [admissionController::class, 'deleteEnquiry'])->name('admin.enquiries.delete');

        Route::get('/invoice/create', [invoiceController::class, 'createInvoice'])->name('invoice.create');
        Route::post('/invoice/store', [invoiceController::class, 'storeInvoice'])->name('invoice.store');
        Route::get('/invoice/download/{id}', [invoiceController::class, 'download'])->name('invoice.download');

        Route::view('admin/companyinfo', 'admin.companyInfo')->name('admin.companyInfo');
        Route::post('admin/companyinfo', [invoiceController::class, 'companyInfoUpdate'])->name('companyinfo.update');
    });

    Route::prefix('staff')->group(function () {
        Route::get('index', [attendanceController::class, 'staffDashboard'])->name('staff.show');
        Route::get('admissions', [studentMenuController::class, 'staffAdmissions'])->name('staff.admissions');

        Route::get('attendance', [attendanceController::class, 'index'])->name('staff.attendance');
        Route::post('attendance/store', [attendanceController::class, 'store'])->name('staff.attendance.store');

        Route::get('admission', [admissionController::class, 'admissionFormShow'])->name('staff.admission.form');
        Route::post('admission/submit', [admissionController::class, 'submitAdminForm'])->name('staff.admission.submit');

        Route::get('attendance/history', [AttendanceController::class, 'attendanceHistory'])->name('staff.attendance.history');
        Route::get('salary/history', [paymentController::class, 'staffSalaryHistory'])->name('staff.payroll');

        Route::get('staff/enquiry', [enquiryController::class, 'showEnquiryForm'])->name('staff.enquiry.form');
        Route::post('staff/enquiry', [enquiryController::class, 'submitEnquiry'])->name('staff.enquiry.submit');
    });

    Route::prefix('student')->group(function () {
        Route::get('/dashboard', [indexController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/admission', [indexController::class, 'admission'])->name('student.admission');
        Route::post('admission-form', [indexController::class, 'store'])->name('student.admission.submit');

        Route::get('/payments', [indexController::class, 'payments'])->name('student.payments');
        Route::get('/mesh', [indexController::class, 'mesh'])->name('student.mesh');

        Route::get('/monthly-payments', [indexController::class, 'monthlyPayments'])->name('student.monthly');
        Route::post('/monthly-payments', [indexController::class, 'storeMonthlyPayment'])->name('student.monthly.pay');

        Route::get('/enquiries', [indexController::class, 'enquiryShow'])->name('student.enquiries');
        Route::post('/enquiries', [indexController::class, 'enquiryStore'])->name('student.enquiries.store');
    });
});
