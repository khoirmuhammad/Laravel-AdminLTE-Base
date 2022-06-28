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
            <form id="user-form">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="group" value="{{ request()->session()->has('group')? session('group'): '' }}" />
                        <input type="hidden" id="village" value="{{ request()->session()->has('village')? session('village'): '' }}" />
                        <input type="hidden" id="role-type" value="{{ request()->session()->has('role_type')? session('role_type'): '' }}" />
                        <input type="hidden" id="role" value="{{ request()->session()->has('role')? session('role'): '' }}" />

                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Lengkap">
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="cbDaerah">
                                <label for="cbDaerah">
                                    Daerah
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="checkbox" id="cbDesa">
                                <label for="cbDesa">
                                    Desa
                                </label>
                            </div>
                            <div class="icheck-danger d-inline">
                                <input type="checkbox" id="cbKelompok">
                                <label for="cbKelompok">
                                    Kelompok
                                </label>
                            </div>
                        </div>




                    </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                        <hr>

                        <div class="form-group clearfix" id="cbRoleDaerah">

                        </div>

                        <hr>

                        <div class="form-group clearfix" id="cbRoleDesa">

                        </div>

                        <hr>

                        <div class="form-group clearfix" id="cbRoleKelompok">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="btn-group" role="group" aria-label="Button">
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
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

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

            check_role();

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
                                post_save_user();
                            }
                        });



                }
            });

            $('#user-form').validate({
                ignore: [],
                rules: {
                    name: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Nama Lengkap harus diisi"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    debugger;
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    debugger;
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

        });

        function check_role() {
            debugger;
            let role = $('#role').val();
            let roleType = $('#role-type').val();
            let village = $('#village').val();
            let group = $('#group').val();

            if (roleType == 'ppg' && role.includes('superadmin')) {
                $('#cbDaerah').prop('checked',true);
                $('#cbDaerah').prop('disabled',true);
                get_role_daerah();

                $('#cbDesa').prop('checked',true);
                $('#cbDesa').prop('disabled',true);
                get_all_role_desa();

                $('#cbKelompok').prop('checked',true);
                $('#cbKelompok').prop('disabled',true);
                get_all_role_kelompok();
            } else if (roleType == 'ppd' && role.includes('admin')) {
                $('#cbDaerah').prop('disabled',true);

                $('#cbDesa').prop('checked',true);
                $('#cbDesa').prop('disabled',true);
                get_role_desa();

                $('#cbKelompok').prop('disabled',true);
            } else if (roleType == 'ppk' && role.includes('admin')) {
                $('#cbDaerah').prop('disabled',true);

                $('#cbDesa').prop('disabled',true);

                $('#cbKelompok').prop('checked',true);
                $('#cbKelompok').prop('disabled',true);
                get_role_kelompok();
            }
        }

        function post_save_user() {
            debugger;
            $(`#card-body-id`).addClass('opacity');
            $(`#submit-icon`).addClass('hide');
            $(`#loading-icon-submit`).removeClass('hide');
            $(`#submit-text`).text('Sedang Menyimpan...');

            let name = $('#name').val();
            let email = $('#email').val();
            let roles = [];

            let daerah = $('#cbDaerah').is(':checked');
            let desa = $('#cbDesa').is(':checked');
            let kelompok = $('#cbKelompok').is(':checked');

            if (daerah) {
                $("input:checkbox[name=role_daerah]:checked").each(function(){
                    roles.push($(this).val());
                });
            }

            if (desa) {
                $("input:checkbox[name=role_desa]:checked").each(function(){
                    roles.push($(this).val());
                });
            }

            if (kelompok) {
                $("input:checkbox[name=role_kelompok]:checked").each(function(){
                    roles.push($(this).val());
                });
            }

            debugger;
            let user = {
                name: name,
                email: email,
                roles: roles
            };


            $.ajax({
                url: "/api/user/insert-user",
                type: 'POST',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(user),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    debugger

                    swal("Berhasil", `Data Pengguna : ${user.name} berhasil ditambahkan`, "success");

                    $(`#card-body-id`).removeClass('opacity');
                    $(`#submit-icon`).removeClass('hide');
                    $(`#loading-icon-submit`).addClass('hide');
                    $(`#submit-text`).text('Submit');

                    $("#role-form")[0].reset();
                },
                error: function(response) {
                    debugger
                    let error_message = response.responseJSON.error_message == undefined ? response.responseJSON
                        .message : response.responseJSON.error_message;
                    let logKey = response.responseJSON.log_key;

                    let alert_message;

                    if (logKey == undefined)
                        alert_message = error_message;
                    else
                        alert_message =
                        `${error_message}. Copy dan beritaukan kode log berikut ke admin = ${logKey}`;

                    swal("Gagal", alert_message, "error");

                    $(`#card-body-id`).removeClass('opacity');
                    $(`#submit-icon`).removeClass('hide');
                    $(`#loading-icon-submit`).addClass('hide');
                    $(`#submit-text`).text('Submit');
                }
            });
        }

        function get_role_daerah() {
            debugger
            $.ajax({
                url: `/api/role/role-daerah`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#cbRoleDaerah').empty().trigger("change");
                        $('#cbRoleDaerah').append('<label>Pilih Role</label><br>');
                        for (let i = 0; i < response.data.length; i++) {
                            debugger
                            $("#cbRoleDaerah").append(`<div class="icheck-primary d-inline">
                                <input type="checkbox" id="${response.data[i].id.replaceAll('.','')}" name="role_daerah" value="${response.data[i].id}">
                                <label for="${response.data[i].id.replaceAll('.','')}">
                                    ${response.data[i].id}
                                </label>
                            </div>`);
                        }
                    }
                },
                error: function(response) {

                }
            });
        }

        function get_all_role_desa() {
            debugger
            $.ajax({
                url: `/api/role/role-desa`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#cbRoleDesa').empty().trigger("change");
                        $('#cbRoleDesa').append('<label>Pilih Role</label><br>');
                        for (let i = 0; i < response.data.length; i++) {
                            debugger
                            $("#cbRoleDesa").append(`<div class="icheck-success d-inline">
                                <input type="checkbox" id="${response.data[i].id.replaceAll('.','')}" name="role_desa" value="${response.data[i].id}">
                                <label for="${response.data[i].id.replaceAll('.','')}">
                                    ${response.data[i].id}
                                </label>
                            </div>`);
                        }
                    }
                },
                error: function(response) {

                }
            });
        }

        function get_role_desa() {
            debugger
            $.ajax({
                url: `/api/role/role-desa/${$('#village').val()}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#cbRoleDesa').empty().trigger("change");
                        $('#cbRoleDesa').append('<label>Pilih Role</label><br>');
                        for (let i = 0; i < response.data.length; i++) {
                            debugger
                            $("#cbRoleDesa").append(`<div class="icheck-success d-inline">
                                <input type="checkbox" id="${response.data[i].id.replaceAll('.','')}" name="role_desa" value="${response.data[i].id}">
                                <label for="${response.data[i].id.replaceAll('.','')}">
                                    ${response.data[i].id}
                                </label>
                            </div>`);
                        }
                    }
                },
                error: function(response) {

                }
            });
        }

        function get_all_role_kelompok() {
            debugger
            $.ajax({
                url: `/api/role/role-kelompok`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#cbRoleKelompok').empty().trigger("change");
                        $('#cbRoleKelompok').append('<label>Pilih Role</label><br>');
                        for (let i = 0; i < response.data.length; i++) {
                            debugger
                            $("#cbRoleKelompok").append(`<div class="icheck-danger d-inline">
                                <input type="checkbox" id="${response.data[i].id.replaceAll('.','')}" name="role_kelompok" value="${response.data[i].id}">
                                <label for="${response.data[i].id.replaceAll('.','')}">
                                    ${response.data[i].id}
                                </label>
                            </div>`);
                        }
                    }
                },
                error: function(response) {

                }
            });
        }

        function get_role_kelompok() {
            debugger
            $.ajax({
                url: `/api/role/role-kelompok/${$('#group').val()}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#cbRoleKelompok').empty().trigger("change");
                        $('#cbRoleKelompok').append('<label>Pilih Role</label><br>');
                        for (let i = 0; i < response.data.length; i++) {
                            debugger
                            $("#cbRoleKelompok").append(`<div class="icheck-danger d-inline">
                                <input type="checkbox" id="${response.data[i].id.replaceAll('.','')}" name="role_kelompok" value="${response.data[i].id}">
                                <label for="${response.data[i].id.replaceAll('.','')}">
                                    ${response.data[i].id}
                                </label>
                            </div>`);
                        }
                    }
                },
                error: function(response) {

                }
            });
        }
    </script>
@endpush
