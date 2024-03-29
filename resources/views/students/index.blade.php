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
<input type="hidden" id="role_type" value="{{ request()->session()->has('role_type') ? session('role_type') : "" }}"/>
<table id="example1" class="table table-bordered table-striped">
  <thead>
  <tr>
    <th>No</th>
    <th width="25%">Nama Lengkap</th>
    <th>Jenis Kelamin</th>
    <th>Jenjang</th>
    <th>Kelas</th>
    <th>Pendidikan</th>
    @if(session('role_type') != 'ppk')
    <th>Kelompok</th>
    @endif
    <th>Pribumi</th>
    @if(session('role_type') == 'ppk')
    <th width="10%">#</th>
    @endif
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
    @if(session('role_type') != 'ppk')
    <td>{{ $item->group }}</td>
    @endif

    <td>{{ $item->isPribumi == 1 ? "Ya" : "Tidak" }}</td>
    @if(session('role_type') == 'ppk')
    <td>
      <a href="/generus/ubah-generus?id={{ $item->id }}" class="btn btn-info btn-sm"> <i class="fa fa-pencil"></i></a>
      <a class="btn btn-danger btn-sm" onclick="deleteStudent('{{ $item->id }}', '{{ $item->fullname }}')"> <i class="fa fa-trash"></i></a>
    </td>
    @endif
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
    @if(session('role_type') != 'ppk')
    <th>Kelompok</th>
    @endif
    <th>Pribumi</th>
    @if(session('role_type') == 'ppk')
    <th>#</th>
    @endif
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

  let buttons;

  if ($('#role_type').val() != 'ppk') {
    buttons = `
    <div class="btn-group" role="group" aria-label="Button">
      <button type="button" id="print-student" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Cetak Data</button>
    </div>
    `;
  } else {
    buttons = `
    <div class="btn-group" role="group" aria-label="Button">
      <button type="button" id="add-student" class="btn btn-primary btn-sm"><i class="fa fa-user-plus" aria-hidden="true"></i> Tambah Data</button>
      <button type="button" id="print-student" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Cetak Data</button>
    </div>
    `;
  }



  $(buttons).appendTo('#example1_wrapper .col-md-6:eq(0)');

  $('#add-student').on('click', function() {
      window.location='{{ url("generus/tambah-generus") }}'
  });



});

function deleteStudent(id, name) {
  swal({
        title: "Apakah Anda Yakin?",
        text: `Menghapus ${name} dari database!`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          performDeleteStudent(id, name);
        }
      });

    return false;
  }

  function performDeleteStudent(id, name) {

    $.ajax({
        url:"/api/generus/delete-student-by-id",
        type: 'DELETE',
        dataType:'json',
        contentType: 'json',
        data: JSON.stringify({id:id}),
        contentType: 'application/json; charset=utf-8',
        headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        success: function(response){

          if (response.status) {
            swal("Berhasil", `Generus ${name} berhasil dihapus`, "success");
            location.reload(true);
          }
        },
        error: function(response) {

        }
      });
  }


</script>
@endpush
