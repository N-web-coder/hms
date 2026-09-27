@extends('index')

@section('adminContent')
<div class="page-content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ isset($staff) ? 'Edit Staff' : 'Add Staff' }}</h5>
            </div>

            <div class="card-body">
                <form action="{{ isset($staff) ? route('staff.update', $staff->id) : route('staff.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(isset($staff))
                        @method('PUT')
                    @endif

                    <div class="form-group mb-3">
                        <label>Name *</label>
                        <input type="text" name="name" value="{{ old('name', $staff->name ?? '') }}" class="form-control" required>
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Email *</label>
                        <input type="email" name="email" value="{{ old('email', $staff->email ?? '') }}" class="form-control" required>
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Mobile *</label>
                        <input type="text" name="mobile" value="{{ old('mobile', $staff->mobile ?? '') }}" class="form-control" maxlength="10" required>
                        @error('mobile') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control">{{ old('address', $staff->address ?? '') }}</textarea>
                        @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Date of Birth</label>

                        <input type="date" name="dob" value="{{ old('dob', optional($staff->dob)->format('Y-m-d')) }}" class="form-control">

                        @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Gender</label>
                        <select name="gender" class="form-control">
                            <option value="">Select</option>
                            <option value="male" {{ old('gender', $staff->gender ?? '') == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $staff->gender ?? '') == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $staff->gender ?? '') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="form-group mb-3">
                        <label>Photo</label>
                        <input type="file" name="photo" class="form-control-file">
                        @if(isset($staff) && $staff->photo)
                            <img src="{{ asset('storage/' . $staff->photo) }}" width="80" height="80" class="mt-2" alt="Photo">
                        @endif
                        @error('photo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ isset($staff) ? 'Update' : 'Add' }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
