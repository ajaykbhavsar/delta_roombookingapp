<?php

namespace App\Http\Requests;

use App\Models\Booking;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBookingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('create', Booking::class) ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'room_id' => [
                'required',
                Rule::exists('rooms', 'id')->where('is_active', true),
            ],
            'room_type_id' => [
                'required',
                Rule::exists('room_types', 'id')->where('is_active', true),
            ],
            'location' => [
                'required',
                Rule::exists('locations', 'id')->where('is_active', true),
            ],
            'room_rate' => ['required', 'numeric', 'min:0'],
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'phone_number' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['required', 'string'],
            'room_location'=> ['required', 'string'],
            'id_proof_type' => ['required', Rule::in(array_keys(Booking::ID_PROOF_TYPES))],
            'id_number' => ['required', 'string', 'max:120'],
            // 'location' => ['required', 'string', 'max:120'],
            // 'location' => ['required', Rule::in(array_keys(Booking::LOCATION_OPTIONS))],
            'room_status' => ['required', Rule::in(array_keys(Booking::ROOM_STATUS_OPTIONS))],
            'occupancy_status' => ['required', Rule::in(array_keys(Booking::OCCUPANCY_STATUS_OPTIONS))],
            'additional_description' => ['nullable', 'string'],
            'booking_type' => ['required', Rule::in(array_keys(Booking::BOOKING_TYPE_OPTIONS))],
            'check_in_at' => ['required', 'date'],
            'check_out_at' => ['required', 'date', 'after:check_in_at'],
            'guest_count' => ['required', 'integer', 'min:1', 'max:20'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'service_charges' => ['nullable', 'numeric', 'min:0'],
            'payment_type' => ['required', Rule::in(array_keys(Booking::PAYMENT_TYPE_OPTIONS))],
            'payment_status' => ['required', Rule::in(array_keys(Booking::PAYMENT_STATUS_OPTIONS))],
            'payment_details' => ['nullable', 'string'],
            'is_repeat_customer' => ['required', 'boolean'],
            'notes' => ['nullable', 'string'],
            'booking_status' => ['required', Rule::in(array_keys(Booking::BOOKING_STATUS_OPTIONS))],
        ];
    }
}


