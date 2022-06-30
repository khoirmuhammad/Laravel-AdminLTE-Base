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
        <div class="card-body">
            <a href="/menu/tambah-menu" class="btn btn-primary btn-sm mb-2"><i class="fas fa-plus"></i> Tambah Menu</a>
            <input type="hidden" id="role_type"
                value="{{ request()->session()->has('role_type')? session('role_type'): '' }}" />
            <table class="table table-bordered table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul Menu</th>
                        <th>Urutan</th>
                        <th>Icon</th>
                        <th>#</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($data as $item)
                        <tr data-toggle="collapse" data-target="#id{{ $item['order'] }}" class="accordion-toggle">
                            <td><button class="btn btn-default btn-xs"><span class="fa fa-expand"
                                        aria-hidden="true"></span></button></td>
                            <td>{{ $item['title'] }}</td>
                            <td>{{ $item['order'] }}</td>
                            <td>{{ $item['icon'] }}</td>
                            <td>
                                <a href="/menu/ubah-menu?id={{ $item['id'] }}" class="btn btn-info btn-sm"> <i
                                        class="fa fa-pencil"></i></a>
                                <a class="btn btn-danger btn-sm"
                                    onclick="deleteMenu('{{ $item['id'] }}', '{{ $item['title'] }}')"> <i
                                        class="fa fa-trash"></i></a>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="12" class="hiddenRow">
                                <div class="accordian-body collapse" id="id{{ $item['order'] }}">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr class="info">
                                                <th>Judul Menu</th>
                                                <th>Urutan</th>
                                                <th>URL</th>
                                                <th>Icon</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($item['children'] as $itemChild)
                                                <tr>
                                                    <td>{{ $itemChild->title }}</td>
                                                    <td>{{ $itemChild->order }}</td>
                                                    <td>{{ $itemChild->route }}</td>
                                                    <td>{{ $itemChild->icon }}</td>
                                                    <td>
                                                        <a href="/menu/ubah-menu?id={{ $itemChild->id }}"
                                                            class="btn btn-info btn-sm"> <i class="fa fa-pencil"></i></a>
                                                        <a class="btn btn-danger btn-sm"
                                                            onclick="deleteMenu('{{ $itemChild->id }}', '{{ $itemChild->title }}')">
                                                            <i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
    <style>
        .hiddenRow {
            padding: 0 !important;
        }
    </style>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="/adminlte/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@endpush

@push('js')
    <!-- DataTables  & Plugins -->
    <script src="/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="/adminlte/plugins/jszip/jszip.min.js"></script>
    <script src="/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script>
        $(document).ready(function() {



            $('#example1 tfoot th').each(function() {
                var title = $(this).text();

                if (title != 'No' && title != '#') {
                    $(this).html('<input type="text" class="form-control" placeholder="' + title + '" />');
                }

            });

            // DataTable
            var table = $('#example1').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                initComplete: function() {
                    // Apply the search
                    this.api()
                        .columns()
                        .every(function() {
                            var that = this;

                            $('input', this.footer()).on('keyup change clear', function() {
                                if (that.search() !== this.value) {
                                    that.search(this.value).draw();
                                }
                            });
                        });
                },
            });

            let buttons = `
    <div class="btn-group" role="group" aria-label="Button">
      <button type="button" id="add-menu" class="btn btn-primary btn-sm"><i class="fa fa-user-plus" aria-hidden="true"></i> Tambah Data</button>

    </div>
    `;



            $(buttons).appendTo('#example1_wrapper .col-md-6:eq(0)');

            $('#add-menu').on('click', function() {
                window.location = '{{ url('generus/tambah-generus') }}'
            });



        });

        function deleteMenu(id, title) {
            swal({
                    title: "Apakah Anda Yakin?",
                    text: `Menghapus ${title} dari database!`,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        performDeleteMenu(id, title);
                    }
                });

            return false;
        }

        function performDeleteMenu(id, title) {
            debugger;
            $.ajax({
                url: "/api/menu/delete-menu",
                type: 'DELETE',
                dataType: 'json',
                contentType: 'json',
                data: JSON.stringify({
                    id: id
                }),
                contentType: 'application/json; charset=utf-8',
                headers: {
                    'X-CSRF-TOKEN': CSRF_TOKEN
                },
                success: function(response) {
                    debugger;
                    swal("Berhasil", `Data Menu : ${title} berhasil dihapus`, "success");
                    setTimeout(function() {
                        location.reload(true);
                    }, 2000);
                },
                error: function(response) {
                    if (response.status == 409) {
                        swal("Peringatan", `${response.responseJSON.error_message}`, "info");
                    } else if (response.status == 500) {
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
                        swal("Peringatan", `${response.status} - ${response.statusText}`, "error");
                    }
                }
            });
        }
    </script>
@endpush
