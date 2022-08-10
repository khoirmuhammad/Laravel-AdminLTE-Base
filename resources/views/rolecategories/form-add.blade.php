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
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="group"
                            value="{{ request()->session()->has('group')? session('group'): '' }}" />

                        <div class="form-group">
                            <label>Kode</label>
                            <input type="text" class="form-control" id="id" name="id" placeholder="Kode">
                        </div>

                        <div class="form-group">
                            <label>Nama Kategory</label>
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nama Kategori">
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
                                post_save_role_category();
                            }
                        });



                }
            });

            $('#role-category-form').validate({
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
                window.location='{{ url("kategori-role") }}'
            });

        });

        function post_save_role_category() {

            $(`#card-body-id`).addClass('opacity');
            $(`#submit-icon`).addClass('hide');
            $(`#loading-icon-submit`).removeClass('hide');
            $(`#submit-text`).text('Sedang Menyimpan...');

            let id = $('#id').val();
            let name = $('#name').val();

            let role = {
                id: id,
                name: name,
            };

            $.ajax({
                url: "/api/role-categories/post-save",
                type: 'POST',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(role),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {


                    swal("Berhasil", `Data Role Kategori : ${role.name} berhasil ditambahkan`, "success");

                    $(`#card-body-id`).removeClass('opacity');
                    $(`#submit-icon`).removeClass('hide');
                    $(`#loading-icon-submit`).addClass('hide');
                    $(`#submit-text`).text('Submit');

                    $("#role-category-form")[0].reset();
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
                        swal("Gagal", `${response.status} - ${response.statusText}`, "error");
                    }

                    $(`#card-body-id`).removeClass('opacity');
                    $(`#submit-icon`).removeClass('hide');
                    $(`#loading-icon-submit`).addClass('hide');
                    $(`#submit-text`).text('Submit');
                }
            });
        }
    </script>
@endpush
