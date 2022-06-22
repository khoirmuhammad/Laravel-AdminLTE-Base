<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MDT Al A'laa | {{ $title }}</title>
  <link rel="icon" href="{{ URL::asset('assets/favicon-16x16.png') }}" type="image/x-icon"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/adminlte/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/adminlte/dist/css/adminlte.min.css">

  <style>
    .opacity {
        opacity: 0.5;
    }

    .hide {
        display: none;
    }

    .center {
      display: block;
      margin-left: auto;
      margin-right: auto;
      width: 50%;
    }
</style>

</head>
<body class="hold-transition login-page" id="login-page-id" style="background-image: url('assets/background-img.jpg');">
<div class="login-box" >
  <!-- /.login-logo -->
  <div class="card card-outline card-secondary">
    <div class="card-header text-center">
      <img class="center" src="{{ asset('assets/ms-icon-310x310.png') }}" alt="MDT Al A'laa" style="width:80px;height:80px;">
    </div>
    <div class="card-body">
      <p class="login-box-msg">Masuk untuk memulai sesi Anda</p>

      <form action="#" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Nama Pengguna" name="username" id="txtUsername">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Kata Sandi" name="password" id="txtPassword">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="button" id="btnLogin" class="btn btn-secondary btn-block">
              <i id="login-icon" class="fas fa-sign-in-alt"></i>
              <i id="loading-icon-login" class="fa fa-spinner fa-spin hide"></i>
              <span id="store-text">Login</span>
            </button>
          </div>
          <!-- /.col -->
        </div>

        <br>
        <p class="mb-3" align="center">
          <a href="#">Lupa Kata Sandi ?</a>
        </p>
        
        <p class="cp-text" align="center">
          © Hak Cipta 2022 MDT Al A'laa.
      </p>
      </form>

    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->



<div class="modal fade" id="modal-roles">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Login sebagai</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

          <div class="col-sm-6">
            <!-- radio -->
            <div class="form-group clearfix" id="roles-radio">
              
            </div>

        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          <button type="button" id="btnProceed" class="btn btn-primary">
            <i id="loading-icon-proceed" class="fa fa-spinner fa-spin hide"></i>
              <span id="proceed-text">Lanjutkan</span>
          </button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- jQuery -->
<script src="/adminlte/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="/adminlte/dist/js/adminlte.min.js"></script>


<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>
    $(document).ready(function() {

        $('#txtUsername').focus();
        
        var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

        $('#txtPassword').on('keypress', function (e) {
         if(e.which === 13){
          authentication();
         }
        });

        $('#btnLogin').on('click', function() {         
          authentication();
        });


        $('#btnProceed').on('click', function() {
          debugger;
          let radioVal = $("input[name='role']:checked").val();

          if (radioVal == undefined || radioVal == null) {
            swal("Info", "Pilih salah satu role anda", "info"); return;
          }

          $('#loading-icon-proceed').removeClass('hide');
          $('#proceed-text').text('');

          let credentials = {
            'username' : $('#txtUsername').val(),
            'password' : $('#txtPassword').val(),
            'role' : radioVal
          };

          authorization(credentials);

        });

        function authorization(credentials) {
          $.ajax({
                url:"login/post-authorization",
                type: 'POST',
                dataType:'json',
                contentType: 'json',
                data: JSON.stringify(credentials),
                contentType: 'application/json; charset=utf-8',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                success: function(response){
                  if (response.response.status) {
                    $('#loading-icon-proceed').addClass('hide');
                    $('#proceed-text').text('Lanjutkan');

                    swal("Berhasil", response.response.message, "success");

                    window.location.href = response.response.redirect;
                  } else {
                    $('#loading-icon-proceed').addClass('hide');
                    $('#proceed-text').text('Lanjutkan');
                    
                    swal("Error", response.response.message, "error"); return;
                    
                  }
                },
                error: function(response) {
                    debugger;
                    $('#loading-icon-proceed').addClass('hide');
                    $('#proceed-text').text('Lanjutkan');
                    console.log(response);
                }
              });
        }


        function authentication() {
          let credentials = {
                'username': $('#txtUsername').val(),
                'password' : $('#txtPassword').val()
            };

            if (credentials.username == undefined || credentials.username == null || credentials.username == '') {
                swal("Info", "Silakan masukkan nama pengguna", "info"); return;
            }

            if (credentials.password == undefined || credentials.password == null || credentials.password == '') {
                swal("Info", "Silakan masukkan kata sandi", "info"); return;
            }

            $('#login-page-id').addClass('opacity');
            $('#login-icon').addClass('hide');
            $('#loading-icon-login').removeClass('hide');
            $('#store-text').text('');

            debugger;
            $.ajax({
                url:"login/post-authentication",
                type: 'POST',
                dataType:'json',
                contentType: 'json',
                data: JSON.stringify(credentials),
                contentType: 'application/json; charset=utf-8',
                headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
                success: function(response){
                    debugger;

                    $('#login-page-id').removeClass('opacity');
                    $('#login-icon').removeClass('hide');
                    $('#loading-icon-login').addClass('hide');
                    $('#store-text').text('Login');
                    
                    if (response.response.status) {
                      let roles = response.response.data;

                      $('#roles-radio').empty().append('');

                      roles.forEach(element => {
                        $('#roles-radio').append(`<div class="icheck-primary">
                            <input type="radio" id="${element.role}" name="role" value="${element.role}">
                            <label for="${element.role}">
                              ${element.role}
                            </label>
                          </div>`);
                      });

                      $('#modal-roles').modal('show'); 

                    } else {
                      swal("Error", response.response.message, "error"); return;
                    }

                },
                error: function(response) {
                    debugger;
                    $('#login-page-id').removeClass('opacity');
                    $('#login-icon').removeClass('hide');
                    $('#loading-icon-login').addClass('hide');
                    $('#store-text').text('Login');

                    console.log(response);
                }
            });
        }

    });
</script>

</body>
</html>
