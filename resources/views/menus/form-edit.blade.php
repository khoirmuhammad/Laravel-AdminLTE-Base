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
            <form id="menu-form">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="group"
                            value="{{ request()->session()->has('group')? session('group'): '' }}" />
                        <input type="hidden" id="id" />
                        <div class="form-group">
                            <label>Judul</label>
                            <input type="text" class="form-control" id="title" name="title"
                                placeholder="Judul Menu">
                        </div>

                        <div class="form-group">
                            <label>Urutan</label>
                            <input type="number" class="form-control" id="order" name="order"
                                placeholder="Urutan Menu">
                        </div>

                        <div class="form-group clearfix">
                            <div class="icheck-primary d-inline">
                                <input type="checkbox" id="isParent" name="isParent">
                                <label for="isParent">
                                    Atur Sebagai Menu Induk
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Menu Induk</label>
                            <select id="parent" name="parent" class="form-control" style="width: 100%;">
                            </select>
                        </div>

                        <div class="form-group">
                            <label>URL</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="URL Menu">
                        </div>

                        <div class="form-group">
                            <label>Icon Menu</label>
                            <input type="text" class="form-control" id="icon" name="icon"
                                placeholder="Icon Menu">
                        </div>


                    </div>

                    <div class="col-md-6">

                        <div class="form-group clearfix" id="cb-role-categories">

                        </div>

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

    <script src="/otherjs/sweetalert.js"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
            $('#icon').val('far fa-circle nav-icon');
            $('#icon').prop("disabled", true);

            get_role_categories();
            get_parent_menu();
            set_form();

            $('#isParent').on('change', function() {
                if (this.checked) {
                    $('#url').val('#');
                    $('#url').prop("disabled", true);

                    $('#icon').val('');
                    $('#icon').prop("disabled", false);

                    $('#parent').val("");
                    $('#parent').prop("disabled", true);
                } else {
                    $('#url').val('');
                    $('#url').prop("disabled", false);

                    $('#icon').val('far fa-circle nav-icon');
                    $('#icon').prop("disabled", true);

                    $('#parent').val("");
                    $('#parent').prop("disabled", false);
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
                                post_save_menu();
                            }
                        });

                }
            });

            $('#menu-form').validate({
                ignore: [],
                rules: {
                    title: {
                        required: true
                    },
                    order: {
                        required: true
                    },
                    parent: {
                        required: {
                            depends: function() {
                                debugger;
                                let isParent = $('#isParent').is(':checked'); // false
                                let parentMenu = $('#parent').val(); // ""
                                let parentMenuNotSelected = parentMenu == '';
                                return !isParent && parentMenuNotSelected;
                            }
                        }
                    },
                    url: {
                        required: true
                    },
                    icon: {
                        required: {
                            depends: function() {
                                let isParent = $('#isParent').is(':checked');
                                return isParent;
                            }
                        }
                    },
                    role_cat: {
                        required: true
                    }
                },
                messages: {
                    title: {
                        required: "Judul harus diisi"
                    },
                    order: {
                        required: "Urutan harus diisi"
                    },
                    parent: {
                        required: "Menu Induk harus dipilih"
                    },
                    url: {
                        required: "URL harud diisi"
                    },
                    icon: {
                        required: "Icon harus diisi"
                    },
                    role_cat: {
                        required: "Role / Peran harus dipilih salah satu"
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

            $('#btn-back').on('click', function() {
                window.location='{{ url("menu") }}'
            });

        });

        function get_role_categories() {
            debugger
            let color = ['primary', 'secondary', 'success', 'warning', 'info', 'danger']
            $.ajax({
                url: `/api/role-categories`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#cb-role-categories').empty().trigger("change");
                        $('#cb-role-categories').append('<label>Pilih Role / Peran</label>');
                        for (let i = 0; i < response.data.length; i++) {
                            let role = response.data[i].id.replace('.', '');

                            $("#cb-role-categories").append(`<div class="icheck-${i < color.length ? color[i] : color[i-color.length]}">
                    <input type="checkbox" id="role_cat_${role}" name="role_cat" value="${response.data[i].id}">
                    <label for="role_cat_${role}">
                        ${response.data[i].name}
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

        function get_parent_menu() {
            debugger
            $.ajax({
                url: `/api/menu/get-parent-menu`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#parent').empty().trigger("change");
                        $('#parent').append(`<option value="">Pilih</option>`);
                        for (let i = 0; i < response.data.length; i++) {
                            $('#parent').append(`<option value="${response.data[i].id}">
                                       ${response.data[i].title}
                                  </option>`);
                        }
                    }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });
        }

        function post_save_menu() {
            debugger;
            $(`#card-body-id`).addClass('opacity');
            $(`#submit-icon`).addClass('hide');
            $(`#loading-icon-submit`).removeClass('hide');
            $(`#submit-text`).text('Sedang Menyimpan...');

            let id = $('#id').val();
            let title = $('#title').val();
            let order = $('#order').val();
            let isParent = $('#isParent').is(':checked');
            let parent = isParent ? null : $('#parent').val();
            let url = isParent ? '#' : $('#url').val();
            let icon = !isParent ? 'far fa-circle nav-icon' : $('#icon').val();
            let roleString = null;

            let roles = [];
            $.each($("input[name='role_cat']:checked"), function() {
                roles.push($(this).val());
            });

            if (roles.length > 0) {
                roleString = roles.join();
            }

            let menuRoles = {
                'id': id,
                'title': title,
                'order': order,
                'route': url,
                'parent_id': parent,
                'icon': icon,
                'roles': roleString
            };

            $.ajax({
                url: "/api/menu/save-menu",
                type: 'POST',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(menuRoles),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    debugger;
                    swal("Berhasil", `Menu ${menuRoles.title} berhasil diperbarui`, "success");

                    $(`#card-body-id`).removeClass('opacity');
                    $(`#submit-icon`).removeClass('hide');
                    $(`#loading-icon-submit`).addClass('hide');
                    $(`#submit-text`).text('Submit');

                    set_form();
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
                    $(`#submit-icon`).removeClass('hide');
                    $(`#loading-icon-submit`).addClass('hide');
                    $(`#submit-text`).text('Submit');
                }
            });

        }

        function set_form() {
            $.ajax({
                url: `/api/menu/get-menu-roles/${GetParameterValues('id')}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    debugger;
                    if (response.data != undefined || response.data != null) {
                        let objMenu = response.data.menu;
                        let objRoles = response.data.roles;

                        $('#id').val(objMenu.id);
                        $('#title').val(objMenu.title);
                        $('#order').val(objMenu.order);

                        if (objMenu.parent_id == null) {
                            $('#isParent').prop('checked', true);
                            $('#parent').prop('disabled', true);
                            $('#url').prop('disabled', true);
                            $('#icon').prop('disabled', false);
                        } else {
                            $('#parent').val(objMenu.parent_id);
                        }

                        $('#url').val(objMenu.route);
                        $('#icon').val(objMenu.icon);

                        $.each(objRoles, function(index, value) {
                            debugger
                            $(`#role_cat_${value.role_category_id.replace('.','')}`).prop('checked',
                                true);
                        });

                    }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
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
    </script>
@endpush
