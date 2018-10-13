<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('img/logo.png') }}" alt="App Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">App</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      @auth

      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('img/profile.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            @auth
              {{ Auth::user()->name }}
            @endauth
          </a>
        </div>
      </div>

      @endauth
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

          @auth

          <li class="nav-item">
            <router-link to="/dashboard" class="nav-link">
              <i class="fas fa-tachometer-alt blue"></i>
              <p>Dashboard</p>
            </router-link>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="fas fa-cog green"></i>
              <p>Management
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/users" class="nav-link">
                  <i class="fa fa-users nav-icon"></i>
                  <p>Users</p>
                </router-link>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <router-link to="/profile" class="nav-link">
              <i class="fas fa-user orange"></i>
              <p>
                Profile
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
              <i class="fas fa-power-off red"></i>
              <p>
                {{ __('Logout') }}
              </p>
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </li>

          @else

          <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link">
              <i class="fas fa-user teal"></i>
              <p>
                {{ __('Login') }}
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            @if (Route::has('register'))
              <a href="{{ route('register') }}" class="nav-link">
                <i class="fas fa-user cyan"></i>
                <p>
                  {{ __('Register') }}
                  
                </p>
              </a>
            @endif
          </li>

          @endauth
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>