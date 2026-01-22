<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .header, .footer {
            text-align: center;
        }
        .header {
            margin-bottom: 20px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
        }
        .content {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $hospital_info['name'] }}</h1>
        <p>{{ $hospital_info['address'] }}</p>
        <p>Phone: {{ $hospital_info['phone'] }}</p>
        <hr>
    </div>
    <div class="content">
        <h2>Billing Details</h2>
        <p><strong>Billing Date:</strong> {{ $date }}</p>
        <p><strong>Pet Name:</strong> {{ $pet->name }}</p>
        <p><strong>Owner Name:</strong> {{ $pet->owner_name }}</p>
        <p><strong>Doctor:</strong> {{ $doctor->name }}</p>
        <h3>Treatment Details</h3>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Cost</th>
                </tr>
            </thead>
            <tbody>
                @foreach($treatment->details as $detail)
                    <tr>
                        <td>{{ $detail->description }}</td>
                        <td>{{ $detail->cost }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3>Total Cost: ${{ $billing_data->total_cost }}</h3>
    </div>
    <div class="footer">
        <p>Thank you for trusting {{ $hospital_info['name'] }} with your pet's care!</p>
    </div>
</body>
</html>
