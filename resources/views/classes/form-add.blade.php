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
            <form id="classlevel-form">
                <div class="row">
                    <div class="col-md-6">
                        <input type="hidden" id="group"
                            value="{{ request()->session()->has('group')? session('group'): '' }}" />

                        <div class="form-group">
                            <label>Nama Kelas</label>
                            <input type="text" class="form-control" id="classname" name="classname"
                                placeholder="Nama Kelas">
                        </div>
                        <div class="form-group">
                            <label>Jenjang</label>
                            <select id="level" name="level" class="form-control" style="width: 100%;">
                                <option value="">Pilih</option>
                                <option value="28fff9be-d75c-11ec-b5a0-5ce0c508bbb3">CABERAWIT</option>
                                <option value="28ffe5ed-d75c-11ec-b5a0-5ce0c508bbb3">PRAREMAJA</option>
                                <option value="3110ea5d-d75c-11ec-b5a0-5ce0c508bbb3">REMAJA</option>
                                <option value="3110c8d4-d75c-11ec-b5a0-5ce0c508bbb3">USIA NIKAH</option>
                            </select>
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
                                post_save_class();
                            }
                        });



                }
            });

            $('#classlevel-form').validate({
                ignore: [],
                rules: {
                    classname: {
                        required: true
                    },
                    level: {
                        required: true
                    }
                },
                messages: {
                    classname: {
                        required: "Nama Kelas harus diisi"
                    },
                    level: {
                        required: "Jenjang harus dipilih"
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
                window.location='{{ url("kelas") }}'
            });

        });

        function post_save_class() {

            $(`#card-body-id`).addClass('opacity');
            $(`#submit-icon`).addClass('hide');
            $(`#loading-icon-submit`).removeClass('hide');
            $(`#submit-text`).text('Sedang Menyimpan...');

            let classname = $('#classname').val();
            let level = $('#level').val();

            let classes = {
                classname: classname,
                level: level
            };

            $.ajax({
                url: "/api/class-level/post-save-classname",
                type: 'POST',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify(classes),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    swal("Berhasil", `Data Kelas : ${classes.classname} berhasil ditambahkan`, "success");

                    $(`#card-body-id`).removeClass('opacity');
                    $(`#submit-icon`).removeClass('hide');
                    $(`#loading-icon-submit`).addClass('hide');
                    $(`#submit-text`).text('Submit');

                    $("#classlevel-form")[0].reset();
                },
                error: function(response) {

                    let error_message = response.responseJSON.error_message;
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
    </script>
@endpush
