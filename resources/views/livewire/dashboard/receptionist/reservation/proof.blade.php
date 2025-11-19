<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .text-center {
            text-align: center;
        }
        .space-y-4 > * + * {
            margin-top: 1rem;
        }
        .space-y-6 > * + * {
            margin-top: 1.5rem;
        }
        h1 {
            font-size: 2rem;
            font-weight: 900;
            color: #1f2937;
            margin: 20px 0;
        }
        p {
            color: #4b5563;
            line-height: 1.5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th {
            text-align: left;
            padding: 8px;
            font-weight: 600;
        }
        td {
            padding: 8px;
        }
        img {
            max-width: 200px;
            margin: 0 auto;
            display: block;
        }
    </style>
</head>
<body>
    <div class="container space-y-6">
        <div class="text-center space-y-4">
            <h1>HOLLUX HOTEL</h1>
            <h1>Proof of Room Reservation</h1>
            <p>Apartemen Merkurius City No. 32, Jalan Jupiter Kav. 18, Mars, Saturnus, 13120</p>
        </div>
        <table>
            <tr>
                <th>Reservation Code</th>
                <td>:</td>
                <td>{{ $reservation->code }}</td>
            </tr>
            <tr>
                <th>Reservation Status</th>
                <td>:</td>
                <td style="text-transform: capitalize;">{{ $reservation->status }}</td>
            </tr>
            <tr>
                <th>Reservation Date</th>
                <td>:</td>
                <td>{{ $reservation->date }}</td>
            </tr>
            <tr>
                <th>Name</th>
                <td>:</td>
                <td>{{ $reservation->user->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>:</td>
                <td>{{ $reservation->user->email }}</td>
            </tr>
            <tr>
                <th>Phone</th>
                <td>:</td>
                <td>{{ $reservation->user->phone_number }}</td>
            </tr>
            <tr>
                <th>Room Type</th>
                <td>:</td>
                <td>{{ $reservation->room->name }}</td>
            </tr>
            <tr>
                <th>Number of Room(s)</th>
                <td>:</td>
                <td>{{ $reservation->total_rooms }}</td>
            </tr>
            <tr>
                <th>Check In</th>
                <td>:</td>
                <td>{{ $reservation->check_in }}</td>
            </tr>
            <tr>
                <th>Check Out</th>
                <td>:</td>
                <td>{{ $reservation->check_out }}</td>
            </tr>
            <tr>
                <th>Total Day(s)</th>
                <td>:</td>
                <td>{{ $total_days }}</td>
            </tr>
            <tr>
                <th>Total Price</th>
                <td>:</td>
                <td>${{ $reservation->total_price }}</td>
            </tr>
        </table>
    </div>
</body>
</html>