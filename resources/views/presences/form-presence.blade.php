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
<div class="card-body" id="card-body-id">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Muhammad Khoirudin</th>
                    <th>DASAR 2</th>
                    <th><button class="btn btn-block btn-primary btn-sm"> <i class="fa fa-check" aria-hidden="true"></i> Presensi Sekarang</button></th>
                  </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Keterangan</th>
                    <th width="10%"><button class="btn btn-block btn-success btn-sm"> <i class="fa fa-check" aria-hidden="true"></i> Hadir</button></th>
                    <th width="10%"><button class="btn btn-block btn-info btn-sm"> <i class="fa fa-hand-pointer-o" aria-hidden="true"></i> Izin</button></th>
                    <th width="10%"><button class="btn btn-block btn-danger btn-sm"> <i class="fa fa-close" aria-hidden="true"></i> Alfa</button></th>
                  </tr>
                </thead>
            </table>
        </div>
    </div>
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

});


</script>
@endpush