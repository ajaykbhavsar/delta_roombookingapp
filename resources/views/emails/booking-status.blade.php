<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .header {
            background-color: {{ $emailContent['color'] }};
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin: -20px -20px 20px -20px;
        }
        .header h2 {
            margin: 0;
        }
        .content {
            margin: 20px 0;
        }
        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 4px solid {{ $emailContent['color'] }};
            margin: 20px 0;
            border-radius: 4px;
        }
        .details h3 {
            margin-top: 0;
            color: #333;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: bold;
            color: #666;
        }
        .detail-value {
            color: #333;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 12px;
            color: #999;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: {{ $emailContent['color'] }};
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>{{ $emailContent['title'] }}</h2>
        </div>

        <div class="content">
            <p>Dear {{ $booking->first_name }} {{ $booking->last_name }},</p>
            <p>{{ $emailContent['message'] }}</p>

            <div class="details">
                <h3>Booking Details</h3>
                <div class="detail-row">
                    <span class="detail-label">Booking ID:</span>
                    <span class="detail-value">{{ $booking->id }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Reference No:</span>
                    <span class="detail-value">{{ $booking->reference_no }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Guest Name:</span>
                    <span class="detail-value">{{ $booking->first_name }} {{ $booking->last_name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Email:</span>
                    <span class="detail-value">{{ $booking->email }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Phone:</span>
                    <span class="detail-value">{{ $booking->phone_number }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Room:</span>
                    <span class="detail-value">{{ $booking->room?->room_no }} - {{ $booking->roomType?->name }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-in:</span>
                    <span class="detail-value">{{ $booking->check_in_at->format('M d, Y H:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Check-out:</span>
                    <span class="detail-value">{{ $booking->check_out_at->format('M d, Y H:i A') }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Room Rate:</span>
                    <span class="detail-value">${{ number_format($booking->room_rate, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Discount:</span>
                    <span class="detail-value">-${{ number_format($booking->discount, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Service Charges:</span>
                    <span class="detail-value">${{ number_format($booking->service_charges, 2) }}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value"><strong>${{ number_format($booking->total_amount, 2) }}</strong></span>
                </div>
                @if($booking->booking_status === 'confirmed')
                <div class="detail-row">
                    <span class="detail-label">Confirmation Code:</span>
                    <span class="detail-value"><strong>{{ $booking->reference_no }}</strong></span>
                </div>
                @endif
            </div>
        </div>

        <div class="footer">
            <p>If you have any questions, please contact us at support@roombookingapp.com</p>
            <p>&copy; {{ date('Y') }} Room Booking App. All rights reserved.</p>
        </div>
    </div>
</body>
</html>