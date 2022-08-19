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
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <h5 style="text-align: center;"><strong id="date-id"></strong></h5>

                    <input type="hidden" id="username-id" value="{{ auth()->user()->username }}">
                    <input type="hidden" id="teacher-presence-id" value="0">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Tanggal Presensi</label>
                                <div class="input-group date">
                                    <input type="text" class="form-control" id="date-presence">
                                    <span class="input-group-append">
                                        <span class="input-group-text bg-white d-block">
                                            <i class="fa fa-calendar"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Waktu Masuk</label>

                                <div class="input-group date" id="timepicker" data-target-input="nearest">
                                    <input type="text" id="time-in" class="form-control datetimepicker-input"
                                        data-target="#timepicker" data-toggle="datetimepicker" />
                                    <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="far fa-clock"></i></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Kelas</label>
                                <select class="form-control" id="class-level" style="width: 100%;">

                                </select>
                            </div>

                        </div>

                    </div>



                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <table class="table table-borderless table-striped table-sm" id="presence-id">

                    </table>
                </div>
            </div>

            <div class="row justify-content-center mt-2">
                <button type="button" class="btn btn-success" id="request-presence"><i class="fa fa-paper-plane"></i>
                    Ajukan Presensi</button>
            </div>

        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            Footer
        </div>
        <!-- /.card-footer-->
    </div>
    <!-- /.card -->
@endsection


@push('css')
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        .opacity {
            opacity: 0.5;
        }

        .hide {
            display: none;
        }
    </style>
@endpush

@push('js')
    <!-- jQuery -->
    <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- InputMask -->
    <script src="/adminlte/plugins/moment/moment.min.js"></script>
    <script src="/adminlte/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- Select2 -->
    <script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>
    <!-- jquery-validation -->
    <script src="/adminlte/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="/adminlte/plugins/jquery-validation/additional-methods.min.js"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>
    <script src="/otherjs/sweetalert.js"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            //Timepicker
            $('#timepicker').datetimepicker({
                format: 'LT'
            })

            $('#date-presence').datepicker({
                format: "dd/mm/yyyy",
                autoclose: true
            });

            populate_class_select();

            $('#class-level').on('change', function() {

                get_student_list(this.value);
            })

            $('#request-presence').on('click', function() {

                let user = $('#username-id').val();
                let date = $('#date-presence').val();
                let time = $('#time-in').val();
                let classLevel = $('#class-level').val();

                if (date == "") {
                    swal("Peringatan", 'Tanggal harus diisi', "warning");
                    return;
                }

                if (time == "") {
                    swal("Peringatan", 'Waktu harus diisi', "warning");
                    return;
                }

                if (classLevel == "") {
                    swal("Peringatan", 'Kelas harus dipilih', "warning");
                    return;
                }

                let convertDate = convert_date_to_dash(date);
                let convertTime = convert_time_to_hhmmss(time);
                let students = [];

                $('#presence-id > tbody  > tr').each(function(index, tr) {

                    let studentId = tr.children[2].children[0].name;
                    let isPresent = tr.children[2].children[0].checked;
                    let isPermit = tr.children[3].children[0].checked;
                    let isAbsent = tr.children[4].children[0].checked;

                    students.push({
                        'student_id': studentId,
                        'is_present': isPresent,
                        'is_permit': isPermit,
                        'is_absent': isAbsent
                    });
                });

                let dataRequest = {
                    'user': user,
                    'date': convertDate,
                    'time': convertTime,
                    'class-level': classLevel,
                    'students': students
                };

                check_teacher_presence(dataRequest);


            })

        });

        function check_teacher_presence(data) {

            $.ajax({
                url: "/api/presence-teacher/presence-check?id=" + data.user + "&date=" + data.date,
                method: 'GET',
                dataType: 'json',
                success: function(response) {

                    if (response.data != undefined || response.data != null) {
                        if (response.data > 0) {
                            swal("Peringatan", "Anda sudah pernah presensi", "warning");
                        } else {
                            $.ajax({
                                url: "/api/presence-teacher/post-request-presence",
                                type: 'POST',
                                dataType: 'json',
                                contentType: 'json',
                                data: JSON.stringify(data),
                                contentType: 'application/json; charset=utf-8',
                                headers: {
                                    'X-CSRF-TOKEN': CSRF_TOKEN
                                },
                                success: function(response) {
                                    swal("Berhasil", "Data Berhasil Ditambahkan", "success");

                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000)
                                },
                                error: function(response) {
                                    swal("Gagal", response.status + "-" + response.statusText,
                                        "error");
                                }
                            });
                        }


                    }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });



        }

        function convert_date_to_dash(date) {
            let dateDash = date.replace(/\//g, '-');
            let dateReverseJoin = dateDash.split("-").reverse().join("-");

            return dateReverseJoin;
        }

        function convert_time_to_hhmmss(time) {

            let timeAPM = time.split(' ')[1];
            let timeHhmmss = time.split(' ')[0].split(':');

            let hour = null;

            if (timeAPM == "PM") {
                hour = parseInt(timeHhmmss[0]) + parseInt(12);
                return `${hour}:${timeHhmmss[1]}:00`;
            } else if (timeAPM == "AM") {
                hour = parseInt(timeHhmmss[0]);
                return `${hour}:${timeHhmmss[1]}:00`;
            }

            if (hour == null)
                return '';
        }

        function populate_class_select() {

            let url = "/api/class-level/class-level-list-exist-in-group";
            $.ajax({
                url: url,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $("#class-level").append(
                            `<option value="">Pilih Kelas</option>`
                        );

                        for (let i = 0; i < response.data.length; i++) {
                            $("#class-level").append(
                                `<option value="${response.data[i].id}">Presensi Kelas ${response.data[i].name}</option>`
                            );
                        }

                    }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });

        }

        function get_student_list(classid) {
            $.ajax({
                url: "/api/presence/get-students/" + classid,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {

                        let presenceTbl = document.querySelector("#presence-id");

                        presenceTbl.innerHTML = "";

                        let row = `<thead>
                    <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th width="15%">
                      Hadir
                    </th>
                    <th width="15%">
                      Izin
                    </th>
                    <th width="15%">
                      Alfa
                    </th>
                  </tr></thead>`;

                        let students_orig = response.data.students_orig;
                        let students_presence = response.data.students_presence;

                        for (let i = 0; i < students_orig.length; i++) {
                            let no = parseInt(i + 1);

                            let stdId = students_orig[i].student_id;
                            let name = students_orig[i].fullname;


                            row += `<tr>
                            <td>` + no + `</td>
                            <td>` + name + `</td>
                            <td>
                                <input type="radio" class="icheck-primary" id="presentId" value="H" name="` + stdId + `">
                            </td>
                            <td>
                                <input type="radio" class="icheck-primary" id="permitId" value="I" name="` + stdId + `">
                            </td>
                            <td>
                                <input type="radio" class="icheck-primary" id="absentId" value="A" name="` + stdId + `">
                            </td>
                            </tr>`;
                        }

                        presenceTbl.innerHTML = row;
                    }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });
        }
    </script>
@endpush
