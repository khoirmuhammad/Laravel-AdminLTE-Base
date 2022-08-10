@extends('layouts.main', ['title' => 'Blank Page'])

@section('content-header')
    {{-- <h1>Selamat Datasng, {{ auth()->user()->name }}</h1> --}}
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark"></h1>
        </div><!-- /.col -->

    </div><!-- /.row -->
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">MT</span>
                    <span class="info-box-number" id="mt_id">

                        <small>MT</small>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">MS</span>
                    <span class="info-box-number" id="ms_id"><small>MS</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Asisten</span>
                    <span class="info-box-number" id="asisten_id"> <small>Asisten</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Pengajar</span>
                    <span class="info-box-number" id="total_id"> <small>Guru KBM</small></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="chart-responsive">
                                <canvas id="donutChart"
                                    style="min-height: 200px; height: 200px; max-height: 200px; max-width: 100%;"></canvas>
                            </div>
                            <!-- ./chart-responsive -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <ul class="chart-legend clearfix">
                                <li><i class="far fa-circle text-danger"></i> PAUD-TK</li>
                                <li><i class="far fa-circle text-success"></i> CABWRAWIT</li>
                                <li><i class="far fa-circle text-warning"></i> PRAREMAJA</li>
                                <li><i class="far fa-circle text-info"></i> REMAJA</li>
                                <li><i class="far fa-circle text-primary"></i> USIA NIKAH</li>
                            </ul>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.card-body -->

                <!-- /.footer -->
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="chart">
                        <canvas id="stackedBarChart"
                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        #btn-try {
            background-color: green;
            color: white;
        }
    </style>
@endpush

@push('js')
    <!-- ChartJS -->
    <script src="/adminlte/plugins/chart.js/Chart.min.js"></script>
    <script>
        $(document).ready(function() {

            get_dasboard_total_teacher();
            get_dashboard_total_student_by_level();
            get_dashboard_total_student_by_class_gender();

        })

        function get_dasboard_total_teacher() {
            $.ajax({
                url: "/api/dashboard/get-teacher-total-by-status",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        let total = 0;
                        for (let i = 0; i < response.data.length; i++) {
                            if (response.data[i].status == "Asisten") {
                                $("#asisten_id").text(response.data[i].total);
                                total += parseInt(response.data[i].total);
                            } else if (response.data[i].status == "MS") {
                                $("#ms_id").text(response.data[i].total);
                                total += parseInt(response.data[i].total);
                            } else if (response.data[i].status == "MT") {
                                $("#mt_id").text(response.data[i].total);
                                total += parseInt(response.data[i].total);
                            }
                        }

                        $("#total_id").text(total);
                    }
                },
                error: function(response) {

                }
            });
        }

        function get_dashboard_total_student_by_level() {
            $.ajax({
                url: "/api/dashboard/get-student-total-by-level",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        let data = [];

                        for (let i = 0; i < response.data.length; i++) {

                            data.push(response.data[i].total);
                        }

                        //-------------
                        //- DONUT CHART -
                        //-------------
                        // Get context with jQuery - using jQuery's .get() method.
                        var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
                        var donutData = {
                            labels: [
                                'PAUD-TK',
                                'CABERAWIT',
                                'PRAREMAJA',
                                'REMAJA',
                                'USIA NIKAH',
                            ],
                            datasets: [{
                                data: data, //[4, 18, 7, 9, 24],
                                backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef',
                                    '#3c8dbc'
                                ],
                            }]
                        }
                        var donutOptions = {
                            maintainAspectRatio: false,
                            responsive: true,
                        }
                        //Create pie or douhnut chart
                        // You can switch between pie and douhnut using the method below.
                        var donutChart = new Chart(donutChartCanvas, {
                            type: 'doughnut',
                            data: donutData,
                            options: donutOptions
                        })

                    }
                },
                error: function(response) {

                }
            });

        }

        function get_dashboard_total_student_by_class_gender() {
            $.ajax({
                url: "/api/dashboard/get-student-total-by-class-gender",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        let unique_class = [...new Set(response.data.map(item => item.name))];

                        let data = swap_class_array(unique_class);

                        let data_male = [];
                        let data_female = [];

                        data.forEach(function(item) {
                            var objMale = response.data.find(e => e.name == item && e.gender == "Laki-laki");
                            var objFemale = response.data.find(e => e.name == item && e.gender == "Perempuan");

                            if (objMale != null) {
                                data_male.push(objMale.total);
                            } else {
                                data_male.push(0);
                            }

                            if (objFemale != null) {
                                data_female.push(objFemale.total);
                            } else {
                                data_female.push(0);
                            }


                        })



                        //---------------------
                        //- STACKED BAR CHART -
                        //---------------------
                        var areaChartData = {
                            labels: data,
                            datasets: [{
                                    label: 'Laki-laki',
                                    backgroundColor: 'rgba(60,141,188,0.9)',
                                    borderColor: 'rgba(60,141,188,0.8)',
                                    pointRadius: false,
                                    pointColor: '#3b8bba',
                                    pointStrokeColor: 'rgba(60,141,188,1)',
                                    pointHighlightFill: '#fff',
                                    pointHighlightStroke: 'rgba(60,141,188,1)',
                                    data: data_male //[2, 2, 2, 0, 1, 2, 2, 4, 0, 17]
                                },
                                {
                                    label: 'Perempuan',
                                    backgroundColor: 'rgba(210, 214, 222, 1)',
                                    borderColor: 'rgba(210, 214, 222, 1)',
                                    pointRadius: false,
                                    pointColor: 'rgba(210, 214, 222, 1)',
                                    pointStrokeColor: '#c1c7d1',
                                    pointHighlightFill: '#fff',
                                    pointHighlightStroke: 'rgba(220,220,220,1)',
                                    data: data_female, //[2, 1, 0, 4, 4, 0, 0, 1, 2, 16]
                                },
                            ]
                        }

                        var barChartData = jQuery.extend(true, {}, areaChartData)

                        var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
                        var stackedBarChartData = jQuery.extend(true, {}, barChartData)

                        var stackedBarChartOptions = {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                xAxes: [{
                                    stacked: true,
                                }],
                                yAxes: [{
                                    stacked: true
                                }]
                            }
                        }

                        var stackedBarChart = new Chart(stackedBarChartCanvas, {
                            type: 'bar',
                            data: stackedBarChartData,
                            options: stackedBarChartOptions
                        })

                    }
                },
                error: function(response) {

                }
            });

        }

        function swap_class_array(unique_class) {

            let paudTkValue = unique_class.find(e => e == "PAUD-TK");
            let paudTkIndex = unique_class.indexOf(paudTkValue);

            let loop = 0;
            for (let i = paudTkIndex - 1; i >= 0; i--) {
                //index 6 - 0 = element ke 5
                //index 6 - 1 = element ke 4
                //index 6 - 2 = element ke 3
                //index 6 - 3 = element ke 2
                //index 6 - 4 = element ke 1
                //index 6 - 5 = element ke 0
                unique_class[paudTkIndex - loop] = unique_class[i];
                loop++;
            }

            //index 6 - 6 = element ke 6
            unique_class[0] = paudTkValue;

            return unique_class;
        }
    </script>
@endpush
