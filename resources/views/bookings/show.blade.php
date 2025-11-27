<x-sneat-admin-layout>
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
    <div class="card mb-4">
        <div class="card-header d-flex flex-wrap gap-2 justify-content-between align-items-center">
            <div>
                <h4 class="card-title mb-1">Booking Reference: {{ $booking->reference_no }}</h4>
                <small class="text-muted">Created {{ $booking->created_at->format('M d, Y H:i') }} by {{ $booking->creator->name ?? 'System' }}</small>
            </div>
            <div class="d-flex gap-2">
                @can('update', $booking)
                    <a href="{{ route('bookings.edit', $booking) }}" class="btn btn-primary">
                        <i class="fa-solid fa-pen me-2"></i>Edit
                    </a>
                @endcan
                <a href="{{ route('bookings.index') }}" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-arrow-left me-2"></i>Back to Reports
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="text-muted small">Booking Status</label>
                    <p class="mb-0"><span class="badge {{ $bookingBadge }}">{{ \Illuminate\Support\Str::headline($booking->booking_status) }}</span></p>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Payment Status</label>
                    <p class="mb-0">
                        <span class="badge {{ $paymentBadge }}">{{ \Illuminate\Support\Str::headline($booking->payment_status) }}</span>
                        <span class="text-muted ms-2">{{ \Illuminate\Support\Str::headline($booking->payment_type) }}</span>
                    </p>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Total Amount</label>
                    <p class="mb-0 fw-semibold">INR {{ number_format($booking->total_amount, 2) }}</p>
                </div>
            </div>

            <hr>
            <h5 class="mb-3">Guest Information</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="text-muted small">Guest Name</label>
                    <p class="mb-0">{{ $booking->first_name }} {{ $booking->last_name }}</p>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Phone</label>
                    <p class="mb-0">{{ $booking->phone_number }}</p>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Email</label>
                    <p class="mb-0">{{ $booking->email ?? '—' }}</p>
                </div>
                <div class="col-md-4 mt-3">
                    <label class="text-muted small">ID Proof</label>
                    <p class="mb-0">{{ $idProofOptions[$booking->id_proof_type] ?? \Illuminate\Support\Str::headline($booking->id_proof_type) }}</p>
                </div>
                <div class="col-md-4 mt-3">
                    <label class="text-muted small">ID Number</label>
                    <p class="mb-0">{{ $booking->id_number }}</p>
                </div>
                <div class="col-12 mt-3">
                    <label class="text-muted small">Address</label>
                    <p class="mb-0">{{ $booking->address }}</p>
                </div>
            </div>

            <h5 class="mb-3">Room Information</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="text-muted small">Room Number</label>
                    <p class="mb-0">{{ $booking->room->room_no ?? '—' }}</p>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Room Type</label>
                    <p class="mb-0">{{ $booking->roomType->name ?? '—' }}</p>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Location</label>
                    <p class="mb-0">{{ $locationOptions[$booking->location] ?? \Illuminate\Support\Str::headline($booking->location) }}</p>
                </div>
                <div class="col-md-4 mt-3">
                    <label class="text-muted small">Room Status</label>
                    <p class="mb-0">{{ $roomStatusOptions[$booking->room_status] ?? \Illuminate\Support\Str::headline($booking->room_status) }}</p>
                </div>
                <div class="col-md-4 mt-3">
                    <label class="text-muted small">Room Location</label>
                    <p class="mb-0">{{ $roomStatusOptions[$booking->room_location] ?? \Illuminate\Support\Str::headline($booking->room_location) }}</p>
                </div>
                <div class="col-md-4 mt-3">
                    <label class="text-muted small">Occupancy Status</label>
                    <p class="mb-0">{{ $occupancyStatusOptions[$booking->occupancy_status] ?? \Illuminate\Support\Str::headline($booking->occupancy_status) }}</p>
                </div>
                <div class="col-12 mt-3">
                    <label class="text-muted small">Additional Description</label>
                    <p class="mb-0">{{ $booking->additional_description ?? '—' }}</p>
                </div>
            </div>

            <h5 class="mb-3">Stay Details</h5>
            <div class="row mb-4">
                <div class="col-md-4">
                    <label class="text-muted small">Booking Type</label>
                    <p class="mb-0">{{ $bookingTypeOptions[$booking->booking_type] ?? \Illuminate\Support\Str::headline($booking->booking_type) }}</p>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Check-in</label>
                    <p class="mb-0">{{ $booking->check_in_at?->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-4">
                    <label class="text-muted small">Check-out</label>
                    <p class="mb-0">{{ $booking->check_out_at?->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-4 mt-3">
                    <label class="text-muted small">Guests</label>
                    <p class="mb-0">{{ $booking->guest_count }}</p>
                </div>
                <div class="col-md-4 mt-3">
                    <label class="text-muted small">Repeat Customer</label>
                    <p class="mb-0">{{ $booking->is_repeat_customer ? 'Yes' : 'No' }}</p>
                </div>
            </div>

            <h5 class="mb-3">Payment &amp; Charges</h5>
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="text-muted small">Room Rate</label>
                    <p class="mb-0">INR {{ number_format($booking->room_rate, 2) }}</p>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Discount</label>
                    <p class="mb-0">INR {{ number_format($booking->discount, 2) }}</p>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Service Charges / Tax</label>
                    <p class="mb-0">INR {{ number_format($booking->service_charges, 2) }}</p>
                </div>
                <div class="col-md-3">
                    <label class="text-muted small">Total Amount</label>
                    <p class="mb-0 fw-semibold">INR {{ number_format($booking->total_amount, 2) }}</p>
                </div>
                <div class="col-12 mt-3">
                    <label class="text-muted small">Payment Details</label>
                    <p class="mb-0">{{ $booking->payment_details ?? '—' }}</p>
                </div>
            </div>

            <h5 class="mb-3">Notes</h5>
            <p class="mb-0">{{ $booking->notes ?? '—' }}</p>
        </div>
    </div>
</x-sneat-admin-layout>


