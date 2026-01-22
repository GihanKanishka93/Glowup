<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>

    <style>
 body {
            font-family: monospace;
            font-size: 12px;
            margin: 0;
        }
        .receipt {
            width: 80mm; /* Typical POS printer paper width */
            max-width: 80mm;
            padding: 10px;
        }
        .header, .footer {
            text-align: center;
        }
        .content {
            text-align: left;
        }
        .items {
            width: 100%;
            margin-bottom: 10px;
            border-collapse: collapse;
        }
        .items th, .items td {
            padding: 5px;
            border-bottom: 1px solid #ddd;
        }
        .items th {
            text-align: left;
        }
        .total {
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <table border="0">
            <tr>
                <td width="150px" class="text-center">
                    <div class="bg-primary p-2 m-2">
                        <img src="https://challengervet.lk/wp-content/uploads/2019/10/CHALLENGER-VET-Logo.png" alt="" width="90px" height="auto">
                    </div>
                </td>
                <td width="500px">
                    <h2 class="h3 pt-3">{{ $hospital_info['name'] }}</h2>
                    <p>{{ $hospital_info['address'] }}</p>
                    <p>Phone: {{ $hospital_info['phone'] }}</p>
                </td>
                <td width="230px" class="text-right">
                    <h4>Date: {{ $date }}</h4>
                </td>
            </tr>
        </table>
        <hr>
        <div class="content">
            <h2>Billing Details</h2>
            <p><strong>Billing Date:</strong> {{ $date }}</p>
             @if($pet)
            <p><strong>Pet Name:</strong> {{ $pet->name }}</p>
            <p><strong>Owner Name:</strong> {{ $pet->owner_name }}</p>
            @else
                <p><strong>Pet Name:</strong> N/A</p>
                <p><strong>Owner Name:</strong> N/A</p>
            @endif
            
            @if($doctor)
                <p><strong>Doctor:</strong> {{ $doctor->name }}</p>
            @else
                <p><strong>Doctor:</strong> N/A</p>
            @endif
            @if($billing_items)
                <h3>Billing Items</h3>
                <table class="items">
                    <thead>
                        <tr>
                            <th width="30px">#</th>
                            <th width="200px">Item</th>
                            <th width="70px">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($billing_items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No treatment details found.</p>
            @endif
            <div class="total">
                <h4>Total Cost: Rs. {{ $billing_data->net_amount }}</h4>
            </div>
        </div>
        <div class="footer">
            <hr>
            <p>Thank you for trusting {{ $hospital_info['name'] }} with your pet's care!</p>
        </div>
    </div>
</body>
</html>
