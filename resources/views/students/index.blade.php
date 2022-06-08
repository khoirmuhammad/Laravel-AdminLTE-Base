@extends('layouts.main')

@section('content-header')
<div class="container-fluid">
<div class="row mb-2">
<div class="col-sm-6">
  <h1>{{ $title}}</h1>
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
<table id="example1" class="table table-bordered table-striped">
  <thead>
  <tr>
    <th>No</th>
    <th width="25%">Nama Lengkap</th>
    <th>Jenis Kelamin</th>
    <th>Jenjang</th>
    <th>Kelas</th>
    <th>Pendidikan</th>
    <th>Kelompok</th>
    <th>Pribumi</th>
  </tr>
  </thead>
  <tbody>

  @foreach($data as $item)
  <tr>
    <td>{{ $loop->index + 1 }}</td>
    <td>{{ $item->fullname }}</td>
    <td>{{ $item->gender }}</td>
    <td>{{ $item->level }}</td>
    <td>{{ $item->class }}</td>
    <td>{{ $item->education }}</td>
    <td>{{ $item->group }}</td>
    <td>{{ $item->isPribumi == 1 ? "Ya" : "Tidak" }}</td>
  </tr>
  @endforeach

  

  </tbody>
  <tfoot>
  <tr>
    <th>No</th>
    <th>Nama Lengkap</th>
    <th>Jenis Kelamin</th>
    <th>Jenjang</th>
    <th>Kelas</th>
    <th>Pendidikan</th>
    <th>Kelompok</th>
    <th>Pribumi</th>
  </tr>
  </tfoot>
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



  $('#example1 tfoot th').each(function () {
        var title = $(this).text();

        if (title != 'No') {
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
        initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;
 
                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        },
    });

  let buttons = `
  <div class="btn-group" role="group" aria-label="Button">
    <button type="button" id="student_import_excel_remaja" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o" aria-hidden="true"> Impor Data Excel Remaja</i></button>
    <button type="button" id="student_import_excel_caberawit" class="btn btn-info btn-sm"><i class="fa fa-file-excel-o" aria-hidden="true"> Impor Data Excel Caberawit</i></button>
  </div>
  `;

  $(buttons).appendTo('#example1_wrapper .col-md-6:eq(0)');

  $('#student_import_excel_remaja').on('click', function() {
      window.location='{{ url("generus/impor-excel-remaja") }}'
  })

});




</script>
@endpush