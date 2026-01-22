<!DOCTYPE html>
<html>
<head>
    <title>{{ $title }}</title>

    <style>
 body {
            font-family: monospace;
            font-size: 20px;
            margin: 0;
        }
        .receipt {
            width: 90mm; /* Typical POS printer paper width */
            max-width: 90mm;
            padding: 5px;
            margin-top: -60px !important;
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
        h2 {
          text-align: left;
          font-weight: bold;
          font-size: 26px;
          line-height: 40px;
          margin: 5px 0px 15px 20px;
        }
        .total h4 {
            line-height: 25px;
            margin: 2px 0px;
        }
        .content-items p{
            line-height: 25px;
            margin: 2px 0px 2px 0px;
        }
        .p-header p{
            line-height: 25px;
            margin: 8px 0px 8px 20px;
        }

        .content-items th, .content-items td {
            padding: 0px;
            border-bottom: 0px solid #ddd;
        }
        .content-items th {
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <table border="0">
            <tr>
                <td width="90px" class="text-center">
                    <div class="bg-primary p-2 m-2">
                        <img src="{{ public_path('img/Glowup_Logo.jpg') }}" alt="Glowup Skin Clinic" width="90px" height="auto">
                    </div>
                </td>
                <td width="300px" class="p-header">
                    <h2 class="pt-3">{{ $hospital_info['name'] }}</h2>
                    <p>{{ $hospital_info['address'] }}</p>
                    <p>Phone: {{ $hospital_info['phone'] }}</p>
                </td>
                <td width="230px" class="text-right">

                    {{-- <h4 style="margin-top: 90px;">Date: {{ $date }}</h4> --}}
                </td>
            </tr>
        </table>
        <center><p>{{ now()->setTimezone('Asia/Colombo') }}</p></center>
        <hr>
        <div class="content">
            {{-- <h2>{{ $billing_data->billing_id }}</h2> --}}
            {{-- <p><strong>Billing Date:</strong> {{ $date }}</p>
            <p><strong>Client Name:</strong> {{ $pet->name ?? 'N/A' }}</p>
            <p><strong>Contact Name:</strong> {{ $pet->owner_name ?? 'N/A' }}</p>
            <p><strong>Doctor:</strong> {{ $doctor->name ?? 'N/A' }}</p> --}}
            <table class="content-items">
                <tbody>
                    <tr>
                        <td width="100%"><p><strong>Bill No: {{ $billing_data->billing_id }}</strong> </p></td>

                    </tr>
                    <tr>
                        <td width="100%"><p><strong>Client ID:</strong> {{ $pet->pet_id ?? '' }} </p></td>
                    </tr>
                    <tr>
                        <td width="100%"><p><strong>Client Name:</strong> {{ $pet->name ?? 'N/A' }}</p></td>
                    </tr>
                    <tr>
                        <td width="100%"><p><strong>Doctor:</strong> {{ $doctor->name ?? 'N/A' }}</p></td>
                    </tr>
                </tbody>
            </table>

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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td style="text-align: right;">{{ $item->total_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No treatment details found.</p>
            @endif

            <div class="total">
                <table class="content-items">
                    <tbody>
                        <tr>
                            <td width="160px"> <h4>Net Amount: </h4></td>
                            <td width="40px"> <h4>Rs. </h4></td>
                            <td width="70px" style="text-align: right;"><h4>{{ $billing_data->net_amount }}</h4></td>
                        </tr>
                        <tr>
                            <td width="160px"> <h4>Discount: </h4></td>
                            <td width="40px"> <h4>Rs. </h4></td>
                            <td width="70px" style="text-align: right;"><h4>{{ $billing_data->discount }}</h4></td>
                        </tr>
                        <tr>
                            <td width="160px"> <h4>Total Cost: </h4></td>
                            <td width="40px"> <h4>Rs. </h4></td>
                            <td width="70px" style="text-align: right;"><h4>{{ $billing_data->total }}</h4></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="footer">
            <hr>
            <p>Thank you for trusting <strong>Glow Up Skin Care &amp; Cosmetics</strong> with your skincare journey!</p>
            <!-- Bottom Section for User's Name -->
    <div class="mt-5">
        <p class="text-right"><strong>Prepared by:</strong> {{ Auth::user()->first_name }}</p>
    </div>
        </div>
    </div>
</body>
</html>
