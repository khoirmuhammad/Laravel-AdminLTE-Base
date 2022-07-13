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

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body" id="card-body-id">
            <div class="row mb-2">
                <div class="col-md-9"></div>
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
                    <table class="table table-bordered" id="recap-presence">
                        <thead>
                            <tr>
                                <th class="text-center"></th>
                                <th colspan="4" class="text-center">Persentase</th>
                                <th rowspan="2" class="text-center">Pertemuan</th>
                                <th rowspan="2" class="text-center">Bulan Periode</th>
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
                            <table class="table table-bordered" id="recap-presence-in-class">
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

@endsection


@push('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">

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

    <script>
        $(document).ready(function() {
            set_current_month();
            get_recap_presence(0);

            $('#month').on('change', function() {
                get_recap_presence($(this).val());
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
                    debugger;
                    if (response.data != undefined || response.data != null) {

                        let row = '';
                        for (let i = 0; i < response.data.length; i++) {
                            let obj = response.data[i];

                            let present = parseInt(obj.present_percent) == 0 ? '-' : obj.present_percent + '%';
                            let permit = parseInt(obj.permit_percent) == 0 ? '-' : obj.permit_percent + '%';
                            let absent = parseInt(obj.absent_percent) == 0 ? '-' : obj.absent_percent + '%';
                            let total = parseInt(obj.total) == 0 ? '-' : obj.total + '%';
                            let total_pertemuan = parseInt(obj.total_pertemuan) == 0 ? '-' : obj.total_pertemuan;

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
                url: '/api/presence/get-recap-presence-in-class?month=' + month +'&class_level=' + class_level ,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    debugger;
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
    </script>
@endpush
