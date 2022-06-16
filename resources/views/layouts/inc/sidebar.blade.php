<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/adminlte/index3.html" class="brand-link">
      <img src="/adminlte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Datinfo PPG</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/adminlte/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user() != null ? auth()->user()->name : "" }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          @foreach ($sidebars as $sidebar)
          @if ($sidebar['childs_count'] > 0)
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon {{ $sidebar['icon'] }}"></i>
                <p>
                  {{ $sidebar['title'] }}
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                @foreach ($sidebar['childs'] as $child)
                  <li class="nav-item">
                    <a href="{{ $child['route'] }}" class="nav-link">
                      <i class="{{ $child['icon'] }}"></i>
                      <p>{{ $child['title'] }}</p>
                    </a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="far fa-circle nav-icon"></i>
              <p>{{ $sidebar['title']}}</p>
            </a>
          </li>
          
          @endif

          
          @endforeach

          <li class="nav-item">
            <a href="javascript:void(0)" onclick="logout()" class="nav-link">
              <i class="nav-icon fa fa-sign-out"></i>
              <p>
                Keluar
              </p>
            </a>
          </li>

         
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>


  <script src="/adminlte/plugins/jquery/jquery.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script>
    var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    function logout() {

      swal({
        title: "Apakah Anda Yakin?",
        text: "Keluar dari Aplikasi",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willLogout) => {
        if (willLogout) {
          post_logout();
        }
      });

      
    }

    function post_logout() {
      debugger;
      $.ajax({
        url:"/login/post-logout",
        type: 'POST',
        dataType:'json',
        contentType: 'json',
        contentType: 'application/json; charset=utf-8',
        headers: {'X-CSRF-TOKEN': CSRF_TOKEN},
        success: function(response){
          debugger
          if (response.response.redirect) {
            window.location.href = response.response.redirect;
          }
        },
        error: function(response) {
          console.log(response)
        }
      });
    }

  </script>