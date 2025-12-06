<?php


namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookingStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Booking $booking,
        public string $status
    ) {}

    public function envelope(): Envelope
    {
        $subjects = [
            'pending' => 'Booking Pending - Awaiting Confirmation',
            'confirmed' => 'Booking Confirmed - Your Reservation is Secured',
            'checked_in' => 'Welcome! Check-in Completed Successfully',
            'checkout' => 'Checkout Reminder - Please Complete Your Checkout',
            'checked_out' => 'Thank You! Your Checkout is Complete',
            'cancelled' => 'Booking Cancelled',
        ];

        return new Envelope(
            subject: $subjects[$this->status] ?? 'Booking Status Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.booking-status',
            with: [
                'booking' => $this->booking,
                'status' => $this->status,
                'emailContent' => $this->getEmailContent(),
            ],
        );
    }

    private function getEmailContent(): array
    {
        return match ($this->status) {
            'pending' => [
                'title' => 'Your Booking is Pending',
                'message' => 'Thank you for your booking request! Your booking is awaiting confirmation. We will notify you shortly.',
                'color' => '#FFA500',
            ],
            'confirmed' => [
                'title' => 'Your Booking is Confirmed!',
                'message' => 'Great news! Your reservation has been confirmed. Please keep your confirmation code for check-in.',
                'color' => '#28a745',
            ],
            'checked_in' => [
                'title' => 'Welcome! Check-in Completed',
                'message' => 'You have successfully checked in. Enjoy your stay with us!',
                'color' => '#17a2b8',
            ],
            'checkout' => [
                'title' => 'Checkout Reminder',
                'message' => 'Your checkout date is approaching. Please complete your checkout by 11:00 AM.',
                'color' => '#fd7e14',
            ],
            'checked_out' => [
                'title' => 'Thank You for Your Stay',
                'message' => 'Thank you for staying with us. We hope you had a great experience!',
                'color' => '#6f42c1',
            ],
            'cancelled' => [
                'title' => 'Booking Cancelled',
                'message' => 'Your booking has been cancelled.',
                'color' => '#dc3545',
            ],
            default => [
                'title' => 'Booking Status Update',
                'message' => 'Your booking status has been updated.',
                'color' => '#007bff',
            ],
        };
    }
}