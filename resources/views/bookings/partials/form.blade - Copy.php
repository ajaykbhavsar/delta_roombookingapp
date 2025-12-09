@php
    $booking = $booking ?? null;
    $isEdit = $booking !== null;
    $formAction = $isEdit ? route('bookings.update', $booking) : route('bookings.store');
    $defaultRoomTypeId = old('room_type_id', $isEdit ? $booking->room_type_id : ($roomTypes->first()->id ?? null));

   $roomRateValue = old('room_rate');

if ($roomRateValue === null) {
    if ($isEdit && $booking->room_rate !== null) {

        // Editing an existing booking → preset
        $roomRateValue = $booking->room_rate;
        $hasPresetRoomRate = true;

    } else {

        // New booking → NOT preset
        $roomRateValue = optional($roomTypes->first())->base_rate ?? 0;
        $hasPresetRoomRate = false;

    }
}


    $roomRateValue = (float) $roomRateValue;
    $discountValue = (float) old('discount', $isEdit ? $booking->discount : 0);
    $serviceValue = (float) old('service_charges', $isEdit ? $booking->service_charges : 0);
    $initialTotal = max(0, ($roomRateValue - $discountValue) + $serviceValue);

    $checkInValue = old('check_in_at', $isEdit && $booking->check_in_at ? $booking->check_in_at->format('Y-m-d\TH:i') : '');
    $checkOutValue = old('check_out_at', $isEdit && $booking->check_out_at ? $booking->check_out_at->format('Y-m-d\TH:i') : '');
    $submitLabel = $isEdit ? 'Update Booking' : 'Submit Booking';
@endphp

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ $formAction }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PATCH')
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Guest Information</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $isEdit ? $booking->first_name : '') }}"
                           class="form-control @error('first_name') is-invalid @enderror"
                           placeholder="Enter first name" required>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $isEdit ? $booking->last_name : '') }}"
                           class="form-control @error('last_name') is-invalid @enderror"
                           placeholder="Enter last name" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
               <div class="col-md-4">
    <label for="phone_number" class="form-label">Phone Number <span class="text-danger">*</span></label>
    <input type="text" 
           name="phone_number" 
           id="phone_number"
           value="{{ old('phone_number', $isEdit ? $booking->phone_number : '') }}"
           class="form-control digits @error('phone_number') is-invalid @enderror"
           placeholder="Enter phone number"
           required
           minlength="10"
           maxlength="15"
           oninput="this.value = this.value.replace(/[^0-9]/g, '');">
    @error('phone_number')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $booking->email : '') }}"
                           class="form-control @error('email') is-invalid @enderror" placeholder="guest@example.com" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="id_proof_type" class="form-label">ID Proof Type <span class="text-danger">*</span></label>
                    <select name="id_proof_type" id="id_proof_type"
                            class="form-select @error('id_proof_type') is-invalid @enderror" required>
                        @foreach($idProofOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('id_proof_type', $isEdit ? $booking->id_proof_type : array_key_first($idProofOptions)) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_proof_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="id_number" class="form-label">ID Number <span class="text-danger">*</span></label>
                    <input type="text" name="id_number" id="id_number" value="{{ old('id_number', $isEdit ? $booking->id_number : '') }}"
                           class="form-control @error('id_number') is-invalid @enderror"
                           placeholder="Enter ID number" required>
                    @error('id_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <textarea name="address" id="address" rows="3"
                              class="form-control @error('address') is-invalid @enderror"
                              placeholder="Enter complete address" required>{{ old('address', $isEdit ? $booking->address : '') }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Stay Details</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="booking_type" class="form-label">Booking Type <span class="text-danger">*</span></label>
                    <select name="booking_type" id="booking_type" class="form-select @error('booking_type') is-invalid @enderror" required>
                        @foreach($bookingTypeOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('booking_type', $isEdit ? $booking->booking_type : 'daily') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('booking_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="check_in_at" class="form-label">Check-in Date &amp; Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="check_in_at" id="check_in_at" value="{{ $checkInValue }}"
                           class="form-control @error('check_in_at') is-invalid @enderror"
                           placeholder="Select check-in date and time" required>
                    @error('check_in_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="check_out_at" class="form-label">Check-out Date &amp; Time <span class="text-danger">*</span></label>
                    <input type="datetime-local" name="check_out_at" id="check_out_at" value="{{ $checkOutValue }}"
                           class="form-control @error('check_out_at') is-invalid @enderror"
                           placeholder="Select check-out date and time" required>
                    @error('check_out_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="guest_count" class="form-label">Number of Guests <span class="text-danger">*</span></label>
                    <input type="number" name="guest_count" id="guest_count" value="{{ old('guest_count', $isEdit ? $booking->guest_count : 1) }}"
                           class="form-control @error('guest_count') is-invalid @enderror"
                           placeholder="Enter number of guests" min="1" max="20" required>
                    @error('guest_count')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Room Information</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
            <div class="col-md-4">
        <div class="form-group">
            <label class="form-label">Location <span class="text-danger">*</span></label>
            <select name="location" id="location" class="form-control" required>
                <option value="">Select Location</option>
                @foreach($locations as $loc)
                    <option value="{{ $loc->id }}"
                        {{ old('location', $isEdit && isset($booking) ? $booking->room->location_id : '') == $loc->id ? 'selected' : '' }}>
                        {{ $loc->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-4">
                     <label class="form-label">Room Type <span class="text-danger">*</span></label>
                    <select name="room_type_id" id="room_type_id" class="form-select @error('room_type_id') is-invalid @enderror" required>
                        <option value="">Select Type</option>
                        @foreach($roomTypes as $rt)
                            <option value="{{ $rt->id }}"
                                data-rate="{{ number_format($rt->base_rate ?? 0, 2, '.', '') }}"
                                {{ (string) old('room_type_id', $defaultRoomTypeId) === (string) $rt->id ? 'selected' : '' }}>
                                {{ $rt->name }}
                            </option>
                        @endforeach
                    </select>
                
                    @error('room_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="room_id" class="form-label">Room Number <span class="text-danger">*</span></label>
                    <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror"
                            data-exclude-booking-id="{{ $isEdit && isset($booking) ? $booking->id : '' }}"
                            required>
                        <option value="">Select Room</option>
                        @if($isEdit && isset($booking) && $booking->room)
                            <option value="{{ $booking->room->id }}" selected>
                                {{ $booking->room->room_no }}
                            </option>
                        @endif
                    </select>
                    @error('room_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="room_status" class="form-label">Room Status <span class="text-danger">*</span></label>
                    <select name="room_status" id="room_status" class="form-select @error('room_status') is-invalid @enderror" required readonly style="pointer-events: none !important;">
                        @foreach($roomStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('room_status', $isEdit ? $booking->room_status : '') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-8" style="display: none;">
                <label for="room_location" class="form-label">Room Location <span class="text-danger">*</span></label>
                <textarea name="room_location" id="room_location"
                class="form-control @error('room_location') is-invalid @enderror"
                rows="1" readonly
                >{{ old('room_location', $isEdit ? $booking->room_location : '') }}</textarea>

                @error('room_location')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>
                <div class="col-md-4">
                    <label for="occupancy_status" class="form-label">Occupancy Status <span class="text-danger">*</span></label>
                    <select name="occupancy_status" id="occupancy_status"
                            class="form-select @error('occupancy_status') is-invalid @enderror" required readonly  style="pointer-events: none !important;">
                        @foreach($occupancyStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('occupancy_status', $isEdit ? $booking->occupancy_status : '') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('occupancy_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="additional_description" class="form-label">Additional Description</label>
                    <textarea name="additional_description" id="additional_description" rows="3"
                              class="form-control @error('additional_description') is-invalid @enderror"
                              placeholder="Notes about the room or requirements">{{ old('additional_description', $isEdit ? $booking->additional_description : '') }}</textarea>
                    @error('additional_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Payment &amp; Charges</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
              <div class="col-md-3">
    <label class="form-label">Room Rate (auto)</label>

    <!-- Hidden value stored for backend -->
    <input type="text"
           name="room_rate"
           id="room_rate"
           value="0"
          >

    <!-- Display-only input -->
    <input type="number"
           step="0.01"
           min="0"
           id="room_rate_display"
           class="form-control"
           value="0.00"
           readonly>

    <small class="text-muted">Pulled from selected room type.</small>

    @error('room_rate')
        <div class="text-danger small mt-1">{{ $message }}</div>
    @enderror
</div>

                <div class="col-md-3">
                    <label for="discount" class="form-label">Discount (optional)</label>
                    <input type="number" step="0.01" min="0" name="discount" id="discount"
                           value="{{ old('discount', $isEdit ? $booking->discount : 0) }}"
                           class="form-control @error('discount') is-invalid @enderror"
                           placeholder="Enter discount amount">
                    @error('discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="service_charges" class="form-label">Service Charges / Tax</label>
                    <input type="number" step="0.01" min="0" name="service_charges" id="service_charges"
                           value="{{ old('service_charges', $isEdit ? $booking->service_charges : 0) }}"
                           class="form-control @error('service_charges') is-invalid @enderror"
                           placeholder="Enter service charges or tax">
                    @error('service_charges')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label class="form-label">Total Amount (auto)</label>
                    <input type="text" name="total_amount" id="total_amount_display" class="form-control" value="{{ number_format($initialTotal, 2, '.', '') }}" readonly>
                   

                    
                </div>
                <div class="col-md-4">
                    <label for="payment_type" class="form-label">Payment Type <span class="text-danger">*</span></label>
                    <select name="payment_type" id="payment_type"
                            class="form-select @error('payment_type') is-invalid @enderror" required>
                        @foreach($paymentTypeOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('payment_type', $isEdit ? $booking->payment_type : 'cash') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('payment_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="payment_status" class="form-label">Payment Status <span class="text-danger">*</span></label>
                    <select name="payment_status" id="payment_status"
                            class="form-select @error('payment_status') is-invalid @enderror" required>
                        @foreach($paymentStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('payment_status', $isEdit ? $booking->payment_status : 'pending') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="payment_details" class="form-label">Payment Details</label>
                    <textarea name="payment_details" id="payment_details" rows="3"
                              class="form-control @error('payment_details') is-invalid @enderror"
                              placeholder="Transaction reference, notes, etc.">{{ old('payment_details', $isEdit ? $booking->payment_details : '') }}</textarea>
                    @error('payment_details')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h4 class="card-title mb-0">Booking Management</h4>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="is_repeat_customer" class="form-label">Customer Listed (Repeat Customer?) <span class="text-danger">*</span></label>
                    <select name="is_repeat_customer" id="is_repeat_customer"
                            class="form-select @error('is_repeat_customer') is-invalid @enderror" required>
                        <option value="0" {{ (int) old('is_repeat_customer', $isEdit ? (int) $booking->is_repeat_customer : 0) === 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ (int) old('is_repeat_customer', $isEdit ? (int) $booking->is_repeat_customer : 0) === 1 ? 'selected' : '' }}>Yes</option>
                    </select>
                    @error('is_repeat_customer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="booking_status" class="form-label">Booking Status <span class="text-danger">*</span></label>
                    <select name="booking_status" id="booking_status"
                            class="form-select @error('booking_status') is-invalid @enderror" required>
                        @foreach($bookingStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('booking_status', $isEdit ? $booking->booking_status : 'pending') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <input type="hidden" name="booking_status_change" id="booking_status_change" value="0">
                    @error('booking_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12">
                    <label for="notes" class="form-label">Notes / Remarks</label>
                    <textarea name="notes" id="notes" rows="3"
                              class="form-control @error('notes') is-invalid @enderror"
                              placeholder="Internal notes that help during check-in/out">{{ old('notes', $isEdit ? $booking->notes : '') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('bookings.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to Reports
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="fa-solid fa-paper-plane me-2"></i>{{ $submitLabel }}
        </button>
    </div>
</form>

<!-- <script>
(() => {
    const roomTypeSelect = document.getElementById('room_type_id');
    const roomRateHidden = document.getElementById('room_rate');
    const roomRateDisplay = document.getElementById('room_rate_display');
    const discountInput = document.getElementById('discount');
    const serviceInput = document.getElementById('service_charges');
    const totalInput = document.getElementById('total_amount_display');
    const roomSelect = document.getElementById('room_id');
    const checkInInput = document.getElementById('check_in_at');
    const checkOutInput = document.getElementById('check_out_at');
    const bookingTypeSelect = document.getElementById('booking_type');
    const roomStatus = document.getElementById('room_status');
    const roomLocation = document.getElementById('room_location');

    if (!roomTypeSelect || !roomRateHidden || !roomRateDisplay || !discountInput || !serviceInput || !totalInput) return;

    let hasPresetRate = roomRateHidden.dataset.hasPreset === '1';
    let allRooms = [];
    let updateTimeout = null;

    if (roomSelect) {
        allRooms = Array.from(roomSelect.options).map(opt => ({
            value: opt.value,
            text: opt.text,
            selected: opt.selected
        }));
    }

    const toFloat = (value) => {
        const parsed = parseFloat(value);
        return Number.isNaN(parsed) ? 0 : parsed;
    };

    const setRoomRate = (value) => {
        const normalized = toFloat(value);
        roomRateHidden.value = normalized.toFixed(2);
        roomRateDisplay.value = normalized.toFixed(2);
    };

    const currentRoomRate = () => toFloat(roomRateHidden.value);

    const updateTotals = () => {
        const discount = toFloat(discountInput.value);
        const service = toFloat(serviceInput.value);
        const total = Math.max(0, (currentRoomRate() - discount) + service);
        totalInput.value = total.toFixed(2);
    };

    const syncRateWithRoomType = (force = false) => {
        if (!force && hasPresetRate) {
            updateTotals();
            return;
        }
        const option = roomTypeSelect.options[roomTypeSelect.selectedIndex];
        const rateFromType = option ? toFloat(option.dataset.rate || 0) : 0;
        setRoomRate(rateFromType);
        updateTotals();
    };

    // -------------------------
    // Fetch rooms based on 3 filters
    // -------------------------
    const updateAvailableRooms = async () => {
        if (!roomSelect) return;

        const roomTypeId = roomTypeSelect.value;
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;

        // If any is empty, restore all rooms
        if (!roomTypeId || !checkIn || !checkOut) {
            restoreAllRooms();
            return;
        }

        // Validate dates
        if (new Date(checkOut) <= new Date(checkIn)) {
            restoreAllRooms();
            return;
        }

        try {
            const excludeBookingId = roomSelect.dataset.excludeBookingId || null;
            const url = new URL('{{ route("bookings.available-rooms") }}', window.location.origin);

            url.searchParams.append('room_type_id', roomTypeId);
            url.searchParams.append('check_in_at', checkIn);
            url.searchParams.append('check_out_at', checkOut);
            if (excludeBookingId) url.searchParams.append('exclude_booking_id', excludeBookingId);

            const response = await fetch(url, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            });

            const data = await response.json();
            const currentSelected = roomSelect.value;

            roomSelect.innerHTML = '<option value="">Select Room</option>';

            data.rooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.id;
                option.textContent = room.room_no;
                if (currentSelected && currentSelected === String(room.id)) option.selected = true;
                roomSelect.appendChild(option);
            });

        } catch (error) {
            console.error('Error fetching rooms:', error);
            restoreAllRooms();
        }
    };

    const restoreAllRooms = () => {
        if (!roomSelect || allRooms.length === 0) return;
        const currentSelected = roomSelect.value;
        roomSelect.innerHTML = '<option value="">Select Room</option>';

        allRooms.forEach(room => {
            if (!room.value) return;
            const option = document.createElement('option');
            option.value = room.value;
            option.textContent = room.text;
            if (room.selected || currentSelected === room.value) option.selected = true;
            roomSelect.appendChild(option);
        });
    };

    const debouncedUpdateRooms = () => {
        if (updateTimeout) clearTimeout(updateTimeout);
        updateTimeout = setTimeout(updateAvailableRooms, 500);
    };

    // -------------------------
    // Listeners
    // -------------------------
    roomTypeSelect.addEventListener('change', () => {
        hasPresetRate = false;
        syncRateWithRoomType(true);
        debouncedUpdateRooms();
    });

    checkInInput.addEventListener('change', debouncedUpdateRooms);
    checkOutInput.addEventListener('change', debouncedUpdateRooms);

    discountInput.addEventListener('input', updateTotals);
    serviceInput.addEventListener('input', updateTotals);

    // Room details
    if (roomSelect) {
        roomSelect.addEventListener('change', function () {
            const roomId = this.value;
            if (!roomId) {
                roomStatus.value = "";
                roomLocation.value = "";
                return;
            }
            fetch(`/admin/get-room-details/${roomId}`)
                .then(res => res.json())
                .then(data => {
                    roomStatus.value = data.room_status ?? '';
                    roomLocation.value = data.location ?? '';
                    room_rate_display.value = data.base_rate ?? '';
                    roomRateHidden.value=data.base_rate ?? '';
                    occupancy_status.value = data.occupancy_status ?? '';
                })
                .catch(err => console.error(err));
        });
    }

    // Location → Load room types
    document.getElementById('location').addEventListener('change', function () {
        let locationId = this.value;
        document.getElementById('room_type_id').innerHTML = '<option value="">Select Type</option>';
        document.getElementById('room_id').innerHTML = '<option value="">Select Room</option>';
        if (!locationId) return;

        fetch(`/get-room-types/${locationId}`)
            .then(res => res.json())
            .then(data => {
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.room_type_id;
                    opt.textContent = item.type?.name ?? "Room Type";
                    document.getElementById('room_type_id').appendChild(opt);
                });
            });
    });



const locationSelect = document.getElementById('location');


const paymentType = document.getElementById('payment_type');
const paymentStatus = document.getElementById('payment_status');
const paymentDetails = document.getElementById('payment_details');
    function resetBookingFields() {
    if (locationSelect) locationSelect.value = '';
    if (roomTypeSelect) roomTypeSelect.value = '';
    if (roomSelect) roomSelect.value = '';
    if (roomStatus) roomStatus.value = '';
    if (roomLocation) roomLocation.value = '';
    if (discountInput) discountInput.value = '';
    if (serviceInput) serviceInput.value = '';
    if (totalInput) totalInput.value = '';
    if (paymentType) paymentType.value = '';
    if (paymentStatus) paymentStatus.value = '';
    if (paymentDetails) paymentDetails.value = '';
}
if (checkInInput) checkInInput.addEventListener('change', resetBookingFields);
if (checkOutInput) checkOutInput.addEventListener('change', resetBookingFields);

    syncRateWithRoomType(false);
})();
</script> -->


<script>
(() => {
    const roomTypeSelect = document.getElementById('room_type_id');
    const roomRateHidden = document.getElementById('room_rate');
    const roomRateDisplay = document.getElementById('room_rate_display');
    const discountInput = document.getElementById('discount');
    const serviceInput = document.getElementById('service_charges');
    const totalInput = document.getElementById('total_amount_display');
    const roomSelect = document.getElementById('room_id');
    const checkInInput = document.getElementById('check_in_at');
    const checkOutInput = document.getElementById('check_out_at');
    const bookingTypeSelect = document.getElementById('booking_type');
    const roomStatus = document.getElementById('room_status');
    const roomLocation = document.getElementById('room_location');
    const occupancyStatus = document.getElementById('occupancy_status');
    const locationElem = document.getElementById('location');

    if (!roomTypeSelect || !roomRateHidden || !roomRateDisplay || !discountInput || !serviceInput || !totalInput) return;

    let hasPresetRate = roomRateHidden.dataset.hasPreset === '1';
    let allRooms = [];
    let updateTimeout = null;

    if (roomSelect) {
        allRooms = Array.from(roomSelect.options).map(opt => ({
            value: opt.value,
            text: opt.text,
            selected: opt.selected,
            base_rate: opt.getAttribute('data-base-rate') || 0
        }));
    }



    const toFloat = (value) => {
        const parsed = parseFloat(value);
        return Number.isNaN(parsed) ? 0 : parsed;
    };

  const setRoomRate = (value) => {
    const normalized = toFloat(value);

    // Always update both inputs
    // roomRateHidden.value = normalized.toFixed(2);
    // roomRateDisplay.value = normalized.toFixed(2);
};

    const currentRoomRate = () => toFloat(roomRateHidden.value);

    const updateTotals = () => {
        const discount = toFloat(discountInput.value);
        const service = toFloat(serviceInput.value);
        const total = Math.max(0, (currentRoomRate() - discount) + service);
        totalInput.value = total.toFixed(2);
    };

   const syncRateWithRoomType = (force = false) => {
    const option = roomTypeSelect.options[roomTypeSelect.selectedIndex];
    const rateFromType = option ? toFloat(option.dataset.rate || 0) : 0;

    // Always update both fields first
    setRoomRate(rateFromType);

    // If preset exists, still keep updated value
    if (!force && hasPresetRate) {
        updateTotals();
        return;
    }

    updateTotals();
};

    // Fetch available rooms
    const updateAvailableRooms = async () => {
        if (!roomSelect) return;

        const roomTypeId = roomTypeSelect.value;
        const locationId = locationElem.value;
        const checkIn = checkInInput.value;
        const checkOut = checkOutInput.value;
        const currentSelectedRoom = roomSelect.value; // Store current selection

        if (!roomTypeId || !checkIn || !checkOut || !locationId) {
            restoreAllRooms();
            return;
        }

        if (new Date(checkOut) <= new Date(checkIn)) {
            restoreAllRooms();
            return;
        }

        try {
            const excludeBookingId = roomSelect.dataset.excludeBookingId || null;
            const url = new URL('{{ route("bookings.available-rooms") }}', window.location.origin);
            url.searchParams.append('location_id', locationId);
            url.searchParams.append('room_type_id', roomTypeId);

            url.searchParams.append('check_in_at', checkIn);
            url.searchParams.append('check_out_at', checkOut);
            if (excludeBookingId) url.searchParams.append('exclude_booking_id', excludeBookingId);

            const response = await fetch(url, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();

            roomSelect.innerHTML = '<option value="">Select Room</option>';
            const rooms = Array.isArray(data.rooms) ? data.rooms : (data || []);
            rooms.forEach(room => {
                const option = document.createElement('option');
                option.value = room.id;
                 // Add base_rate here (IMPORTANT)
                option.dataset.rate = room.base_rate ?? 0;
                option.textContent = room.room_no ?? room.name ?? `Room ${room.id}`;
                // Re-select the previously selected room if it's still available
                if (currentSelectedRoom && currentSelectedRoom === String(room.id)) {
                    option.selected = true;
                }
                roomSelect.appendChild(option);
            });

        } catch (error) {
            console.error('Error fetching rooms:', error);
            restoreAllRooms();
        }
    };

    const restoreAllRooms = () => {
        if (!roomSelect || allRooms.length === 0) return;
        const currentSelected = roomSelect.value;
        roomSelect.innerHTML = '<option value="">Select Room</option>';

        allRooms.forEach(room => {
            if (!room.value) return;
            const option = document.createElement('option');
            option.value = room.value;
            option.textContent = room.text;
            if (room.selected || currentSelected === room.value) option.selected = true;
            roomSelect.appendChild(option);
        });
    };

    const debouncedUpdateRooms = () => {
        if (updateTimeout) clearTimeout(updateTimeout);
        updateTimeout = setTimeout(updateAvailableRooms, 500);
    };

    // Listeners
    if (roomTypeSelect) {
        roomTypeSelect.addEventListener('change', () => {
            hasPresetRate = false;
            syncRateWithRoomType(true);
            debouncedUpdateRooms();
        });
    }

    if (checkInInput) checkInInput.addEventListener('change', debouncedUpdateRooms);
    if (checkOutInput) checkOutInput.addEventListener('change', debouncedUpdateRooms);

    if (discountInput) discountInput.addEventListener('input', updateTotals);
    if (serviceInput) serviceInput.addEventListener('input', updateTotals);

    // Room details
    if (roomSelect) {
        roomSelect.addEventListener('change', function () {
            const roomId = this.value;
            if (!roomId) {
                if (roomStatus) roomStatus.value = "";
                if (roomLocation) roomLocation.value = "";
                if (occupancyStatus) occupancyStatus.value = "";
                return;
            }
            fetch(`/admin/get-room-details/${roomId}`, { 
                credentials: 'same-origin', 
                headers: {'X-Requested-With':'XMLHttpRequest','Accept':'application/json'} 
            })
                .then(res => {
                    if (!res.ok) throw new Error('Failed to fetch room details');
                    return res.json();
                })
                .then(data => {
                    if (roomStatus) roomStatus.value = data.room_status ?? '';
                    if (roomLocation) roomLocation.value = data.location ?? '';
                    if (occupancyStatus) occupancyStatus.value = data.occupancy_status ?? '';
                    if (typeof data.base_rate !== 'undefined') {
                        setRoomRate(data.base_rate);
                    }
                    updateTotals();
                })
                .catch(err => console.error(err));
        });
    }

    // Location → Load room types
    if (locationElem) {
        locationElem.addEventListener('change', function () {
            const locationId = this.value;
            roomTypeSelect.innerHTML = '<option value="">Select Type</option>';
            if (roomSelect) roomSelect.innerHTML = '<option value="">Select Room</option>';
            if (!locationId) return;

            fetch(`/get-room-types/${locationId}`, { 
                credentials: 'same-origin', 
                headers: {'X-Requested-With':'XMLHttpRequest','Accept':'application/json'} 
            })
                .then(res => {
                    if (!res.ok) throw new Error('Failed to load room types');
                    return res.json();
                })
                .then(data => {
                    const list = Array.isArray(data) ? data : (data.room_types || []);
                                if (!list.length) {
            const opt = document.createElement('option');
            opt.value = "";
            opt.disabled = true;
            opt.textContent = "No room types available";
            roomTypeSelect.appendChild(opt);
            return;
            }
                    list.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item.room_type_id ?? item.id ?? '';
                        opt.textContent = item.type?.name ?? item.name ?? 'Room Type';
                        roomTypeSelect.appendChild(opt);
                    });
                    syncRateWithRoomType(true);
                })
                .catch(err => console.error(err));
        });
    }

    const paymentType = document.getElementById('payment_type');
    const paymentStatus = document.getElementById('payment_status');
    const paymentDetails = document.getElementById('payment_details');

    function resetBookingFields() {
        // REMOVED: locationElem, roomTypeSelect, roomSelect - these now persist
        if (roomStatus) roomStatus.value = '';
        if (roomLocation) roomLocation.value = '';
        if (occupancyStatus) occupancyStatus.value = '';
        if (discountInput) discountInput.value = '';
        if (serviceInput) serviceInput.value = '';
        if (totalInput) totalInput.value = '';
        if (paymentType) paymentType.value = '';
        if (paymentStatus) paymentStatus.value = '';
        if (paymentDetails) paymentDetails.value = '';
    }

    if (checkInInput) checkInInput.addEventListener('change', resetBookingFields);
    if (checkOutInput) checkOutInput.addEventListener('change', resetBookingFields);

    // Initialize form on page load for edit mode
    const initializeFormOnLoad = async () => {
        const locationId = locationElem?.value;
        const roomTypeId = roomTypeSelect?.value;
        const roomId = roomSelect?.value;

        // If location is selected, load room types
        if (locationId && locationElem) {
            try {
                const res = await fetch(`/get-room-types/${locationId}`, {
                    credentials: 'same-origin',
                    headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                });
                if (!res.ok) throw new Error('Failed to load room types');
                const data = await res.json();
                const list = Array.isArray(data) ? data : (data.room_types || []);
                
                roomTypeSelect.innerHTML = '<option value="">Select Type</option>';


                list.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.room_type_id ?? item.id ?? '';
                    opt.textContent = item.type?.name ?? item.name ?? 'Room Type';
                    
                    if (opt.value === String(roomTypeId)) opt.selected = true;
                    roomTypeSelect.appendChild(opt);
                });
                syncRateWithRoomType(true);
            } catch (err) {
                console.error('Error loading room types:', err);
            }
        }

        // If room type and dates are selected, load available rooms
        if (roomTypeId && checkInInput.value && checkOutInput.value) {
            try {
                const excludeBookingId = roomSelect.dataset.excludeBookingId || null;
                const url = new URL('{{ route("bookings.available-rooms") }}', window.location.origin);
               url.searchParams.append('location_id', locationId);
                url.searchParams.append('room_type_id', roomTypeId);
                url.searchParams.append('check_in_at', checkInInput.value);
                url.searchParams.append('check_out_at', checkOutInput.value);
                if (excludeBookingId) url.searchParams.append('exclude_booking_id', excludeBookingId);

                const res = await fetch(url, {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                    credentials: 'same-origin'
                });
                if (!res.ok) throw new Error('Failed to load rooms');
                const data = await res.json();
                const rooms = Array.isArray(data.rooms) ? data.rooms : (data || []);

                roomSelect.innerHTML = '<option value="">Select Room</option>';
                if (!rooms.length) {
    const opt = document.createElement('option');
    opt.value = "";
    opt.disabled = true;
    opt.textContent = "No rooms available";
    roomSelect.appendChild(opt);
    return;
}
              rooms.forEach(room => {
    const option = document.createElement('option');
    option.value = room.id;
    option.textContent = room.room_no ?? room.name ?? `Room ${room.id}`;

    // Add base_rate here (IMPORTANT)
    option.dataset.rate = room.base_rate ?? 0;

    if (currentSelectedRoom && currentSelectedRoom === String(room.id)) {
        option.selected = true;
    }
    roomSelect.appendChild(option);
});

                // Trigger room details load if room is selected
                if (roomId) {
                    roomSelect.dispatchEvent(new Event('change'));
                }
            } catch (err) {
                console.error('Error loading rooms:', err);
            }
        }
    };

    // Call on page load
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeFormOnLoad);
    } else {
        initializeFormOnLoad();
    }

    syncRateWithRoomType(false);
})();
</script>



<script>
(() => {
    const idProofTypeSelect = document.getElementById('id_proof_type');
    const idNumberInput = document.getElementById('id_number');

    if (!idProofTypeSelect || !idNumberInput) return;

    // Define validation rules for each ID proof type
    const idValidationRules = {
        'passport': {
            pattern: /^[A-Z0-9]{6,9}$/,
            minLength: 6,
            maxLength: 9,
            message: 'Passport must be 6-9 alphanumeric characters'
        },
        'aadhar': {
            pattern: /^[0-9]{12}$/,
            minLength: 12,
            maxLength: 12,
            message: 'Aadhar must be exactly 12 digits'
        },
        'pan': {
            pattern: /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/,
            minLength: 10,
            maxLength: 10,
            message: 'PAN format: 5 letters, 4 digits, 1 letter (e.g., ABCDE1234F)'
        },
        'driving_license': {
            pattern: /^[A-Z0-9]{8,20}$/,
            minLength: 8,
            maxLength: 20,
            message: 'Driving License must be 8-20 alphanumeric characters'
        },
        'voter_id': {
            pattern: /^[A-Z]{3}[0-9]{7}$/,
            minLength: 10,
            maxLength: 10,
            message: 'Voter ID format: 3 letters followed by 7 digits'
        }
    };

    const validateIdNumber = () => {
        const proofType = idProofTypeSelect.value;
        const idValue = idNumberInput.value.trim();

        // Clear previous error state
        idNumberInput.classList.remove('is-invalid');
        const existingError = idNumberInput.parentElement.querySelector('.invalid-feedback');
        if (existingError) existingError.remove();

        // If no proof type selected or ID is empty, skip validation
        if (!proofType || !idValue) return true;

        const rule = idValidationRules[proofType];
        
        if (!rule) {
            console.warn(`No validation rule for ID proof type: ${proofType}`);
            return true;
        }

        // Check length
        if (idValue.length < rule.minLength || idValue.length > rule.maxLength) {
            showIdError(`${rule.message}`);
            return false;
        }

        // Check pattern
        if (!rule.pattern.test(idValue)) {
            showIdError(`${rule.message}`);
            return false;
        }

        return true;
    };

    const showIdError = (message) => {
        idNumberInput.classList.add('is-invalid');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback';
        errorDiv.textContent = message;
        idNumberInput.parentElement.appendChild(errorDiv);
    };

    // Validate on ID Proof Type change
    idProofTypeSelect.addEventListener('change', () => {
        idNumberInput.value = ''; // Clear ID when proof type changes
        idNumberInput.classList.remove('is-invalid');
        const existingError = idNumberInput.parentElement.querySelector('.invalid-feedback');
        if (existingError) existingError.remove();
    });

    // Validate on ID Number input
    idNumberInput.addEventListener('blur', validateIdNumber);
    idNumberInput.addEventListener('input', validateIdNumber);

    // Validate on form submit
    const form = idNumberInput.closest('form');
    if (form) {
        form.addEventListener('submit', (e) => {
            if (!validateIdNumber()) {
                e.preventDefault();
                idNumberInput.focus();
            }
        });
    }
})();

const bookingStatus = document.getElementById('booking_status');

if (bookingStatus) {
    bookingStatus.addEventListener('change', booking_status_change);
}

function booking_status_change() {
    

    // Example: clear some fields
    document.getElementById('booking_status_change').value = '1';
  
}

</script>




