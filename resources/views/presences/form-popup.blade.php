@extends('layouts.main')

@section('content-header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>{{ $title }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
@endsection

@section('content')
    <button type="button" id="btn-show-classes" class="btn btn-block btn-outline-info btn-lg">Tampilkan Kelas</button>
    <div class="modal fade" id="modal-class-level" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Pilih Kelas</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="role-type" value="{{ session('role_type') }}" />
                    <input type="hidden" id="group"
                        value="{{ request()->session()->has('group')? session('group'): '' }}" />
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Daftar Kelas</label>
                            <select id="class-select2" class="form-control select2" style="width: 100%;">
                                <option value="">Pilih</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="button" id="btnSelect" class="btn btn-primary">
                            <i id="loading-icon-select" class="fa fa-spinner fa-spin hide"></i>
                            <span id="select-text">Pilih</span>
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
        <style>
            th:first-child,
            td:first-child {
                position: sticky;
                left: 0px;
                background-color: rgb(233, 232, 232);
            }

            .hide {
                display: none;
            }
        </style>

        <link rel="stylesheet" href="/adminlte/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
        <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">
    @endpush

    @push('js')
        <script src="/adminlte/plugins/select2/js/select2.full.min.js"></script>

        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script>
            $(document).ready(function() {
                debugger;
                $('.select2').select2();

                populate_class_select2();

                $('#modal-class-level').modal('show');

                let roleType = $('#role-type').val();

                // Role unless ppk
                $('#btnSelect').on('click', function() {
                    var classes = $(".select2 option:selected").val();

                    if (classes == undefined || classes == null || classes == '') {
                        swal("Info", "Silakan pilih kelas terlebih dahulu", "info");
                        return;
                    }

                    window.location.href = `/presensi/formulir?kelas=${classes}`;
                });

                $('#btn-show-classes').on('click', function() {
                    $('#modal-class-level').modal('show');
                })

            });

            function populate_class_select2() {
                debugger;
                let url = "/api/class-level/class-level-list-by-group";
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.data != undefined || response.data != null) {
                            for (let i = 0; i < response.data.length; i++) {
                                $("#class-select2").append(
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


        </script>
    @endpush
