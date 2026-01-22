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
            max-width: 85mm;
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
                <td width="85px" class="text-center">
                    <div class="bg-primary p-2 m-2">
                        <img src="https://challengervet.lk/wp-content/uploads/2019/10/CHALLENGER-VET-Logo.png" alt="" width="80px" height="auto">
                    </div>
                </td>
                <td width="180px">
                    <h2 class="h3 pt-3">{{ $hospital_info['name'] }}</h2>
                    <p>{{ $hospital_info['address'] }}</p>
                    <p>Phone: {{ $hospital_info['phone'] }}</p>
                </td>
                <td width="230px" class="text-right">

                    <h4 style="margin-top: 90px;">Date: {{ $date }}</h4>
                </td>
            </tr>
        </table>
        <hr>
        <div class="content">
            <h2>Prescription Details</h2>
            <p><strong>Prescription Date:</strong> {{ $date }}</p>
            <p><strong>Pet Name:</strong> {{ $pet->name }}</p>
            <p><strong>Owner Name:</strong> {{ $pet->owner_name }}</p>
            <p><strong>Doctor:</strong> {{ $doctor->name }}</p>
            @if($prescription)
                <h3>Prescription Items</h3>
                <table class="items">
                    <thead>
                        <tr>
                            <th width="20px">#</th>
                            <th width="200px">Drug Name</th>
                            <th width="40px">Dosage</th>
                            <th width="70px">Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->drug_name }}</td>
                                <td>{{ $item->dosage }}</td>
                                <td>{{ $item->duration }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No Prescription details found.</p>
            @endif

        </div>
        <div class="footer">
            <hr>
            <p>Thank you for trusting {{ $hospital_info['name'] }} with your pet's care!</p>
        </div>
    </div>
</body>
</html>
