<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Print Table</title>
        <meta charset="UTF-8">
        <meta name=description content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap CSS -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <style>
            body {margin: 20px}
        </style>
    </head>
    <body>
        <table border="0">
            <tr>
                <td width="150px" class="text-center">
                    <div style="background-color: #8B2657" class=" p-2 m-2">
                        {{-- <img src="{{ asset('img/suwa-arana-logo-white.png') }}" alt="" width="90px" height="auto" srcset=""> --}}
                    </div>
                </td>
                <td width="80%">
                    <h2 class="h3 pt-3"></h2>
                {{-- <p>A Place for healing</p> --}}
                </td>
                <td width="300px" class="text-right">
                    <h4> Date: {{ date('Y-m-d H:i') }}</h4>
                </td>
            </tr>
        </table><br/>
        <table class="table table-bordered table-condensed table-striped">
            @foreach($data as $row)
                @if ($loop->first)
                    <tr>
                        @foreach($row as $key => $value)
                            <th>{!! $key !!}</th>
                        @endforeach
                    </tr>
                @endif
                <tr>
                    @foreach($row as $key => $value)
                        @if(is_string($value) || is_numeric($value))
                            <td>{!! $value !!}</td>
                        @else
                            <td></td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </table>
        
        <table width="100%">
            <tr>
                <td class="text-right" width="100%">
                    {{ Auth::user()->first_name.' '.Auth::user()->last_name }}
                </td>
            </tr>
        </table>
    </body>
</html>

