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
            <form id="role-category-form">
                <div>
                    <p class="maintitle">Jadwal Kegiatan Bulanan</p>
                </div>

                <div class="row mb-3">
                    <div class="col-md-2">
                        <button id="btn-add" type="button" class="btn btn-primary"><i class="fa fa-calendar"></i>
                            Tambah</button>
                    </div>

                    <div class="col-md-3">

                    </div>



                    <div class="col-md-3">
                        <select id="level-filter" name="level-filter" class="form-control" style="width: 100%;">
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="class-filter" name="class-filter" class="form-control" style="width: 100%;">
                            <option value="">PILIH KELAS</option>
                        </select>
                    </div>

                    <div class="col-md-1">
                        <button id="btnSearch" type="button" class="btn btn-success"><i class="fa fa-search"></i></button>
                    </div>

                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <input type="hidden" id="group"
                            value="{{ request()->session()->has('group')? session('group'): '' }}" />

                        <table class="table table-sm" id="tbl-schedule">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Kelas</th>
                                    <th scope="col">Jenjang</th>
                                    <th scope="col">Hari</th>
                                    <th scope="col">Waktu Mulai</th>
                                    <th scope="col">Waktu Selesai</th>
                                    <th scope="col">#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>

                </div>


            </form>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->


    <div class="modal fade" id="modal-add-activity" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Jadwal Reguler</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Jenjang</label>
                                <select id="level" name="level" class="form-control" style="width: 100%;">
                                    <option value="">Pilih</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group clearfix" id="classes">

                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Pilih Hari</label>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="senin" name="day" value="Senin">
                                    <label for="senin">
                                        Senin
                                    </label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="icheck-warning">
                                    <input type="checkbox" id="jumat" name="day" value="Jumat">
                                    <label for="jumat">
                                        Jumat
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-success">
                                    <input type="checkbox" id="selasa" name="day" value="Selasa">
                                    <label for="selasa">
                                        Selasa
                                    </label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="icheck-info">
                                    <input type="checkbox" id="sabtu" name="day" value="Sabtu">
                                    <label for="sabtu">
                                        Sabtu
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-danger">
                                    <input type="checkbox" id="rabu" name="day" value="Rabu">
                                    <label for="rabu">
                                        Rabu
                                    </label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="icheck-secondary">
                                    <input type="checkbox" id="minggu" name="day" value="Minggu">
                                    <label for="minggu">
                                        Minggu
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-dark">
                                    <input type="checkbox" id="kamis" name="day" value="Kamis">
                                    <label for="kamis">
                                        Kamis
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Waktu Mulai</label>
                                <input type="time" class="form-control" id="start_time" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Waktu Selesai</label>
                                <input type="time" class="form-control" id="end_time" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="button" id="btnCreate" class="btn btn-primary">
                            <i id="loading-icon-select" class="fa fa-spinner fa-spin hide"></i>
                            <span id="create-text">Buat Jadwal</span>
                        </button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>

    <div class="modal fade" id="modal-edit-activity" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Jadwal Reguler</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="hdId" />
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Jenjang</label>
                                <input type="text" class="form-control" id="edLevel" disabled />
                            </div>

                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Kelas</label>
                                <input type="text" class="form-control" id="edClass" disabled />
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-md-12">
                            <label>Pilih Hari</label>
                        </div>
                    </div>
                    <div class="row mb-1">
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-primary">
                                    <input type="checkbox" id="edSenin" name="edDay" value="Senin">
                                    <label for="senin">
                                        Senin
                                    </label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="icheck-warning">
                                    <input type="checkbox" id="edJumat" name="edDay" value="Jumat">
                                    <label for="jumat">
                                        Jumat
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-success">
                                    <input type="checkbox" id="edSelasa" name="edDay" value="Selasa">
                                    <label for="selasa">
                                        Selasa
                                    </label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="icheck-info">
                                    <input type="checkbox" id="edSabtu" name="edDay" value="Sabtu">
                                    <label for="sabtu">
                                        Sabtu
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-danger">
                                    <input type="checkbox" id="edRabu" name="edDay" value="Rabu">
                                    <label for="rabu">
                                        Rabu
                                    </label>
                                </div>
                            </div>
                            <div class="form-group clearfix">
                                <div class="icheck-secondary">
                                    <input type="checkbox" id="edMinggu" name="edDay" value="Minggu">
                                    <label for="minggu">
                                        Minggu
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group clearfix">
                                <div class="icheck-dark">
                                    <input type="checkbox" id="edKamis" name="edDay" value="Kamis">
                                    <label for="kamis">
                                        Kamis
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row mb-1">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Waktu Mulai</label>
                                <input type="time" class="form-control" id="edStartTime" />
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Waktu Selesai</label>
                                <input type="time" class="form-control" id="edEndTime" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="button" id="btnModify" class="btn btn-primary">
                            <i id="loading-icon-select" class="fa fa-spinner fa-spin hide"></i>
                            <span id="modify-text">Perbarui Jadwal</span>
                        </button>
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
    <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        .opacity {
            opacity: 0.5;
        }

        .hide {
            display: none;
        }

        .maintitle {
            padding: 0px 0 0px 0%;
            margin-bottom: 20px;
            text-align: center;
            font-size: 30px;
            font-weight: 200;
        }
    </style>
@endpush

@push('js')
    <!-- jQuery -->
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- InputMask -->
    <script src="/adminlte/plugins/moment/moment.min.js"></script>z
    <script src="/adminlte/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Select2 -->
    <script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>
    <!-- jquery-validation -->
    <script src="/adminlte/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/adminlte/plugins/jquery-validation/additional-methods.min.js"></script>

    <script src="/otherjs/sweetalert.js"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            get_schedules();
            set_levels_filter();

            $('#btn-add').on('click', function() {
                get_level();
                clearElementPopup();
                $('#modal-add-activity').modal('show');
            })


            $('#level-filter').on('change', function() {
                get_class_level_filter(this.value);
            })

            $('#level').on('change', function() {
                debugger;
                get_class_level(this.value);
            })

            $('#btnCreate').on('click', function() {
                debugger;
                let level_val = $('#level').val();
                let class_level_selected = $('input[name^="class_level"]:checked').length;
                let day_selected = $('input[name^="day"]:checked').length;
                let start_time_val = $('#start_time').val();
                let end_time_val = $('#end_time').val();

                if (level_val == "") {
                    swal("Peringatan", "Jenjang harus dipilih", "info");
                    return;
                } else if (class_level_selected == 0) {
                    swal("Peringatan", "Kelas harus dipilih", "info");
                    return;
                } else if (day_selected == 0) {
                    swal("Peringatan", "Hari harus dipilih", "info");
                    return;
                } else if (start_time_val == "") {
                    swal("Peringatan", "Waktu mulai harus diisi", "info");
                    return;
                } else if (end_time_val == "") {
                    swal("Peringatan", "Waktu selesai harus diisi", "info");
                    return;
                } else {
                    save_schedules();
                }


            })

            $('#btnModify').on('click', function() {
                let level_val = $('#edLevel').val();
                let class_level_val = $('#edClass').val();
                let day_selected = $('input[name^="edDay"]:checked').length;
                let start_time_val = $('#edStartTime').val();
                let end_time_val = $('#edEndTime').val();

                if (level_val == "") {
                    swal("Peringatan", "Jenjang harus dipilih", "info");
                    return;
                } else if (class_level_val == "") {
                    swal("Peringatan", "Kelas harus diisi", "info");
                    return;
                } else if (day_selected == 0) {
                    swal("Peringatan", "Hari harus dipilih", "info");
                    return;
                } else if (start_time_val == "") {
                    swal("Peringatan", "Waktu mulai harus diisi", "info");
                    return;
                } else if (end_time_val == "") {
                    swal("Peringatan", "Waktu selesai harus diisi", "info");
                    return;
                } else {
                    update_schedule();
                }
            })

            $('#btnSearch').on('click', function() {
                debugger;
                get_schedules();
            })


        });


        function get_level() {
            $.ajax({
                url: "/api/level/level-list",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        for (let i = 0; i < response.data.length; i++) {
                            $("#level").append(
                                `<option value="${response.data[i].id}">${response.data[i].name}</option>`);
                        }
                    }
                },
                error: function(response) {

                }
            });
        }

        function get_class_level(level) {
            debugger
            let group = $('#group').val();
            $.ajax({
                url: `/api/class-level/class-level-list-by-level/${level}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#classes').empty().trigger("change");
                        $('#classes').append('<label>Pilih Kelas</label><br>');
                        for (let i = 0; i < response.data.length; i++) {
                            $("#classes").append(`<div class="icheck-info d-inline">
                                    <input type="checkbox" id="class_${response.data[i].id}" name="class_level" value="${response.data[i].id}">
                                    <label for="class_${response.data[i].id}">
                                        ${response.data[i].name}
                                    </label>
                                </div>`);
                        }
                    }
                },
                error: function(response) {

                }
            });
        }


        function set_levels_filter() {
            $.ajax({
                url: "/api/level/level-list",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $("#level-filter").append(
                            `<option value="">SEMUA JENJANG</option>`);
                        for (let i = 0; i < response.data.length; i++) {
                            $("#level-filter").append(
                                `<option value="${response.data[i].id}">${response.data[i].name}</option>`);
                        }
                    }
                },
                error: function(response) {

                }
            });
        }

        function get_class_level_filter(level) {
            debugger
            if (level == null || level == '') {
                $('#class-filter').empty().trigger("change");
                $("#class-filter").append(`<option value="">PILIH KELAS</option>`);
                return;
            }
            let group = $('#group').val();
            $.ajax({
                url: `/api/class-level/class-level-list/${group}/${level}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#class-filter').empty().trigger("change");
                        $("#class-filter").append(`<option value="">PILIH KELAS</option>`);
                        for (let i = 0; i < response.data.length; i++) {
                            $("#class-filter").append(
                                `<option value="${response.data[i].id}">${response.data[i].name}</option>`);
                        }
                    }
                },
                error: function(response) {

                }
            });
        }

        function save_schedules() {
            $(`#create-text`).text('Sedang Menyimpan...');
            let schedules = [];

            let class_levels = $('[name="class_level"]');
            $.each(class_levels, function() {
                if ($(this).is(":checked")) {
                    let classLevel = $(this).val();
                    let startTime = $('#start_time').val();
                    let endTime = $('#end_time').val();
                    let level = $('#level').val();

                    let days = $('[name="day"]');
                    $.each(days, function() {
                        if ($(this).is(":checked")) {
                            let day = $(this).val();

                            schedules.push({
                                'level': level,
                                'class_level': classLevel,
                                'day': day,
                                'start_time': startTime,
                                'end_time': endTime
                            });
                        }
                    });

                }
            });

            debugger;
            $.ajax({
                url: "/api/schedule/post-insert",
                type: 'POST',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(schedules),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    debugger

                    if (response == 204) {
                        swal("Peringatan", `Data jadwal telah tersedia`, "info");
                    } else {
                        swal("Berhasil", `Data jadwal berhasil ditambahkan`, "success");
                    }



                    $(`#create-text`).text('Buat Jadwal');
                    clearElementPopup();
                    $('#modal-add-activity').modal('hide');
                    get_schedules();
                },
                error: function(response) {
                    debugger
                    if (response.status == 500) {
                        let error_message = response.responseJSON.error_message;
                        let logKey = response.responseJSON.log_key;

                        let alert_message;

                        if (logKey == undefined)
                            alert_message = error_message;
                        else
                            alert_message =
                            `${error_message}. Copy dan beritaukan kode log berikut ke admin = ${logKey}`;

                        swal("Gagal", alert_message, "error");
                    } else {
                        swal("Gagal", `${response.status} - ${response.statusText}`, "error");
                    }

                    $(`#create-text`).text('Buat Jadwal');
                }
            });

        }

        function update_schedule() {
            $(`#modify-text`).text('Sedang Memperbarui...');

            let schedule = {
                'id': $('#hdId').val(),
                'start_time': $('#edStartTime').val(),
                'end_time': $('#edEndTime').val()
            };

            $.ajax({
                url: "/api/schedule/put-update",
                type: 'PUT',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(schedule),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    debugger

                    swal("Berhasil", `Data Jadwal berhasil diperbarui`, "success");

                    $(`#modify-text`).text('Perbarui Jadwal');
                    $('#modal-edit-activity').modal('hide');
                    get_schedules();
                },
                error: function(response) {
                    debugger
                    if (response.status == 500) {
                        let error_message = response.responseJSON.error_message;
                        let logKey = response.responseJSON.log_key;

                        let alert_message;

                        if (logKey == undefined)
                            alert_message = error_message;
                        else
                            alert_message =
                            `${error_message}. Copy dan beritaukan kode log berikut ke admin = ${logKey}`;

                        swal("Gagal", alert_message, "error");
                    } else {
                        swal("Gagal", `${response.status} - ${response.statusText}`, "error");
                    }

                    $(`#modify-text`).text('Perbarui Jadwal');
                }
            });

        }

        function clearElementPopup() {
            $('#level').val('');
            $('#start_time').val('');
            $('#end_time').val('');
            $('input[name^="day"]').prop('checked', false)
            $('input[name^="class_level"]').prop('checked', false)
        }

        function get_schedules() {
            debugger;
            let level = $("#level-filter").val();
            let classLevel = $('#class-filter').val();

            let levelVal = level == "" || level == null;
            let classVal = classLevel == "" || classLevel == null;

            let url = '/api/schedule/get-schedule-group';

            if (!levelVal && classVal) {
                url = `${url}?level=${level}`;
            }

            if (!levelVal && !classVal) {
                url = `${url}?level=${level}&class_level=${classLevel}`;
            }

            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    debugger;
                    if (response.data != undefined || response.data != null) {

                        let row = '';
                        for (let i = 0; i < response.data.length; i++) {
                            let no = i + 1;

                            let id = response.data[i].id;
                            let classLevel = response.data[i].class_level;
                            let level = response.data[i].level;
                            let day = response.data[i].day;
                            let startTime = response.data[i].start_time.substring(0, 5);
                            let endTime = response.data[i].end_time.substring(0, 5);

                            row += `<tr>
                                        <td>${no}</td>
                                        <td>${classLevel}</td>
                                        <td>${level}</td>
                                        <td>${day}</td>
                                        <td>${startTime}</td>
                                        <td>${endTime}</td>
                                        <td>
                                            <button type="button" class="btn btn-info btn-xs" onclick="editSchedule('${id}','${classLevel}','${level}','${day}','${startTime}','${endTime}')"><i class="fa fa-pencil"></i></button>
                                            <button type="button" class="btn btn-danger btn-xs" onclick="deleteSchedule('${response.data[i].id}')"><i class="fa fa-trash"></i></button>
                                        </td>
                                        </tr>`
                        }
                        $('#tbl-schedule > tbody').html(null);
                        $('#tbl-schedule > tbody').append(row);

                    }
                },
                error: function(response) {

                }
            });
        }

        function deleteSchedule(id) {
            swal({
                    title: "Apakah Anda Yakin?",
                    text: `Menghapus jadwal ini dari database!`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        performDeleteSchedule(id);
                    }
                });

            return false;
        }

        function performDeleteSchedule(id) {
            debugger;
            $.ajax({
                url: "/api/schedule/delete-schedule",
                type: 'DELETE',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify({
                    'id': id
                }),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    debugger;
                    swal("Berhasil", `Jadwal berhasil dihapus`, "success");
                    get_schedules();

                },
                error: function(response) {
                    if (response.status == 409) {
                        swal("Peringatan", `${response.responseJSON.error_message}`, "info");
                    } else if (response.status == 500) {
                        let error_message = response.responseJSON.error_message;
                        let logKey = response.responseJSON.log_key;

                        let alert_message;

                        if (logKey == undefined)
                            alert_message = error_message;
                        else
                            alert_message =
                            `${error_message}. Copy dan beritaukan kode log berikut ke admin = ${logKey}`;

                        swal("Gagal", alert_message, "error");
                    } else {
                        swal("Peringatan", `${response.status} - ${response.statusText}`, "error");
                    }
                }
            });
        }

        function editSchedule(id, classLevel, level, day, startTime, endTime) {
            debugger;
            $('#hdId').val(id);

            $('#edLevel').val(level);
            $('#edClass').val(classLevel);

            $('input[name^="edDay"]').prop('checked', false)
            $('input[name^="edDay"]').prop('disabled', true)
            $(`#ed${day}`).prop('checked', true);

            $('#edStartTime').val(startTime);
            $('#edEndTime').val(endTime);


            $('#modal-edit-activity').modal('show');
        }
    </script>
@endpush
