<div class="page-content">
        <div class="container-fluid">

            {{-- Success Alert --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Error Alert --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Edit Student Admission</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('student.update', $student->user_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        {{-- @method('PUT') --}}
                        <div class="row">
                            {{-- User fields --}}
                            <div class="col-md-6 mb-3">
                                <label><strong>Name</strong></label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', $student->user->name) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Email</strong></label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', $student->user->email) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Mobile</strong></label>
                                <input type="text" name="mobile" class="form-control"
                                    value="{{ old('mobile', $student->user->mobile) }}" required maxlength="10"
                                    minlength="10">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>User Type</strong></label>
                                <input type="text" name="type" class="form-control"
                                    value="{{ old('type', $student->user->type) }}" required>
                            </div>

                            {{-- Admission fields --}}
                            <div class="col-md-6 mb-3">
                                <label><strong>Parent Mobile</strong></label>
                                <input type="text" name="parentMobile" class="form-control"
                                    value="{{ old('parentMobile', $student->parent_number) }}" required maxlength="10"
                                    minlength="10">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Date of Birth</strong></label>
                                <input type="date" name="dob" class="form-control"
                                    value="{{ old('dob', $student->dob) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Gender</strong></label>
                                <select name="gender" class="form-control" required>
                                    <option value="male"
                                        {{ old('gender', $student->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female"
                                        {{ old('gender', $student->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Pincode</strong></label>
                                <input type="text" name="pincode" class="form-control"
                                    value="{{ old('pincode', $student->pincode) }}" required maxlength="6" minlength="6">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label><strong>Address</strong></label>
                                <textarea name="address" class="form-control" required>{{ old('address', $student->address) }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Aadhaar Number</strong></label>
                                <input type="text" name="adhar" class="form-control"
                                    value="{{ old('adhar', $student->adhar_number) }}" required maxlength="12"
                                    minlength="12">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>PAN Number</strong></label>
                                <input type="text" name="pan" class="form-control"
                                    value="{{ old('pan', $student->pan_number) }}" required
                                    pattern="[A-Z]{5}[0-9]{4}[A-Z]{1}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type">Select Room</label>
                                <select name="room_id" id="roomSelect" class="form-select">

                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">Room {{ $room->room_number }}</option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Bed Select --}}

                            <div class="col-md-6 mb-3">
                                <label for="type">Select Bed</label>
                                <select name="bed_id" id="bedSelect" class="form-select">

                                </select>
                            </div>

                            <script>
                                let rooms = @json($rooms);

                                document.getElementById('roomSelect').addEventListener('change', function() {
                                    let roomId = this.value;
                                    let bedDropdown = document.getElementById('bedSelect');
                                    bedDropdown.innerHTML = '<option value="">Select Bed</option>';

                                    let selectedRoom = rooms.find(r => r.id == roomId);

                                    if (selectedRoom) {
                                        selectedRoom.beds.forEach(bed => {
                                            bedDropdown.innerHTML += `<option value="${bed.id}">Bed ${bed.bed_number}</option>`;
                                        });
                                    }
                                });
                            </script>

                            {{-- Documents --}}
                            <div class="col-md-6 mb-3">
                                <label><strong>Photo (Upload if change)</strong></label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                                @if ($student->photo)
                                    <img src="{{ asset('storage/' . $student->photo) }}" alt="Photo" width="100"
                                        class="mt-2">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Aadhaar Document</strong></label>
                                <input type="file" name="doc_adhar" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                @if ($student->doc_adhar)
                                    <a href="{{ asset('storage/' . $student->doc_adhar) }}" target="_blank">View
                                        Existing</a>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>PAN Document</strong></label>
                                <input type="file" name="doc_pan" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                                @if ($student->doc_pan)
                                    <a href="{{ asset('storage/' . $student->doc_pan) }}" target="_blank">View
                                        Existing</a>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Qualification Document</strong></label>
                                <input type="file" name="doc_qualification" class="form-control"
                                    accept=".jpg,.jpeg,.png,.pdf">
                                @if ($student->doc_qualification)
                                    <a href="{{ asset('storage/' . $student->doc_qualification) }}" target="_blank">View
                                        Existing</a>
                                @endif
                            </div>

                            {{-- Mess Subscription --}}
                            <div class="col-md-6 mb-3">
                                <label><strong>Mess Plan</strong></label>
                                <select name="meal_type" class="form-control">
                                    <option value="break_fast"
                                        {{ old('meal_type', $mess->meal_type ?? '') == 'break_fast' ? 'selected' : '' }}>
                                        Breakfast</option>
                                    <option value="lunch"
                                        {{ old('meal_type', $mess->meal_type ?? '') == 'lunch' ? 'selected' : '' }}>Lunch
                                    </option>
                                    <option value="dinner"
                                        {{ old('meal_type', $mess->meal_type ?? '') == 'dinner' ? 'selected' : '' }}>Dinner
                                    </option>
                                    <option value="all"
                                        {{ old('meal_type', $mess->meal_type ?? '') == 'all' ? 'selected' : '' }}>All
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Mess Start Date</strong></label>
                                <input type="date" name="mesh_start" class="form-control"
                                    value="{{ old('mesh_start', $mess->mesh_start ?? '') }}" >
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><strong>Mess End Date</strong></label>
                                <input type="date" name="mesh_end" class="form-control"
                                    value="{{ old('mesh_end', $mess->mesh_end ?? '') }}" >
                            </div>

                        </div>

                        <button type="submit" class="btn btn-success mt-3">Update Admission</button>
                    </form>
                </div>
            </div>

        </div>
    </div>