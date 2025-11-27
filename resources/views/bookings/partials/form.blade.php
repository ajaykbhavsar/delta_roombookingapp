@php
    $booking = $booking ?? null;
    $isEdit = $booking !== null;
    $formAction = $isEdit ? route('bookings.update', $booking) : route('bookings.store');
    $defaultRoomTypeId = old('room_type_id', $isEdit ? $booking->room_type_id : ($roomTypes->first()->id ?? null));

    $roomRateValue = old('room_rate');
    $hasPresetRoomRate = true;

    if ($roomRateValue === null) {
        if ($isEdit && $booking->room_rate !== null) {
            $roomRateValue = $booking->room_rate;
            $hasPresetRoomRate = true;
        } else {
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
                    <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $isEdit ? $booking->phone_number : '') }}"
                           class="form-control @error('phone_number') is-invalid @enderror"
                           placeholder="Enter phone number" required>
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="email" class="form-label">Email (optional)</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $isEdit ? $booking->email : '') }}"
                           class="form-control @error('email') is-invalid @enderror" placeholder="guest@example.com">
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
                    <label for="room_id" class="form-label">Room Number <span class="text-danger">*</span></label>
                    <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror"
                            data-exclude-booking-id="{{ $isEdit && isset($booking) ? $booking->id : '' }}"
                            required>
                        <option value="">Select Room</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ (string) old('room_id', $isEdit ? $booking->room_id : '') === (string) $room->id ? 'selected' : '' }}>
                                {{ $room->room_no }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="room_type_id" class="form-label">Room Type <span class="text-danger">*</span></label>
                    <select name="room_type_id" id="room_type_id" class="form-select @error('room_type_id') is-invalid @enderror" required>
                        <option value="">Select Type</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}"
                                    data-rate="{{ $type->base_rate }}"
                                    {{ (string) $defaultRoomTypeId === (string) $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_type_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="location" class="form-label">Location / Floor <span class="text-danger">*</span></label>
                    <select name="location" id="location" class="form-select @error('location') is-invalid @enderror" required>
                        @foreach($locationOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('location', $isEdit ? $booking->location : array_key_first($locationOptions)) === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="room_status" class="form-label">Room Status <span class="text-danger">*</span></label>
                    <select name="room_status" id="room_status" class="form-select @error('room_status') is-invalid @enderror" required>
                        @foreach($roomStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('room_status', $isEdit ? $booking->room_status : 'clean') === $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('room_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-md-8">
                <label for="room_location" class="form-label">Room Location <span class="text-danger">*</span></label>
                <textarea name="room_location" id="room_location"
                class="form-control @error('room_location') is-invalid @enderror"
                rows="3"
                >{{ old('room_location', $isEdit ? $booking->room_location : '') }}</textarea>

                @error('room_location')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                </div>
                <div class="col-md-4">
                    <label for="occupancy_status" class="form-label">Occupancy Status <span class="text-danger">*</span></label>
                    <select name="occupancy_status" id="occupancy_status"
                            class="form-select @error('occupancy_status') is-invalid @enderror" required>
                        @foreach($occupancyStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ old('occupancy_status', $isEdit ? $booking->occupancy_status : 'empty') === $value ? 'selected' : '' }}>
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
                    <input type="hidden" name="room_rate" id="room_rate"
                           value="{{ number_format($roomRateValue, 2, '.', '') }}"
                           data-has-preset="{{ $hasPresetRoomRate ? '1' : '0' }}">
                    <input type="number" step="0.01" min="0" id="room_rate_display" class="form-control"
                           value="{{ number_format($roomRateValue, 2, '.', '') }}" readonly>
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
                    <input type="text" id="total_amount_display" class="form-control" value="{{ number_format($initialTotal, 2, '.', '') }}" readonly>
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

        if (!roomTypeSelect || !roomRateHidden || !roomRateDisplay || !discountInput || !serviceInput || !totalInput) {
            return;
        }

        let hasPresetRate = roomRateHidden.dataset.hasPreset === '1';
        let allRooms = [];
        let updateTimeout = null;

        // Store all initial room options
        if (roomSelect) {
            allRooms = Array.from(roomSelect.options).map(opt => ({
                value: opt.value,
                text: opt.text,
                selected: opt.selected
            }));
        }

        const toFloat = (value) => {
            const parsed = typeof value === 'number' ? value : parseFloat(value);
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

        const updateAvailableRooms = async () => {
            if (!roomSelect || !checkInInput || !checkOutInput) {
                return;
            }

            const checkIn = checkInInput.value;
            const checkOut = checkOutInput.value;

            // If both dates are not filled, show all rooms
            if (!checkIn || !checkOut) {
                restoreAllRooms();
                return;
            }

            // Validate that check-out is after check-in
            if (new Date(checkOut) <= new Date(checkIn)) {
                restoreAllRooms();
                return;
            }

            try {
                const excludeBookingId = roomSelect.dataset.excludeBookingId || null;
                const url = new URL('{{ route("bookings.available-rooms") }}', window.location.origin);
                url.searchParams.append('check_in_at', checkIn);
                url.searchParams.append('check_out_at', checkOut);
                if (excludeBookingId) {
                    url.searchParams.append('exclude_booking_id', excludeBookingId);
                }

                const response = await fetch(url, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                const contentType = response.headers.get('content-type') || '';
                if (!response.ok || !contentType.includes('application/json')) {
                    const errorBody = await response.text();
                    throw new Error(`Unexpected response (${response.status}): ${errorBody.substring(0, 120)}`);
                }

                const data = await response.json();

                // Store currently selected room
                const currentSelected = roomSelect.value;

                // Clear and repopulate room select
                roomSelect.innerHTML = '<option value="">Select Room</option>';

                data.rooms.forEach(room => {
                    const option = document.createElement('option');
                    option.value = room.id;
                    option.textContent = room.room_no;
                    if (currentSelected && currentSelected === String(room.id)) {
                        option.selected = true;
                    }
                    roomSelect.appendChild(option);
                });

                // If previously selected room is no longer available, show warning
                if (currentSelected && !data.rooms.find(r => String(r.id) === currentSelected)) {
                    roomSelect.classList.add('is-invalid');
                    const feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    feedback.textContent = 'This room is not available for the selected dates.';
                    if (!roomSelect.nextElementSibling || !roomSelect.nextElementSibling.classList.contains('invalid-feedback')) {
                        roomSelect.parentNode.insertBefore(feedback, roomSelect.nextSibling);
                    }
                } else {
                    roomSelect.classList.remove('is-invalid');
                    const feedback = roomSelect.nextElementSibling;
                    if (feedback && feedback.classList.contains('invalid-feedback') && feedback.textContent.includes('not available')) {
                        feedback.remove();
                    }
                }
            } catch (error) {
                console.error('Error fetching available rooms:', error);
                restoreAllRooms();
            }
        };

        const restoreAllRooms = () => {
            if (!roomSelect || allRooms.length === 0) {
                return;
            }

            const currentSelected = roomSelect.value;
            roomSelect.innerHTML = '<option value="">Select Room</option>';

            allRooms.forEach(room => {
                if (room.value) { // Skip empty option
                    const option = document.createElement('option');
                    option.value = room.value;
                    option.textContent = room.text;
                    if (room.selected || currentSelected === room.value) {
                        option.selected = true;
                    }
                    roomSelect.appendChild(option);
                }
            });

            roomSelect.classList.remove('is-invalid');
            const feedback = roomSelect.nextElementSibling;
            if (feedback && feedback.classList.contains('invalid-feedback') && feedback.textContent.includes('not available')) {
                feedback.remove();
            }
        };

        // Debounce room updates to avoid too many API calls
        const debouncedUpdateRooms = () => {
            if (updateTimeout) {
                clearTimeout(updateTimeout);
            }
            updateTimeout = setTimeout(updateAvailableRooms, 500);
        };

        roomTypeSelect.addEventListener('change', () => {
            hasPresetRate = false;
            syncRateWithRoomType(true);
        });

        discountInput.addEventListener('input', updateTotals);
        serviceInput.addEventListener('input', updateTotals);

        const normalizeDateValue = (value, targetType) => {
            if (!value) {
                return '';
            }

            if (targetType === 'date') {
                return value.split('T')[0] ?? value;
            }

            // target datetime-local
            if (value.includes('T')) {
                return value;
            }

            return `${value}T12:00`;
        };

        const syncDateInputsWithBookingType = () => {
            if (!bookingTypeSelect || !checkInInput || !checkOutInput) {
                return;
            }

            const type = bookingTypeSelect.value || 'daily';
            const useDateOnly = type === 'weekly' || type === 'monthly';
            const desiredType = useDateOnly ? 'date' : 'datetime-local';

            [checkInInput, checkOutInput].forEach((input) => {
                if (input.type !== desiredType) {
                    const newValue = normalizeDateValue(input.value, desiredType);
                    input.type = desiredType;
                    input.value = newValue;
                }
                input.placeholder = useDateOnly
                    ? 'Select date'
                    : 'Select date and time';
            });

            debouncedUpdateRooms();
        };

        if (bookingTypeSelect) {
            bookingTypeSelect.addEventListener('change', () => {
                syncDateInputsWithBookingType();
            });

            // Initialize once
            syncDateInputsWithBookingType();
        }

        // Listen for date changes to update available rooms
        if (checkInInput && checkOutInput) {
            checkInInput.addEventListener('change', debouncedUpdateRooms);
            checkOutInput.addEventListener('change', debouncedUpdateRooms);
            checkInInput.addEventListener('input', debouncedUpdateRooms);
            checkOutInput.addEventListener('input', debouncedUpdateRooms);

            // Check if dates are already filled on page load (e.g., after validation errors)
            // and filter rooms accordingly
            if (checkInInput.value && checkOutInput.value) {
                // Small delay to ensure DOM is ready
                setTimeout(() => {
                    updateAvailableRooms();
                }, 100);
            }
        }


        // --------------------------
// Fetch Room Details on Select
// --------------------------
if (roomSelect) {
    roomSelect.addEventListener('change', function () {
        const roomId = this.value;

        if (!roomId) {
            roomStatus.value = "";
            roomLocation.value = "";
            return;
        }

        fetch(`/admin/get-room-details/${roomId}`)
            .then(response => response.json())
            .then(data => {
                // Set room_status (select)
                if (roomStatus) {
                    roomStatus.value = data.room_status ?? '';
                }

                // Set room_location (textarea)
                if (roomLocation) {
                    roomLocation.value = data.location ?? '';
                }
            })
            .catch(error => console.error('Error fetching room details:', error));
    });
}

        syncRateWithRoomType(false);
    })();
</script>

