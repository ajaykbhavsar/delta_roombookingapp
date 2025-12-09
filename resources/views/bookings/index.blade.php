<x-sneat-admin-layout>
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-0">Room Booking Reports</h4>
                <small class="text-muted">Users can review their own submissions. Admins see every booking.</small>
 {{-- Total Bookings (filtered count) --}}
 <p><span class="badge bg-primary">Total Records: {{ $bookings->total() }}</span></p>
            </div>
            @can('create', \App\Models\Booking::class)
                <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus me-2"></i>New Booking
                </a>
            @endcan
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('bookings.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="search" class="form-label">Search</label>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}"
                           class="form-control" placeholder="Guest / phone / reference">
                </div>
                <div class="col-md-2">
                    <label for="room_type_id" class="form-label">Room Type</label>
                    <select name="room_type_id" id="room_type_id" class="form-select">
                        <option value="">All</option>
                        @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ ($filters['room_type_id'] ?? '') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="room_id" class="form-label">Room Number</label>
                    <select name="room_id" id="room_id" class="form-select">
                        <option value="">All</option>
                        @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ ($filters['room_id'] ?? '') == $room->id ? 'selected' : '' }}>
                                {{ $room->room_no }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="booking_status" class="form-label">Booking Status</label>
                    <select name="booking_status" id="booking_status" class="form-select">
                        <option value="">All</option>
                        @foreach($bookingStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ ($filters['booking_status'] ?? '') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="payment_status" class="form-label">Payment Status</label>
                    <select name="payment_status" id="payment_status" class="form-select">
                        <option value="">All</option>
                        @foreach($paymentStatusOptions as $value => $label)
                            <option value="{{ $value }}" {{ ($filters['payment_status'] ?? '') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="payment_type" class="form-label">Payment Type</label>
                    <select name="payment_type" id="payment_type" class="form-select">
                        <option value="">All</option>
                        @foreach($paymentTypeOptions as $value => $label)
                            <option value="{{ $value }}" {{ ($filters['payment_type'] ?? '') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="check_in_from" class="form-label">Check-in From</label>
                    <input type="date" name="check_in_from" id="check_in_from" value="{{ $filters['check_in_from'] ?? '' }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label for="check_in_to" class="form-label">Check-in To</label>
                    <input type="date" name="check_in_to" id="check_in_to" value="{{ $filters['check_in_to'] ?? '' }}" class="form-control">
                </div>
                <div class="col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 btnone">
                        <i class="fa-solid fa-filter me-2"></i>Apply
                    </button>
                    <a href="{{ route('bookings.index') }}" class="btnone btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($bookings->isEmpty())
                <div class="text-center py-5">
                    <i class="fa-solid fa-bed fa-3x text-muted mb-3"></i>
                    <h5 class="mb-2">No bookings found</h5>
                    <p class="text-muted mb-4">Adjust your filters or create a new booking report.</p>
                   
                        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                            <i class="fa-solid fa-plus me-2"></i>Create Booking
                        </a>
                   
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Guest</th>
                                <th>Room</th>
                                <th>Stay</th>
                                <th>Payment</th>
                                <th>Status</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                                @php
                                    $bookingBadge = match($booking->booking_status) {
                                        'confirmed' => 'bg-success',
                                        'checked_in' => 'bg-info',
                                        'checked_out' => 'bg-dark',
                                        'cancelled' => 'bg-danger',
                                        'pending' => 'bg-warning text-dark',
                                        default => 'bg-secondary',
                                    };
                                    $paymentBadge = match($booking->payment_status) {
                                        'paid' => 'bg-success',
                                        'partially_paid' => 'bg-warning text-dark',
                                        'pending' => 'bg-secondary',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <tr>
                                    <td>
                                        <strong>{{ $booking->reference_no }}</strong><br>
                                        <small class="text-muted">{{ $booking->created_at->format('M d, Y H:i') }}</small>
                                    </td>
                                    <td>
                                        {{ $booking->first_name }} {{ $booking->last_name }}<br>
                                        <small class="text-muted">{{ $booking->phone_number }}</small>
                                    </td>
                                    <td>
                                        <strong>{{ $booking->room->room_no ?? '—' }}</strong><br>
                                        <small class="text-muted">{{ $booking->roomType->name ?? '—' }}</small>
                                    </td>
                                    <td>
                                        <div>In: {{ optional($booking->check_in_at)->format('M d, Y H:i') }}</div>
                                        <div>Out: {{ optional($booking->check_out_at)->format('M d, Y H:i') }}</div>
                                        <small class="text-muted">{{ ucfirst($booking->booking_type) }} • {{ $booking->guest_count }} guests</small>
                                    </td>
                                    <td>
                                        <div>Total: <strong>INR {{ number_format($booking->total_amount, 2) }}</strong></div>
                                        <span class="badge {{ $paymentBadge }}">{{ \Illuminate\Support\Str::headline($booking->payment_status) }}</span>
                                        <div class="text-muted small">{{ \Illuminate\Support\Str::headline($booking->payment_type) }}</div>
                                    </td>
                                    <td>
                                        <span class="badge {{ $bookingBadge }}">{{ \Illuminate\Support\Str::headline($booking->booking_status) }}</span>
                                    </td>
                                    <td>{{ucfirst($booking->creator->name)}}<br>
                                        <small class="text-muted">{{ ucfirst($booking->creator->role) }}</small></td>
                                    <td class="d-flex gap-2" style="min-height:80px;">
                                        <div>
                                        <a href="{{ route('bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        @can('update', $booking)
                                            <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-sm btn-outline-warning">
                                                <i class="fa-solid fa-pen"></i>
                                            </a>
                                        @endcan
                                </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $bookings->links() }}
                </div>
            @endif
        </div>
    </div>
      <script>
(() => {

    const roomTypeSelect = document.getElementById('room_type_id');
    const roomSelect = document.getElementById('room_id');

    if (!roomTypeSelect || !roomSelect) return;

    let updateTimeout = null;

    const debouncedUpdateRooms = () => {
        if (updateTimeout) clearTimeout(updateTimeout);
        updateTimeout = setTimeout(updateAvailableRooms, 400);
    };

    // Fetch rooms based on selected room type
    const updateAvailableRooms = async () => {
        const roomTypeId = roomTypeSelect.value;

        if (!roomTypeId) {
            roomSelect.innerHTML = `<option value="">Select Room</option>`;
            return;
        }

        try {
            const excludeBookingId = roomSelect.dataset.excludeBookingId || null;
            const url = new URL('{{ route("bookings.get-rooms") }}', window.location.origin);

            url.searchParams.append('room_type_id', roomTypeId);

            if (excludeBookingId) {
                url.searchParams.append('exclude_booking_id', excludeBookingId);
            }

            const response = await fetch(url, {
                headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
                credentials: 'same-origin'
            });

            if (!response.ok) throw new Error("Failed to load rooms");

            const data = await response.json();
            const rooms = Array.isArray(data.rooms) ? data.rooms : [];

            const selectedRoom = roomSelect.value; // keep previous selection

            roomSelect.innerHTML = `<option value="">Select Room</option>`;

            rooms.forEach(room => {
                const opt = document.createElement('option');
                opt.value = room.id;
                opt.textContent = room.room_no ?? room.name ?? `Room ${room.id}`;

                if (String(room.id) === String(selectedRoom)) {
                    opt.selected = true;
                }

                roomSelect.appendChild(opt);
            });

        } catch (e) {
            console.error(e);
        }
    };

    // Event listener
    roomTypeSelect.addEventListener('change', debouncedUpdateRooms);

})();
</script>
</x-sneat-admin-layout>


