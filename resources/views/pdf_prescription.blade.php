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
            width: 195mm;
            /* Typical POS printer paper width */
            max-width: 195mm;
            padding: 10px;
        }

        .header,
        .footer {
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

        .items th,
        .items td {
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

        .content-items p {
            line-height: 25px;
            margin: 2px 0px 2px 0px;
        }

        .p-header p {
            line-height: 25px;
            margin: 8px 0px 8px 20px;
        }

        .content-items th,
        .content-items td {
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
                        <img src="{{ public_path('img/Glowup_Logo.jpg') }}" alt="Glowup Skin Clinic" width="90px"
                            height="auto">
                    </div>
                </td>
                <td width="570px" class="p-header">
                    <h2 class="pt-3">{{ $hospital_info['name'] }}</h2>
                    <p>{{ $hospital_info['address'] }}</p>
                    <p>Phone: {{ $hospital_info['phone'] }}</p>
                </td>
                <td width="230px" class="text-right">

                    {{-- <h4 style="margin-top: 90px;">Date: {{ $date }}</h4> --}}
                </td>
            </tr>
        </table>
        <hr>
        <div class="content">
            <h2>Prescription Details</h2>

            <table class="content-items">
                <tbody>
                    <tr>
                        <td width="100%">
                            <p><strong>Prescription Date:</strong> {{ $date }}</p>
                        </td>

                    </tr>
                    <tr>
                        <td width="100%">
                            <p><strong>Patient Name:</strong> {{ $patient->name ?? 'N/A' }}</p>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%">
                            <table class="content-items">
                                <tbody>
                                    <tr>
                                        <td width="140px" style="vertical-align: top;">
                                            <p><strong>Contact:</strong> </p>
                                        </td>
                                        <td width="400px">
                                            <p>{{ $patient->mobile_number ?? 'N/A' }}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </td>

                    </tr>
                    <tr>
                        <td width="100%">
                            <p><strong>Doctor:</strong> {{ $doctor->name ?? 'N/A' }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>

            @if($prescription)
                <h3>Prescription Items</h3>
                <table class="items">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="35%">Drug Name</th>
                            <th width="30%">Dose</th>
                            <th width="30%">Dosage</th>
                            <th width="30%">Duration</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($prescription as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->drug_name }}</td>
                                <td>{{ $item->dosage }}</td>
                                <td>{{ $item->dose }}</td>
                                <td>{{ $item->duration }}</td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No treatment details found.</p>
            @endif


        </div>
        <div class="footer">
            <hr>
            <p>Thank you for trusting {{ $hospital_info['name'] }} with your skincare journey!</p>
            <!-- Bottom Section for User's Name -->
            <div class="mt-5">
                <p class="text-right"><strong>Prepared by:</strong> {{ Auth::user()->first_name }}</p>
            </div>
        </div>
    </div>
</body>

</html>