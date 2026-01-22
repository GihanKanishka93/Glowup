@extends('layouts.app')

@section('content')
<h1 class="h3 mb-2 text-gray-800">Admission Rate Bar Chart</h1>

<div class="row">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-12">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <div class="dropdown no-arrow show">
                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-info btn-icon-split">
                        <span class="icon text-white-50">
                            <i class="fa fa-arrow-left"></i>
                        </span>
                        <span class="text">Back</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <form id="admissionChartForm" class="row">
                    <label for="start_date" class="col labeltext">Start Date:</label>
                    <div class="col-md-2">
                        <input type="text" id="start_date" name="start_date" class="datepicker form-control">
                    </div>
                    <label for="end_date" class="col labeltext">End Date:</label>
                    <div class="col-md-2">
                        <input type="text" id="end_date" name="end_date" class="datepicker form-control">
                    </div>

                    <label for="rpt_type" class="col-md-2 labeltext">Report Type:</label>
                    <div class="col-md-2">
                        <input type="radio" name="rpt_type" id="daily" value="a" checked> Daily
                        <input type="radio" name="rpt_type" id="monthly" value="p"> Monthly
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary">Generate Chart</button>
                    </div>
                </form><br />

                <figure class="highcharts-figure">
                    <div id="container"></div>
                    <p class="highcharts-description"></p>
                </figure>
            </div>
            <div class="card-footer"></div>
        </div>
    </div>
</div>

@endsection


@section('third_party_stylesheets')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
@stop

@section('third_party_scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>

<script>
    $(document).ready(function() {
        // Initialize datepickers
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        });
        // Example usage
        const currentDate = new Date(); // Get current date
        const previousMonthEquivalent = getPreviousMonthDate(currentDate);
        $("#start_date").val(previousMonthEquivalent.toISOString().split('T')[0]);
        $("#end_date").val(currentDate.toISOString().split('T')[0]);
       
        updateChartOnPageLoad();
        $('#admissionChartForm').on('submit', function(e) {
            e.preventDefault(); 

            let start_date = $('#start_date').val() || null; 
            let end_date = $('#end_date').val() || null; 
            let rpt_type = $('input[name="rpt_type"]:checked').val();

            $.ajax({
                url: '{{ route("reports.admissionChartData") }}', 
                type: 'POST',
                data: {
                    start_date: start_date,
                    end_date: end_date,
                    rpt_type: rpt_type,
                    _token: '{{ csrf_token() }}' 
                },
                success: function(response) {
                   
                    updateChart(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        });


    });

    function updateChartOnPageLoad() {
        let start_date = $('#start_date').val() || null; 
        let end_date = $('#end_date').val() || null; 
        let rpt_type = $('input[name="rpt_type"]:checked').val();

        $.ajax({
            url: '{{ route("reports.admissionChartData") }}', 
            type: 'POST',
            data: {
                start_date: start_date,
                end_date: end_date,
                rpt_type: rpt_type,
                _token: '{{ csrf_token() }}' 
            },
            success: function(response) {
                
                updateChart(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    }

   
    function getPreviousMonthDate(currentDate) {
        const currentYear = currentDate.getFullYear();
        const currentMonth = currentDate.getMonth(); 
        const currentDay = currentDate.getDate();

        let previousMonth, previousYear;
        if (currentMonth === 0) {
            
            previousMonth = 11; 
            previousYear = currentYear - 1; 
        } else {
            previousMonth = currentMonth - 1;
            previousYear = currentYear;
        }

       
        const previousMonthDate = new Date(previousYear, previousMonth, currentDay);

        
        if (previousMonthDate.getMonth() !== previousMonth) {
            
            const lastDayOfPreviousMonth = new Date(previousYear, previousMonth + 1, 0); 
            return lastDayOfPreviousMonth;
        }

        return previousMonthDate;
    }

    function updateChart(data) {
        console.log("_data", data)
        
        let categories = data.categories;
        let admissionCounts = data.admission_counts;

        Highcharts.chart('container', {
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Admission Count Report',
                align: 'left'
            },

            exporting: {
                enabled: false,
            },
            credits: {
                enabled: false, 
            },
            xAxis: {
                categories: categories,
          
                
            },
            yAxis: {
                title: {
                    text: 'Admission Count',
                    align:'right'
                    
                }
            },
            series: [{
                name: 'Admissions',
                data: admissionCounts
            }]
        });
    }
</script>
@stop