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
            <form id="teacher-form">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="group"
                            value="{{ request()->session()->has('group')? session('group'): '' }}" />

                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Penanggung Jawab Kelas">
                        </div>

                        <div class="form-group clearfix">
                            <label>Jenis Kelamin</label>
                            <div class="icheck-success">
                                <input type="radio" name="gender" id="gender-male" value="Laki-laki">
                                <label for="gender-male">
                                    Laki-laki
                                </label>
                            </div>
                            <div class="icheck-danger">
                                <input type="radio" name="gender" id="gender-female" value="Perempuan">
                                <label for="gender-female">
                                    Perempuan
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select id="status" name="status" class="form-control" style="width: 100%;">
                                <option value="">Pilih</option>
                                <option value="MT">MT</option>
                                <option value="MS">MS</option>
                                <option value="Asisten">Asisten</option>
                            </select>
                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="isTeacher" name="isTeacher">
                                <label for="isTeacher">
                                    Apakah Pengajar ?
                                </label>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-success d-inline">
                                <input type="checkbox" id="isAdminClass" name="isAdminClass">
                                <label for="isAdminClass">
                                    Apakah Admin Kelas ?
                                </label>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-danger d-inline">
                                <input type="checkbox" id="isStudent" name="isStudent">
                                <label for="isStudent">
                                    Apakah Seorang Generus ?
                                </label>
                            </div>
                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-warning d-inline">
                                <input type="checkbox" id="hasAccount" name="hasAccount">
                                <label for="hasAccount">
                                    Apakah Sudah Punya Akun ?
                                </label>
                            </div>
                            <input type="text" class="form-control mt-2 hide" id="username" name="username"
                                placeholder="Masukkan Akun Pengguna">
                        </div>



                    </div>

                    <div class="col-md-6">



                        <div class="form-group clearfix" id="cb-class-level">

                        </div>

                        <input type="checkbox" id="is-active" name="my-checkbox" checked data-bootstrap-switch>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group" role="group" aria-label="Button">
                            <button type="button" id="btn-back" class="btn btn-secondary">
                                <i id="back-icon" class="fa fa-arrow-left" aria-hidden="true"></i>
                                <span>Kembali</span>
                            </button>
                            <button type="submit" id="btn-submit" class="btn btn-success">
                                <i id="submit-icon" class="fa fa-paper-plane" aria-hidden="true"></i>
                                <i id="loading-icon-submit" class="fa fa-spinner fa-spin hide"></i>
                                <span id="submit-text">Submit</span>
                            </button>
                        </div>
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

    <!-- Bootstrap Switch -->
    <script src="/adminlte/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>

    <script src="/otherjs/sweetalert.js"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            $('#is-active').bootstrapSwitch('state', false);

            get_class_levels();

            $("#hasAccount").change(function() {

                if (this.checked) {
                    $('#username').css('display', 'block');
                    $('#username-error').css('display', 'block');
                } else {
                    $('#username').css('display', 'none');
                    $('#username-error').css('display', 'none');
                }
            });

            $.validator.setDefaults({
                submitHandler: function() {
                    swal({
                            title: "Simpan Data",
                            text: "Pastikan data yang diisi sesuai",
                            icon: "warning",
                            buttons: true,
                            dangerMode: true,
                        })
                        .then((willSave) => {
                            if (willSave) {
                                post_save_teacher('submit');
                            }
                        });



                }
            });

            $('#teacher-form').validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    },
                    gender: {
                        required: true
                    },
                    status: {
                        required: true
                    },
                    class_level: {
                        required: true
                    },
                    username: {
                        required: {
                            depends: function() {

                                let hasAccountYet = $('#hasAccount').is(':checked');
                                return hasAccountYet;
                            }
                        }
                    }
                },
                messages: {
                    name: {
                        required: "Nama lengkap harus diisi"
                    },
                    gender: {
                        required: "Jenis kelamin harus dipilih"
                    },
                    status: {
                        required: "Status pengajar harus dipilih"
                    },
                    class_level: {
                        required: "Kelas harus dipilih"
                    },
                    username: {
                        required: "Akun Pengguna harus diisi"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {

                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {

                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            $('#btn-back').on('click', function() {
                window.location='{{ url("pj-kelas") }}'
            });

        });

        function post_save_teacher(action) {

            $(`#card-body-id`).addClass('opacity');
            $(`#${action}-icon`).addClass('hide');
            $(`#loading-icon-${action}`).removeClass('hide');
            $(`#${action}-text`).text('Sedang Menyimpan...');

            let name = $('#name').val();
            let gender = $("input[name='gender']:checked").val();
            let status = $('#status').val();
            let isTeacher = $('#isTeacher').is(':checked');
            let isAdminClass = $('#isAdminClass').is(':checked');
            let isStudent = $('#isStudent').is(':checked');
            let hasAccount = $('#hasAccount').is(':checked');
            let username = $('#username').val();
            let isActive = $('#is-active').is(':checked');
            let classString = null;

            let classes = [];
            $.each($("input[name='class_level']:checked"), function() {

                classes.push($(this).val());
            });

            if (classes.length > 0) {
                classString = classes.join();
            }

            let teacher = {
                name: name,
                gender: gender,
                status: status,
                isTeacher: isTeacher,
                isAdminClass: isAdminClass,
                isStudent: isStudent,
                hasAccount: hasAccount,
                username: username,
                isActive: isActive,
                classString: classString
            };

            $.ajax({
                url: "/api/teacher/post-save-teacher",
                type: 'POST',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(teacher),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {


                    swal("Berhasil", `Data Guru : ${teacher.name} berhasil ditambahkan`, "success");

                    $(`#card-body-id`).removeClass('opacity');
                    $(`#${action}-icon`).removeClass('hide');
                    $(`#loading-icon-${action}`).addClass('hide');
                    $(`#${action}-text`).text(action == 'save' ? 'Simpan' : 'Submit');

                    $("#teacher-form")[0].reset();
                },
                error: function(response) {

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
                        swal("Gagal", response.status + "-" + response.statusText, "error");
                    }

                    $(`#card-body-id`).removeClass('opacity');
                    $(`#${action}-icon`).removeClass('hide');
                    $(`#loading-icon-${action}`).addClass('hide');
                    $(`#${action}-text`).text(action == 'save' ? 'Simpan' : 'Submit');
                }
            });
        }

        function get_class_levels() {

            let color = ['primary', 'secondary', 'success', 'warning', 'info', 'danger']
            $.ajax({
                url: `/api/class-level/class-level-list-exist-in-group`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#cb-class-level').empty().trigger("change");
                        $('#cb-class-level').append('<label>Pilih Kelas</label>');
                        for (let i = 0; i < response.data.length; i++) {
                            $("#cb-class-level").append(`<div class="icheck-${i < color.length ? color[i] : color[i-color.length]}">
                    <input type="checkbox" id="class_level_${response.data[i].id}" name="class_level" value="${response.data[i].id}">
                    <label for="class_level_${response.data[i].id}">
                        Kelas ${response.data[i].name}
                    </label>
                </div>`);
                        }
                    }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });
        }
    </script>
@endpush
