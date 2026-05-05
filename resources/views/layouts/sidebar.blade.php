<!-- Sidebar Menu -->
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
      <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Dashboard</p>
      </a>
    </li>
    <li class="nav-item">
      <a href="#" class="nav-link {{ request()->is('tasks*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-table"></i>
        <p>
          Menu Utama
          <i class="right fas fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a href="{{ route('tasks.index') }}" class="nav-link {{ request()->routeIs('tasks.index') ? 'active' : '' }}">
            <i class="far fa-circle nav-icon"></i>
            <p>Kelola Task</p>
          </a>
        </li>
        @if(auth()->user()->role === 'admin')
            <li class="nav-item">
              <a href="{{ route('laporan.index') }}" class="nav-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Kelola Laporan</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Kelola User</p>
              </a>
            </li>
        @endif
      </ul>
    </li>
    <!-- Menu Setting dihapus sesuai permintaan -->
      <script>
        $(function() {
          var $logoutBtnSidebar = $('#logout-btn-sidebar');
          var $logoutFormSidebar = $('#logout-form-sidebar');
          if ($logoutBtnSidebar.length && $logoutFormSidebar.length) {
            $logoutBtnSidebar.off('click').on('click', function(e) {
              e.preventDefault();
              Swal.fire({
                title: 'Ingin Logout?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                reverseButtons: true
              }).then((result) => {
                if (result.isConfirmed) {
                  $logoutFormSidebar.off('submit');
                  $logoutFormSidebar.submit();
                }
              });
            });
            $logoutFormSidebar.on('submit', function(e) {
              if (!$logoutFormSidebar.data('swal-confirmed')) {
                e.preventDefault();
                $logoutBtnSidebar.click();
              }
            });
          }
        });
      </script>
      </ul>
    </li>
  </ul>
</nav>
<!-- /.sidebar-menu -->
