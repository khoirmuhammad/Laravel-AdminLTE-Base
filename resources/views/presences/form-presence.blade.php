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
                    <h3 style="text-align: center;"><strong>{{ $start }} - {{ $end }}</strong></h3>
                    <input type="hidden" id="username-id" value="{{ auth()->user()->username }}">
                    <input type="hidden" id="teacher-presence-id" value="0">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="70%" style="text-align:center" colspan="2">{{ auth()->user()->name }}
                                </th>
                            </tr>
                            <tr>
                                <th style="text-align: center;font-size:14px">
                                    <span id="text-in" class="hide">Presensi Masuk 10:35</span>
                                    <button class="btn btn-block btn-primary btn-sm" id="clock-in"> <i id="icon-in" class="fa fa-check"
                                            aria-hidden="true"></i> <i id="loading-icon-in" class="fa fa-spinner fa-spin hide"></i> <span id="span-in"> Masuk</span></button>
                                </th>
                                <th style="text-align: center;font-size:14px">
                                    <span id="text-out" class="hide">Presensi Keluar 10:35</span>
                                    <button class="btn btn-block btn-secondary btn-sm" id="clock-out"> <i
                                            class="fa fa-check" aria-hidden="true"></i> Keluar</button>
                                </th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-6">
                    <table class="table table-bordered table-striped" id="presence-id">

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

    <div class="modal fade" id="modal-clockout">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Jam Keluar</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Hasil Pembelajaran</label>
                            <textarea id="result-learning-id" class="form-control" rows="3" placeholder="Tuliskan hasil pembelajaran"></textarea>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="button" id="btnClockOut" class="btn btn-secondary">
                            <i id="loading-icon-precense-out" class="fa fa-spinner fa-spin hide"></i>
                            <span id="precense-out-text">Presensi Keluar</span>
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
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


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

    <script src="/otherjs/sweetalert.js"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            set_time();
            set_teacher_presence();
            get_student_list();


            $('#clock-in').on('click', function() {
                let id = $('#teacher-presence-id').val();

                if (parseInt(id) != 0) {
                    swal("Info", `Anda sudah melakukan presensi masuk`, "info");
                    return;
                }

                $('#modal-clockout').modal('hide');

                $('#loading-icon-in').removeClass('hide');
                $('#icon-in').addClass('hide');
                $('#span-in').text('');

                proceedClockInOut('in');
            })

            $('#clock-out').on('click', function() {
                let id = $('#teacher-presence-id').val();

                if (parseInt(id) == 0) {
                    swal("Info", `Anda belum melakukan presensi masuk`, "info");
                    return;
                }

                let totalPrecense = parseInt($('#presence-id > > tr').length - 1);
                let actualPresence = 0;

                $('#presence-id > > tr').each(function(index, tr) {
                    debugger;
                    if (index != 0 && index <= totalPrecense) {
                        let hdId = $(`#hdId${index}`).length;

                        if (hdId != 0) {
                            if ($(`#hdId${index}`).val() != 0) {
                                actualPresence = actualPresence + 1;
                            }
                        }
                    }
                });

                if (totalPrecense == actualPresence) {
                    alert('ok')
                } else {
                    swal("Info", `Mohon lengkapi presensi generus di kelas ini`, "info");
                    return
                }

                return;
                //$('#modal-clockout').modal('show');
            })


            $('#btnClockOut').on('click', function() {
                proceedClockInOut('out');
            })
        });

        function set_time() {
            let days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            let months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
                'November', 'Desember'
            ];

            let currentDate = new Date();

            let day = days[currentDate.getDay()];
            let date = currentDate.getDate();
            let month = months[currentDate.getMonth()];
            let year = currentDate.getFullYear();

            $('#date-id').text(`${day}, ${date} ${month} ${year}`);
        }

        function GetParameterValues(param) {
            var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < url.length; i++) {
                var urlparam = url[i].split('=');
                if (urlparam[0] == param) {
                    return urlparam[1];
                }
            }
        }

        function get_student_list() {
            debugger;
            $.ajax({
                url: "/api/presence/get-students/" + GetParameterValues('kelas'),
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        debugger;
                        let presenceTbl = document.querySelector("#presence-id");

                        presenceTbl.innerHTML = "";

                        let row = `<thead>
                    <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th width="40%">
                      Aksi
                    </th>
                  </tr></thead>`;
                        debugger;
                        let students_orig = response.data.students_orig;
                        let students_presence = response.data.students_presence;

                        for (let i = 0; i < students_orig.length; i++) {
                            let no = parseInt(i + 1);

                            let hdId = `hdId${i+1}`;
                            let spStudentPresence = `spStudentPresent${i+1}`;

                            let btnIdPresent = `btnPresent${i+1}`;
                            let btnIdPermit = `btnPermit${i+1}`;
                            let btnIdAbsent = `btnAbsent${i+1}`;


                            let stdId = students_orig[i].student_id;
                            let name = students_orig[i].fullname;

                            let presenceId = students_presence.length == 0 ? '0' :  queryStudentPresence('id', stdId, students_presence);
                            let filledBy = students_presence.length == 0 ? '' : queryStudentPresence('filled_by', stdId, students_presence);
                            let is_present = students_presence.length == 0 ? false : queryStudentPresence('is_present', stdId, students_presence);
                            let is_permit = students_presence.length == 0 ? false : queryStudentPresence('is_permit', stdId, students_presence);
                            let is_absent = students_presence.length == 0 ? false : queryStudentPresence('is_absent', stdId, students_presence);

                            let isTextShow = is_present || is_permit || is_absent ? '' : 'hide';
                            let isBtnHide = is_present || is_permit || is_absent ? 'hide' : '';
                            let remark = '';

                            if (isTextShow == '') {
                                if (is_present) {
                                    remark = "Hadir";
                                    isTextShow = "badge bg-success";
                                }
                                else if(is_permit) {
                                    remark = "Izin";
                                    isTextShow = "badge bg-info";
                                }
                                else if(is_absent) {
                                    remark = "Alfa";
                                    isTextShow = "badge bg-danger";
                                }
                            }

                            row += `<tr>
                            <td>` + no + `</td>
                            <td>` + name + `</td>
                            <td>
                                <input type="hidden" id='`+ hdId +`' value="`+ presenceId +`"></input>
                                <span class="`+ isTextShow +`" id='`+ spStudentPresence +`'>${remark}</span>
                                <button id='`+ btnIdPresent +`' class="btn btn-success btn-sm `+ isBtnHide +`" onclick="presenceStudent('`+ stdId +`', '`+ name +`', 'H', '`+ no +`')"> <i class="fa fa-check" aria-hidden="true"></i></button>
                                <button id='`+ btnIdPermit +`' class="btn btn-info btn-sm `+ isBtnHide +`" onclick="presenceStudent('`+ stdId +`', '`+ name +`', 'I', '`+ no +`')"> <i class="fa fa-hand-pointer-o" aria-hidden="true"></i></button>
                                <button id='`+ btnIdAbsent +`' class="btn btn-danger btn-sm `+ isBtnHide +`" onclick="presenceStudent('`+ stdId +`', '`+ name +`', 'A', '`+ no +`')"> <i class="fa fa-close" aria-hidden="true"></i></button>
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

        function queryStudentPresence(field, studentId, source) {
            let data = null;

            source.filter(function(val) {
                debugger;
                if (val.student_id == studentId) {
                    if (field == 'filled_by') {
                        data = val.filled_by;
                    } else if (field == 'is_present') {
                        data = val.is_present;
                    } else if (field == 'is_permit') {
                        data = val.is_permit;
                    } else if (field == 'is_absent') {
                        data = val.is_absent;
                    } else if (field == "id") {
                        data = val.id;
                    }
                }
            });

            return data;

        }

        function proceedClockInOut(type) {
            debugger;
            let id = $('#teacher-presence-id').val();
            let user = $('#username-id').val();
            let classLevel = GetParameterValues('kelas');

            let presence = {
                'id': id,
                'user_id': user,
                'class_level_id': classLevel
            };

            $.ajax({
                url: "/api/presence-teacher/post-clockinout",
                type: 'POST',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(presence),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    debugger;
                    if (response.status) {
                        if (type == 'in') {
                            $('#modal-clockin').modal('hide');
                            swal("Berhasil", `Presensi Masuk Berhasil`, "success");

                            $('#teacher-presence-id').val(response.data.id);
                            $('#clock-in').css('display', 'none');

                            if (response.data.clock_in_time != undefined || response.data.clock_in_time != null) {
                                let clockInTimeSplit = response.data.clock_in_time.split(':');

                                if (clockInTimeSplit.length > 0) {
                                    $('#text-in').text(`Presensi Masuk ${clockInTimeSplit[0]}:${clockInTimeSplit[1]}`);
                                    $('#text-in').css('display', 'block');
                                }
                            }
                        } else if (type == 'out') {
                            $('#modal-clockout').modal('hide');
                            swal("Berhasil", `Presensi Keluar Berhasil`, "success");

                            $('#teacher-presence-id').val(response.data.id);
                            $('#clock-out').css('display', 'none');

                            if (response.data.clock_out_time != undefined || response.data.clock_out_time != null) {
                                let clockOutTimeSplit = response.data.clock_out_time.split(':');

                                if (clockOutTimeSplit.length > 0) {
                                    $('#text-out').text(`Presensi Keluar ${clockOutTimeSplit[0]}:${clockOutTimeSplit[1]}`);
                                    $('#text-out').css('display', 'block');
                                }
                            }
                        }



                    }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });
        }

        function set_teacher_presence() {
            debugger;
            $.ajax({
                url: "/api/presence-teacher/get-teacher-presence",
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    debugger;
                    if (response.data != undefined || response.data != null) {
                            $('#teacher-presence-id').val(response.data.id);


                            if (response.data.clock_in_time != undefined || response.data.clock_in_time != null) {
                                let clockInTimeSplit = response.data.clock_in_time.split(':');

                                if (clockInTimeSplit.length > 0) {
                                    $('#clock-in').css('display', 'none');
                                    $('#text-in').text(`Presensi Masuk ${clockInTimeSplit[0]}:${clockInTimeSplit[1]}`);
                                    $('#text-in').css('display', 'block');
                                }
                            }

                            if (response.data.clock_out_time != undefined || response.data.clock_out_time != null) {
                                let clockOutTimeSplit = response.data.clock_out_time.split(':');

                                if (clockOutTimeSplit.length > 0) {
                                    $('#clock-out').css('display', 'none');
                                    $('#text-out').text(`Presensi Keluar ${clockOutTimeSplit[0]}:${clockOutTimeSplit[1]}`);
                                    $('#text-out').css('display', 'block');
                                }
                            }
                        }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });
        }

        function presenceStudent(studentId, studentName, code, index) {
            let id = $('#teacher-presence-id').val();

            if (parseInt(id) == 0) {
                swal("Info", `Guru belum melakukan presensi masuk`, "info");
                return;
            }

            if (code == 'H' || code == 'A') {
                let remark = code == 'H' ? 'Hadir' : 'Tidak Hadir';
                swal({
                    title: "Presensi Sekarang?",
                    text: `${studentName} Saat Ini ${remark}`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willPresence) => {
                    if (willPresence) {
                        proceedStudentPresence(studentId, code, null, index);
                    }
                });
            } else if (code == 'I') {
                swal(`Apakah ${studentName} Saat Ini Izin? Tuliskan Alasannya`, {
                    content: "input",
                    })
                    .then((note) => {
                        if (note == null || note == '') {
                            swal(`Mohon menuliskan alasan izin`);
                            return;
                        } else {
                            proceedStudentPresence(studentId, code, note, index);
                        }

                });
            } else {
                swal("Info", `Status kehadiran ${remark}`, "info");
                return;
            }
        }

        function proceedStudentPresence(studentId, code, note, index) {
            debugger;
            let presence = {
                'id': $(`#hdId${index}`).val(),
                'student_id':studentId,
                'is_present': code == 'H' ? true : false,
                'is_permit': code == 'I' ? true : false,
                'is_absent': code == 'A' ? true : false,
                'permit_desc': note,
                'filled_by': $('#username-id').val(),
                'class_level_id': GetParameterValues('kelas')
            };

            $.ajax({
                url: "/api/presence/post-student-presence",
                type: 'POST',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(presence),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    debugger;
                    if (response.status) {
                        $(`#hdId${index}`).val(response.data.id);

                        if (response.data.is_present) {
                            $(`#spStudentPresent${index}`).text('Hadir');
                            $(`#spStudentPresent${index}`).attr('class', '');
                            $(`#spStudentPresent${index}`).addClass('badge bg-success');
                        } else if (response.data.is_permit) {
                            $(`#spStudentPresent${index}`).text('Izin');
                            $(`#spStudentPresent${index}`).attr('class', '');
                            $(`#spStudentPresent${index}`).addClass('badge bg-info');
                        } else if (response.data.is_absent) {
                            $(`#spStudentPresent${index}`).text('Alfa');
                            $(`#spStudentPresent${index}`).attr('class', '');
                            $(`#spStudentPresent${index}`).addClass('badge bg-danger');
                        }


                        $(`#spStudentPresent${index}`).removeClass('hide');
                        $(`#btnPresent${index}`).addClass('hide');
                        $(`#btnPermit${index}`).addClass('hide');
                        $(`#btnAbsent${index}`).addClass('hide');
                    }
                },
                error: function(response) {
                    debugger;
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });
        }
    </script>
@endpush
