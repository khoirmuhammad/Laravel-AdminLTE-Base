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
                        <input type="hidden" id="group"
                            value="{{ request()->session()->has('group')? session('group'): '' }}" />
                        <input type="hidden" id="id" />
                        <div class="form-group">
                            <label>Nama Lengkap</label>
                            <input type="text" class="form-control" id="fullname" name="fullname"
                                placeholder="Nama Lengkap">
                        </div>
                        <div class="form-group">
                            <label>Nama Pengguna (Username)</label>
                            <input type="text" class="form-control" id="username" name="username"
                                placeholder="Nama Pengguna" disabled>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-success d-inline">
                                <input type="checkbox" id="isChangePassword" name="isChangePassword">
                                <label for="isChangePassword">
                                    Ubah Kata Sandi (Password) ?
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Kata Sandi Lama</label>
                            <div class="input-group">
                                <input type="password" name="oldPassword" id="oldPassword" class="form-control"
                                    data-toggle="password" placeholder="Kata Sandi Lama" disabled>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash" id="toggleOldPassword"></i>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="form-group">
                            <label>Kata Sandi Baru</label>
                            <div class="input-group">
                                <input type="password" name="newPassword" id="newPassword" class="form-control"
                                    data-toggle="password" placeholder="Kata Sandi Baru" disabled>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash" id="toggleNewPassword"></i>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Konfirmasi Kata Sandi Baru</label>
                            <div class="input-group">
                                <input type="password" name="confirmNewPassword" id="confirmNewPassword" class="form-control"
                                    data-toggle="password" placeholder="Konfirmasi Kata Sandi Baru" disabled>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="bi bi-eye-slash" id="toggleConfirmNewPassword"></i>
                                    </span>
                                </div>
                            </div>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css" />
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
            const oldPassword = document.querySelector("#oldPassword");
            const newPassword = document.querySelector("#newPassword");
            const confirmNewPassword = document.querySelector("#confirmNewPassword");

            set_form();

            $('#toggleOldPassword').on('click', function() {
                let type = oldPassword.getAttribute("type") === "password" ? "text" : "password";
                oldPassword.setAttribute("type", type);

                this.classList.toggle("bi-eye");
            });

            $('#toggleNewPassword').on('click', function() {
                let type = newPassword.getAttribute("type") === "password" ? "text" : "password";
                newPassword.setAttribute("type", type);

                this.classList.toggle("bi-eye");
            });

            $('#toggleConfirmNewPassword').on('click', function() {
                let type = confirmNewPassword.getAttribute("type") === "password" ? "text" : "password";
                confirmNewPassword.setAttribute("type", type);

                this.classList.toggle("bi-eye");
            });

            $('#isChangePassword').on('change', function() {
                if (this.checked) {
                    $('#oldPassword').prop('disabled', false);
                    $('#newPassword').prop('disabled', false);
                    $('#confirmNewPassword').prop('disabled', false);
                } else {
                    $('#oldPassword').prop('disabled', true);
                    $('#newPassword').prop('disabled', true);
                    $('#confirmNewPassword').prop('disabled', true);

                    $('#oldPassword').removeClass('is-invalid');
                    $('#oldPassword-error').css('display','none');
                    $('#newPassword').removeClass('is-invalid');
                    $('#newPassword-error').css('display','none');
                    $('#confirmNewPassword').removeClass('is-invalid');
                    $('#confirmNewPassword-error').css('display','none');
                }
            })

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
                    fullname: {
                        required: true
                    },
                    username: {
                        required: true
                    },
                    oldPassword: {
                        required: {
                            depends: function () {
                                debugger;
                                let isChangePassword = $('#isChangePassword').is(':checked');
                                return isChangePassword;
                            }
                        }
                    },
                    newPassword: {
                        required: {
                            depends: function () {
                                debugger;
                                let isChangePassword = $('#isChangePassword').is(':checked');
                                return isChangePassword;
                            }
                        }
                    },
                    confirmNewPassword: {
                        required: {
                            depends: function () {
                                debugger;
                                let isChangePassword = $('#isChangePassword').is(':checked');
                                return isChangePassword;
                            }
                        }
                    }
                },
                messages: {
                    fullname: {
                        required: "Nama Lengkap Kelas harus diisi"
                    },
                    username: {
                        required: "Nama Pengguna harus diisi"
                    },
                    oldPassword: {
                        required: "Password Lama harus diisi"
                    },
                    newPassword: {
                        required: "Password Baru harus diisi"
                    },
                    confirmNewPassword: {
                        required: "Konfirmasi Password Baru harus diisi"
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

        async function post_save_user() {
            debugger;
            $(`#card-body-id`).addClass('opacity');
            $(`#submit-icon`).addClass('hide');
            $(`#loading-icon-submit`).removeClass('hide');
            $(`#submit-text`).text('Sedang Menyimpan...');

            let user = null;

            let id = $('#id').val();
            let fullname = $('#fullname').val();
            let username = $('#username').val();
            let email = $('#email').val();
            let oldPassword = $('#oldPassword').val();
            let password = $('#newPassword').val();
            let isPasswordChanged = $('#isChangePassword').is(':checked');

            if (!isPasswordChanged) {
                user = {
                    id: id,
                    fullname: fullname,
                    email: email,
                    password: password,
                    password_change: isPasswordChanged
                };

                proceedModify(user);
                return;
            }

            //123
            if (password != $('#confirmNewPassword').val())
            {
                swal("Peringatan", "Konfirmasi Kata Sandi Baru Tidak Sama", "info");
                SetBackSubmitBehaviour();
                return;
            }

            await fetch('/api/user/get-check-old-password/' + oldPassword)
            .then((response) => {
                if (response.status >= 200 && response.status <= 299) {
                    return response.json();
                } else {
                    swal("Peringatan", response.statusText, "info");
                    SetBackSubmitBehaviour();
                    return;
                }
            })
            .then((jsonResponse) => {
                if (!jsonResponse.data) {
                    swal("Peringatan", "Kata Sandi Lama Tidak Sesuai", "info");
                    SetBackSubmitBehaviour();
                    return;
                } else {
                    user = {
                        id: id,
                        fullname: fullname,
                        email: email,
                        password: password,
                        password_change: isPasswordChanged
                    };

                    proceedModify(user);
                }

            }).catch((error) => {
                // Handle the error
                swal("Peringatan", error, "info");
                SetBackSubmitBehaviour();
                return;
            });


        }

        function proceedModify(user) {
            $.ajax({
                url: "/api/user/update-menu",
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

                    swal("Berhasil", `Data Pengguna : ${user.fullname} berhasil diperbarui`, "success");

                    SetBackSubmitBehaviour();

                    set_form();
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

                    SetBackSubmitBehaviour();
                }
            });
        }

        function set_form() {
            $.ajax({
                url: `/api/user/get-user-by-username`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    debugger;
                    if (response.data != undefined || response.data != null) {
                        let obj = response.data;

                        $('#id').val(obj.id);
                        $('#fullname').val(obj.name);
                        $('#username').val(obj.username);
                        $('#email').val(obj.email);

                        resetPassword();

                    }
                },
                error: function(response) {

                }
            });
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

        function SetBackSubmitBehaviour() {
            $(`#card-body-id`).removeClass('opacity');
            $(`#submit-icon`).removeClass('hide');
            $(`#loading-icon-submit`).addClass('hide');
            $(`#submit-text`).text('Submit');
        }

        function resetPassword() {
            $('#isChangePassword').prop('checked', false);

            $('#oldPassword').val('');
            $('#newPassword').val('');
            $('#confirmNewPassword').val('');

            $('#oldPassword').prop('disabled', true);
            $('#newPassword').prop('disabled', true);
            $('#confirmNewPassword').prop('disabled', true);
        }

    </script>
@endpush
