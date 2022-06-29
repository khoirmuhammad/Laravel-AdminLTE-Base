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
            <form id="role-form">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="group"
                            value="{{ request()->session()->has('group')? session('group'): '' }}" />

                        <div class="form-group clearfix d-inline">
                            <label>Berperan di</label>
                            <div class="icheck-success">
                                <input type="radio" name="role-type" id="daerah" value="Daerah">
                                <label for="daerah">
                                    Daerah
                                </label>
                            </div>
                            <div class="icheck-danger">
                                <input type="radio" name="role-type" id="desa" value="Desa">
                                <label for="desa">
                                    Desa
                                </label>
                            </div>
                            <div class="icheck-primary">
                                <input type="radio" name="role-type" id="kelompok" value="Kelompok">
                                <label for="kelompok">
                                    Kelompok
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Desa</label>
                            <select id="village" name="village" class="form-control" style="width: 100%;">
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kelompok</label>
                            <select id="village_group" name="village_group" class="form-control" style="width: 100%;">
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Kategori</label>
                            <select id="category" name="category" class="form-control" style="width: 100%;">
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="Kode">
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

            $('#daerah').prop('checked', true);
            $('#village').prop('disabled', true);
            $('#village_group').prop('disabled', true);

            get_role_category();

            $('#daerah').on('click', function() {
                if (this.checked) {
                    $('#village').prop('disabled', true);
                    $('#village_group').prop('disabled', true);

                    $('#village').val('');
                    $('#village_group').val('');
                }
            })

            $('#desa').on('click', function() {
                if (this.checked) {
                    $('#village').prop('disabled', false);
                    $('#village_group').prop('disabled', true);

                    $('#village_group').val('');

                    get_village();
                }
            })

            $('#kelompok').on('click', function() {
                if (this.checked) {
                    $('#village').prop('disabled', false);
                    $('#village_group').prop('disabled', false);

                    get_village();
                }
            })

            $('#village').on('change', function() {
                if ($('#kelompok').is(':checked')) {
                    get_group();
                }

            })

            $('#category').on('change', function() {

                if ($('#desa').is(':checked')) {
                    let village = $("#village option:selected").text();

                    if (village != '' || village != null) {
                        village = village.trim().toLowerCase();
                    }

                    $('#id').val(`${$('#category').val().toLowerCase()}.${village}`)
                } else if ($('#kelompok').is(':checked')) {
                    let group = $("#village_group option:selected").text();

                    if (group != '' || group != null) {
                        group = group.trim().toLowerCase();
                    }

                    $('#id').val(`${$('#category').val().toLowerCase()}.${group}`)
                } else {
                    $('#id').val('')
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
                                post_save_role();
                            }
                        });



                }
            });

            $('#role-form').validate({
                ignore: [],
                rules: {
                    id: {
                        required: true
                    },
                    name: {
                        required: true
                    }
                },
                messages: {
                    id: {
                        required: "Kode harus diisi"
                    },
                    name: {
                        required: "Nama Kategori harus dipilih"
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

        function post_save_role(action) {
            debugger;
            $(`#card-body-id`).addClass('opacity');
            $(`#submit-icon`).addClass('hide');
            $(`#loading-icon-submit`).removeClass('hide');
            $(`#submit-text`).text('Sedang Menyimpan...');

            let id = $('#id').val();
            let category = $('#category').val();
            let village = $('#desa').is(':checked') || $('#kelompok').is(':checked') ? $('#village').val() : null;
            let group = $('#kelompok').is(':checked') ? $('#village_group').val() : null;
            debugger;
            let role = {
                id: id,
                category: category,
                village: village,
                group: group
            };


            $.ajax({
                url: "/api/role/post-save",
                type: 'POST',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(role),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    debugger

                    swal("Berhasil", `Data Role : ${role.id} berhasil ditambahkan`, "success");

                    $(`#card-body-id`).removeClass('opacity');
                    $(`#submit-icon`).removeClass('hide');
                    $(`#loading-icon-submit`).addClass('hide');
                    $(`#submit-text`).text('Submit');

                    $("#role-form")[0].reset();
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
                        swal("Gagal", response.status + "-" + response.statusText, "error");
                    }


                    $(`#card-body-id`).removeClass('opacity');
                    $(`#submit-icon`).removeClass('hide');
                    $(`#loading-icon-submit`).addClass('hide');
                    $(`#submit-text`).text('Submit');
                }
            });
        }

        function get_role_category() {
            debugger
            $.ajax({
                url: `/api/role-categories`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#category').empty().trigger("change");
                        $('#category').append(`<option value="">Pilih</option>`);
                        for (let i = 0; i < response.data.length; i++) {
                            $('#category').append(`<option value="${response.data[i].id}">
                                       ${response.data[i].name}
                                  </option>`);
                        }
                    }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });
        }

        function get_village() {
            debugger
            $.ajax({
                url: `/api/villages`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#village').empty().trigger("change");
                        $('#village').append(`<option value="">Pilih</option>`);
                        for (let i = 0; i < response.data.length; i++) {
                            $('#village').append(`<option value="${response.data[i].id}">
                                       ${response.data[i].name}
                                  </option>`);
                        }
                    }
                },
                error: function(response) {
                    swal("Gagal", response.status + "-" + response.statusText, "error");
                }
            });
        }

        function get_group() {
            debugger
            let village = $('#village').val();

            if (village == null || village == '') {
                return;
            }

            $.ajax({
                url: `/api/group/group-list-by-village/${village}`,
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.data != undefined || response.data != null) {
                        $('#village_group').empty().trigger("change");
                        $('#village_group').append(`<option value="">Pilih</option>`);
                        for (let i = 0; i < response.data.length; i++) {
                            $('#village_group').append(`<option value="${response.data[i].id}">
                                       ${response.data[i].name}
                                  </option>`);
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
