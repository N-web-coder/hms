# Hostel Management System

A web-based Hostel Management System built with **Laravel** to manage hostel admissions, students, staff, rooms, beds, payments, attendance, enquiries, and invoices through role-based dashboards.

## 📌 Project Overview

The Hostel Management System simplifies day-to-day hostel operations by providing separate interfaces and functionality for Admin, Staff, and Students.

The Admin can manage hostel facilities, admissions, staff, payments, and other operations. Staff members can manage attendance, admissions, and enquiries, while students can access their admission details, payments, mess information, and enquiries.

## ✨ Features

### 🔐 Authentication

* User registration and login
* Logout functionality
* Forgot password
* Password reset
* Authenticated routes

### 👨‍💼 Admin Dashboard

* Admin dashboard
* Manage student admissions
* Approve student admissions
* View and manage student records
* Edit and delete student records
* View complete student details
* View student payment history
* Generate student payment PDF
* Manage staff
* Approve staff admissions
* Manage staff salary payments
* View staff salary history
* Generate staff salary slips
* View staff attendance history
* Manage hostel rooms and beds
* Allocate rooms and beds
* Edit and remove room allocations
* Restore deleted rooms and beds
* Permanently delete rooms and beds
* Manage enquiries and replies
* Create and download invoices
* Update company information

### 👨‍💻 Staff Dashboard

* Staff dashboard
* View admissions
* Submit admission forms
* Manage attendance
* View attendance history
* View salary history
* Submit enquiries

### 🎓 Student Dashboard

* Student dashboard
* Submit hostel admission application
* View payment records
* View mess information
* View monthly payments
* Submit monthly payments
* Submit and view enquiries

## 🛠️ Tech Stack

* **Backend:** PHP, Laravel
* **Database:** MySQL
* **Frontend:** Blade Templates, HTML, CSS, JavaScript
* **Authentication:** Laravel authentication
* **PDF Generation:** Used for payment records and salary slips

> Update the technology list if your project uses any additional libraries or packages.

## ⚙️ Requirements

Make sure the following are installed on your system:

* PHP version compatible with the Laravel version used by this project
* Composer
* MySQL
* Node.js and npm (if frontend assets require building)
* Git

## 🔑 Demo Admin Login

Use the following credentials to explore the Admin dashboard.

| Field     | Demo Credentials                          |
| --------- | ----------------------------------------- |
| Email     | [admin@gmail.com](mailto:admin@gmail.com) |
| Password  | 12345678                                  |
| Login URL | `/`                                       |

**Important:** The demo admin account must exist in the database. If it is not already included in the provided database or seeders, create the account before logging in.

These credentials are intended for demonstration purposes only. Do not use this password for a production account.


This project is intended for learning, demonstration, and portfolio purposes. Add a license file if you want to specify how others may use, modify, or distribute the code.
