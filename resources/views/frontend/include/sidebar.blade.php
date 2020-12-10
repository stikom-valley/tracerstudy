<aside id="sidebar-wrapper">
  <div class="sidebar-brand">
    <a href="">{{ env('APP_NAME') }}</a>
  </div>
  <div class="sidebar-brand sidebar-brand-sm">
    <a href="#">Ts</a>
  </div>
  <ul class="sidebar-menu">
    <li class="menu-header">{{ Auth::user()->title }}</li>
    <li @yield('dashboard')>
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="fas fa-columns"></i> <span>Dashboard</span>
      </a>
    </li>
    @can('isBPA')
    @include('frontend.menu.bpa')
    @endcan
  </ul>
</aside>