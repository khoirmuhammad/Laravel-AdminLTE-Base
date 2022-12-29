@extends('layouts.main')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Beranda</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <!-- Default box -->


    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>


        </div>
        <div class="card-body" id="card-body-id">
            <div class="row mb-2">
                <div class="col-md-2">
                    <button id="analysis-chart" class="btn btn-info"><i class="fa fa-bar-chart" aria-hidden="true"></i>
                        Grafik Analisis</button>
                </div>
                <div class="col-md-7"></div>
                <div class="col-md-1">Bulan Periode</div>
                <div class="col-md-2">

                    <select id="month" class="form-control" name="month">
                        <option value="0">Pilih Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="table-responsive">
                    <table class="table table-sm" id="recap-presence">
                        <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th colspan="4" class="text-center">Persentase</th>
                                <th rowspan="2" class="text-center">Pertemuan</th>
                                <th rowspan="2" class="text-center">Periode Bulan</th>
                                <th rowspan="2" class="text-center">#</th>
                            </tr>
                            <tr>
                                <th class="text-center">Kelas</th>
                                <th class="text-center">Hadir</th>
                                <th class="text-center">Izin</th>
                                <th class="text-center">Alfa</th>
                                <th class="text-center">Total</th>
                            </tr>


                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->

    <div class="modal fade" id="modal-recap" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center" id="modal-title"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-sm" id="recap-presence-in-class">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Kelas</th>
                                        <th class="text-center">Hadir</th>
                                        <th class="text-center">Izin</th>
                                        <th class="text-center">Alfa</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <div class="modal fade" id="modal-chart" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title text-center">Grafik Analisa</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">

                        <div class="card-body">



                            <div class="chart">
                                <span><strong>Presensi bulan ini</strong></span>
                                <canvas id="barChartCurrentMonth"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                            </div>

                            <hr>
                            <span><strong>Kehadiran</strong></span>
                            <canvas id="presentChart" width="600" height="300"></canvas>

                            <hr>
                            <span><strong>Izin</strong></span>
                            <canvas id="permitChart" width="600" height="300"></canvas>

                            <hr>
                            <span><strong>Alfa</strong></span>
                            <canvas id="absentChart" width="600" height="300"></canvas>

                        </div>
                    </div>



                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
@endsection


@push('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
    <!-- icheck bootstrap -->
    {{-- <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css"> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        th:first-child,
        td:first-child {
            position: sticky;
            left: 0px;
            background-color: rgb(233, 232, 232);
        }
    </style>
@endpush

@push('js')
    <!-- jQuery -->
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- ChartJS -->
    <script src="/adminlte/plugins/chart.js/Chart.min.js"></script>

    <script src="/otherjs/sweetalert.js"></script>
    <script>
        var class_general = [];
        var present_general = [];
        var permit_general = [];
        var absent_general = [];

        var present_general_prev = [];
        var permit_general_prev = [];
        var absent_general_prev = [];

        var barChart;
        var lineChartPresent;
        var lineChartPermit;
        var lineChartAbsent;

        var thisMonthName;
        var prevMonthName;
        var listOfMonth = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus',
            'September', 'Oktober', 'November', 'Desember'
        ];

        $(document).ready(function() {
            set_current_month();
            get_recap_presence(0);

            $('#month').on('change', function() {
                get_recap_presence($(this).val());
            })

            $('#analysis-chart').on('click', function() {
                chart();
                $('#modal-chart').modal('show');
            })
        });

        function set_current_month() {
            var date = new Date()

            let month = date.getMonth();

            $('#month').val(parseInt(month + 1));
        }

        function get_recap_presence(month) {


            $.ajax({
                url: '/api/presence/get-recap-presence?month=' + month,
                method: 'GET',
                dataType: 'json',
                success: function(response) {

                    if (response.data != undefined || response.data != null) {

                        set_analysis_chart_this_month(month, response.data);
                        set_analysis_chart_prev_month(parseInt(month));

                        let row = '';
                        for (let i = 0; i < response.data.length; i++) {
                            let obj = response.data[i];

                            let present = obj.present === 0 ? '-' : obj.present_percent + '%';
                            let permit = obj.permit === 0 ? '-' : obj.permit_percent + '%';
                            let absent = obj.absent === 0 ? '-' : obj.absent_percent + '%';
                            let total = parseInt(obj.total) == 0 ? '-' : obj.total + '%';
                            let total_pertemuan = parseInt(obj.total_pertemuan) == 0 ? '-' : obj
                                .total_pertemuan;



                            row += `<tr>
                                        <td class="text-center">${obj.class.toUpperCase()}</td>
                                        <td class="text-center">${present}</td>
                                        <td class="text-center">${permit}</td>
                                        <td class="text-center">${absent}</td>
                                        <td class="text-center">${total}</td>
                                        <td class="text-center">${total_pertemuan}</td>
                                        <td class="text-center">${obj.bulan}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs" onclick="DetailClass('${obj.classid}','${obj.class.toUpperCase()}','${obj.bulan}')"><i class="fa fa-arrow-right "></i></button>
                                        </td>
                                        </tr>`
                        }
                        $('#recap-presence > tbody').html(null);
                        $('#recap-presence > tbody').append(row);

                    }
                },
                error: function(response) {

                }
            });
        }

        function get_recap_presence_in_class(class_level) {
            let month = $('#month').val();

            $.ajax({
                url: '/api/presence/get-recap-presence-in-class?month=' + month + '&class_level=' + class_level,
                method: 'GET',
                dataType: 'json',
                success: function(response) {

                    if (response.data != undefined || response.data != null) {

                        let row = '';
                        for (let i = 0; i < response.data.length; i++) {
                            let obj = response.data[i];

                            let present = parseInt(obj.present);
                            let permit = parseInt(obj.permit);
                            let absent = parseInt(obj.absent);

                            row += `<tr>
                                        <td class="text-center">${obj.fullname}</td>
                                        <td class="text-center">${obj.classname}</td>
                                        <td class="text-center">${present}</td>
                                        <td class="text-center">${permit}</td>
                                        <td class="text-center">${absent}</td>
                                        </tr>`
                        }
                        $('#recap-presence-in-class > tbody').html(null);
                        $('#recap-presence-in-class > tbody').append(row);

                    }
                },
                error: function(response) {

                }
            });
        }

        function DetailClass(id, classname, month) {
            $('#modal-title').text(`${classname} - Periode ${month}`);
            get_recap_presence_in_class(id);
            $('#modal-recap').modal('show');
        }

        function set_analysis_chart_this_month(month, data) {

            if (month == 0) {
                var date = new Date()
                let month = date.getMonth();
                thisMonthName = listOfMonth[month];
            } else {
                thisMonthName = listOfMonth[month - 1];
            }


            class_general = [];
            present_general = [];
            permit_general = [];
            absent_general = [];

            for (let i = 0; i < data.length; i++) {
                let obj = data[i];

                class_general.push(obj.class.toUpperCase());
                present_general.push(obj.present === 0 ? null : parseFloat(obj.present_percent));
                permit_general.push(obj.permit === 0 ? null : parseFloat(obj.permit_percent));
                absent_general.push(obj.absent === 0 ? null : parseFloat(obj.absent_percent));

            }
        }

        function set_analysis_chart_prev_month(prevMonth) {

            if (prevMonth == 0) {
                var date = new Date()
                let month = date.getMonth();
                prevMonth = parseInt(month - 1 + 1);
            } else {
                prevMonth = prevMonth - 1;
            }

            prevMonthName = listOfMonth[prevMonth - 1];

            present_general_prev = [];
            permit_general_prev = [];
            absent_general_prev = [];

            $.ajax({
                url: '/api/presence/get-recap-presence?month=' + prevMonth,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {


                        for (let i = 0; i < response.data.length; i++) {
                            let obj = response.data[i];

                            present_general_prev.push(obj.present === 0 ? null : parseFloat(obj
                                .present_percent));
                            permit_general_prev.push(obj.permit === 0 ? null : parseFloat(obj.permit_percent));
                            absent_general_prev.push(obj.absent === 0 ? null : parseFloat(obj.absent_percent));

                        }
                    }
                },
                error: function(response) {

                }
            })
        }

        function chart() {

            if (barChart) {
                barChart.destroy();
            }

            Chart.defaults.global.defaultFontFamily = "Segoe UI";
            Chart.defaults.global.defaultFontSize = 14;

            //----------------
            //- Current Month
            //----------------
            var areaChartDataCurrentMonth = {
                labels: class_general //['Dasar Paud/TK', 'Dasar 1', 'Dasar 3A', 'Dasar 3B', 'Dasar 4', 'Dasar 6', 'Praremaja 1',
                    //     'Praremaja 3', 'Remaja']
                    ,
                datasets: [{
                        label: 'Hadir',
                        backgroundColor: '#115f9a',
                        borderColor: '#115f9a',
                        pointRadius: false,
                        pointColor: '#228257',
                        pointStrokeColor: '#115f9a',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: '#115f9a',
                        data: present_general //[0, 0, 0, 90, 80, 75, 77, 86, 93]
                    },
                    {
                        label: 'Izin',
                        backgroundColor: '#ffb400',
                        borderColor: '#ffb400',
                        pointRadius: false,
                        pointColor: '#ffb400',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: '#ffb400',
                        data: permit_general //[0, 0, 0, 5, 15, 20, 23, 10, 7]
                    },
                    {
                        label: 'Alfa',
                        backgroundColor: '#991f17',
                        borderColor: '#991f17',
                        pointRadius: false,
                        pointColor: '#991f17',
                        pointStrokeColor: '#a12031',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: '#991f17',
                        data: absent_general //[0, 0, 0, 5, 5, 10, 7, 0, 3]
                    },
                ]
            }

            var barChartCanvasCurrentMonth = $('#barChartCurrentMonth').get(0).getContext('2d');
            var barChartDataCurrentMonth = jQuery.extend(true, {}, areaChartDataCurrentMonth);
            var tempPresentCurrentMonth = areaChartDataCurrentMonth.datasets[0];
            var tempPermitCurrentMonth = areaChartDataCurrentMonth.datasets[1];
            var tempAbsentCurrentMonth = areaChartDataCurrentMonth.datasets[2];
            barChartDataCurrentMonth.datasets[0] = tempPresentCurrentMonth;
            barChartDataCurrentMonth.datasets[1] = tempPermitCurrentMonth;
            barChartDataCurrentMonth.datasets[2] = tempAbsentCurrentMonth;

            var barChartOptionsCurrentMonth = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false
            }

            barChart = new Chart(barChartCanvasCurrentMonth, {
                type: 'bar',
                data: barChartDataCurrentMonth,
                options: barChartOptionsCurrentMonth
            })




            //---------------- Present
            if (lineChartPresent) {
                lineChartPresent.destroy();
            }

            var presentCanvas = document.getElementById("presentChart");



            var dataFirstPresent = {
                label: `Kehadiran ${thisMonthName}`,
                data: present_general, //[null, 80, 75, 76, 79.70, 89, 100, 83, 92],
                lineTension: 0,
                fill: false,
                borderColor: '#016473'
            };

            var dataSecondPresent = {
                label: `Kehadiran ${prevMonthName}`,
                data: present_general_prev, //[93, 73, 75, 89, 60, 91, 90, 80, 98],
                lineTension: 0,
                fill: false,
                borderColor: '#06b2cc'
            };

            var presentData = {
                labels: class_general, //["Paud/TK", "Dasar 1", "Dasar 3A", "Dasar 3B", "Dasar 4", "Dasar 6", "Praremaja 1",
                //"Praremaja 2", "Remaja"],
                datasets: [dataFirstPresent, dataSecondPresent]
            };

            var chartOptionsPresent = {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 80,
                        fontColor: 'black'
                    }
                }
            };

            lineChartPresent = new Chart(presentCanvas, {
                type: 'line',
                data: presentData,
                options: chartOptionsPresent
            });


            //---------------- Permit

            if (lineChartPermit) {
                lineChartPermit.destroy();
            }

            var permitCanvas = document.getElementById("permitChart");


            var dataFirstPermit = {
                label: `Izin ${thisMonthName}`,
                data: permit_general, //[90, 80, 75, 76, 79.70, 89, 100, 83, 92],
                lineTension: 0,
                fill: false,
                borderColor: '#6e4801'
            };

            var dataSecondPermit = {
                label: `Izin ${prevMonthName}`,
                data: permit_general_prev, //[93, 73, 75, 89, 60, 91, 90, 80, 98],
                lineTension: 0,
                fill: false,
                borderColor: '#de9204'
            };

            var permitData = {
                labels: class_general, //["Paud/TK", "Dasar 1", "Dasar 3A", "Dasar 3B", "Dasar 4", "Dasar 6", "Praremaja 1",
                // "Praremaja 2", "Remaja"],
                datasets: [dataFirstPermit, dataSecondPermit]
            };

            var chartOptionsPermit = {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 80,
                        fontColor: 'black'
                    }
                }
            };

            lineChartPermit = new Chart(permitCanvas, {
                type: 'line',
                data: permitData,
                options: chartOptionsPermit
            });

            //---------------- Absent

            if (lineChartAbsent) {
                lineChartAbsent.destroy();
            }

            var absentCanvas = document.getElementById("absentChart");


            var dataFirstAbsent = {
                label: `Alfa ${thisMonthName}`,
                data: absent_general, //[90, 80, 75, 76, 79.70, 89, 100, 83, 92],
                lineTension: 0,
                fill: false,
                borderColor: '#660207'
            };

            var dataSecondAbsent = {
                label: `Alfa ${prevMonthName}`,
                data: absent_general_prev, //[93, 73, 75, 89, 60, 91, 90, 80, 98],
                lineTension: 0,
                fill: false,
                borderColor: '#e6020e'
            };

            var absentData = {
                labels: class_general, //["Paud/TK", "Dasar 1", "Dasar 3A", "Dasar 3B", "Dasar 4", "Dasar 6", "Praremaja 1",
                //"Praremaja 2", "Remaja"],
                datasets: [dataFirstAbsent, dataSecondAbsent]
            };

            var chartOptionsAbsent = {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        boxWidth: 80,
                        fontColor: 'black'
                    }
                }
            };

            lineChartAbsent = new Chart(absentCanvas, {
                type: 'line',
                data: absentData,
                options: chartOptionsAbsent
            });
        }
    </script>
@endpush
