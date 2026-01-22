@extends('layouts.app')
@section('content')
    <h1 class="h3 mb-2 text-gray-800">
         Age wise report 
       </h1>

    <div class="row">
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                   
                    <div class="dropdown no-arrow show">
                        <div class="dropdown no-arrow show">
                            <a href="{{ URL::previous() }}" class="btn btn-sm btn-info btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fa fa-arrow-left"></i>
                                </span>
                                <span class="text">Back</span></a>
                        </div>
                    </div>
                </div>
                <div class="card-body"> 
                        <table class="table table-hover">
                            <tr>
                                <th>No</th>
                                <th class="text-right">Age</th>
                                <th class="text-right">Number of Patients</th>
                            </tr>
                            @foreach ($patients as $patient)
                            @php
                                $data[] = $patient->count;
                                $labels[] = $patient->age_at_register.' Years Old';
                                $colors[] = '';
                            @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-right">{{ $patient->age_at_register }} Year Old</td>
                                    <td class="text-right">{{ $patient->count }}</td>
                                </tr>
                            @endforeach
                        </table>
                     </div> 
            </div>
        </div>
        <div class="col-xl-6 col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                   
                    <div class="dropdown no-arrow show">
                        
                    </div>
                </div>
                <div class="card-body"> 
                    <canvas id="myPieChart" width="400" height="400"></canvas>
 
                     </div> 
            </div>
        </div>
    </div>
 
@endsection


@section('third_party_stylesheets')

@stop

@section('third_party_scripts')
<script src="{{ asset('plugin/chart.js/Chart.min.js') }}"></script>
@if(count($patients)>0)
<script>
Chart.defaults.global.defaultFontFamily = 'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

const colorRangeInfo = {
    colorStart: 0,
    colorEnd: 360,
    useEndAsStart: false,
};

// Function to generate a gradient of colors in HSL format
function generateColorGradient(count, start, end) {
    const colors = [];
    const increment = (end - start) / count;

    for (let i = 0; i < count; i++) {
        const hue = start + i * increment;
        colors.push(`hsl(${hue}, 60%, 70%)`);
    }

    return colors;
}

// Pie Chart Example
var ctx = document.getElementById("myPieChart");
var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($labels) !!},
        datasets: [{
            data: {{ json_encode($data) }},
            backgroundColor: generateColorGradient({{ count($data) }}, colorRangeInfo.colorStart, colorRangeInfo.colorEnd),
            hoverBackgroundColor: generateColorGradient({{ count($data) }}, colorRangeInfo.colorStart + 30, colorRangeInfo.colorEnd + 30),
        
            //  hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: true,
        }, 
    },
});

</script>
@endif
  @stop
