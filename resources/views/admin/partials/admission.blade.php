<div class="row">

                            <div class="col-md-6 mb-3">
                                <label for="name">Full Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="mobile">Mobile Number</label>
                                <input type="text" name="mobile" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mobile">Parent Mobile </label>
                                <input type="text" name="parentMobile" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob">Date of Birth</label>
                                <input type="date" name="dob" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender">Gender</label>
                                <select name="gender" class="form-control" required>
                                    <option value="">-- Select Gender --</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pincode">Zip Code</label>
                                <input type="text" name="pincode" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="address">Full Address</label>
                                <textarea name="address" class="form-control" rows="2" required></textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob">Adhar Number</label>
                                <input type="text" name="adhar" value="{{ old('adhar') }}" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dob">Pan Number</label>
                                <input type="text" name="pan" value="{{ old('pan') }}" class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="photo">Upload Photo (jpeg,jpg,png)</label>
                                <input type="file" name="photo" value="{{ old('photo') }}" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="photo">Upload Adhar (pdf,jpeg,jpg,png)</label>
                                <input type="file" name="doc_adhar" value="{{ old('doc_adhar') }}" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="photo">Upload Pan (pdf,jpeg,jpg,png)</label>
                                <input type="file" name="doc_pan" value="{{ old('doc_pan') }}" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="photo">Upload Admission certificate (Optional)
                                </label>
                                <input type="file" name="doc_qualification" value="{{ old('doc_qualification') }}"
                                    class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type">User Type</label>
                                <select name="type" class="form-control" required>
                                    <option value="student">Student</option>
                                    <option value="staff">Staff</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="type">Select Room</label>
                                <select name="room_id" id="roomSelect" class="form-select">

                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->id }}">Room {{ $room->room_number }}</option>
                                    @endforeach
                                </select>
                            </div>

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

                        </div>