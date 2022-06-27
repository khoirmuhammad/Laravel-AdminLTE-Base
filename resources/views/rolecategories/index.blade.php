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
<table id="example1" class="table table-bordered table-striped table-sm">
  <thead>
  <tr>
    <th>No</th>
    <th width="25%">kode</th>
    <th>Role Kategori</th>
    <th width="10%">#</th>
  </tr>
  </thead>
  <tbody>

  @foreach($data as $item)
  <tr>
    <td>{{ $loop->index + 1 }}</td>
    <td>{{ $item['id'] }}</td>
    <td>{{ $item['name'] }}</td>
    <td>
        <a href="/kategori-role/ubah-role?id={{ $item['id'] }}" class="btn btn-info btn-sm"> <i class="fa fa-pencil"></i></a>
        <a class="btn btn-danger btn-sm" onclick="deleteRoleKategori('{{ $item['id'] }}', '{{ $item['name'] }}')"> <i class="fa fa-trash"></i></a>
    </td>
  </tr>
  @endforeach



  </tbody>
  <tfoot>
  <tr>
    <th>No</th>
    <th width="25%">kode</th>
    <th>Role Kategori</th>
    <th width="10%">#</th>
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
      <button type="button" id="add-role-category" class="btn btn-primary btn-sm"><i class="fa fa-user-plus" aria-hidden="true"></i> Tambah Data</button>
    </div>
    `;
  }



  $(buttons).appendTo('#example1_wrapper .col-md-6:eq(0)');

  $('#add-role-category').on('click', function() {
      window.location='{{ url("kategori-role/tambah-role") }}'
  });



});

function deleteRoleKategori(id, name) {
    debugger;
  swal({
        title: "Apakah Anda Yakin?",
        text: `Menghapus ${name} dari database!`,
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          performDeleteRoleKategori(id, name);
        }
      });

    return false;
  }

  function performDeleteRoleKategori(id, name) {
    debugger;
    $.ajax({
        url:"/api/role-categories/delete-role-category",
        type: 'DELETE',
        dataType:'json',
        contentType: 'json',
        data: JSON.stringify({'id':id}),
        contentType: 'application/json; charset=utf-8',
        headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        success: function(response){
          debugger;
          if (response == undefined) {
            swal("Berhasil", `Data Role : ${name} berhasil dihapus`, "success");
            location.reload(true);
          } else {
            if (response.status) {
                swal("Berhasil", `Data Role : ${name} berhasil dihapus`, "success");
                location.reload(true);
            } else {
                swal("Peringatan", `${response.error_message}`, "info");
          }
          }



        },
        error: function(response) {
          debugger;
        }
      });
  }


</script>
@endpush
