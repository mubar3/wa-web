<nav class="navbar">
    <a href="#" class="sidebar-toggler">
        <i data-feather="menu"></i>
    </a>
    <div class="navbar-content">
        <!-- <div style="float: left; margin:20px 0 0 0;">
            {{ session('cluster_nama') }} | {{ session('area_nama') }} |  {{ session('divisi_nama') }}
        </div> -->
        @if(isset($title_web))
        <ul class="navbar-nav"><h4 style="padding-top: 10px; text-align:center">{{ $title_web}}</h4><br></ul>
        @endif
        <ul class="navbar-nav">
            @if (hakAksesMenu('umum','read') || hakAksesMenu('users','read') || hakAksesMenu('roles','read') || hakAksesMenu('rolesitem','read'))
            <li class="nav-item dropdown nav-apps">
                <a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i data-feather="grid"></i>
                </a>
                <div class="dropdown-menu" aria-labelledby="appsDropdown">
                    <div class="dropdown-header d-flex align-items-center justify-content-between">
                        <p class="mb-0 font-weight-medium">Pengaturan</p>
                    </div>
                    <div class="dropdown-body">
                        <div class="d-flex align-items-center apps">
                            @if (hakAksesMenu('umum','read'))
                            <a href="{{ url('/umum') }}"><i data-feather="codepen" class="icon-lg"></i><p>Umum</p></a>
                            @endif

                            @if (hakAksesMenu('users','read'))
                            <a href="{{ url('/user') }}"><i data-feather="users" class="icon-lg"></i><p>Users</p></a>
                            @endif

                            @if (hakAksesMenu('roles','read'))
                            <a href="{{ url('/roles') }}"><i data-feather="slack" class="icon-lg"></i><p>Roles</p></a>
                            @endif

                            @if (hakAksesMenu('rolesitem','read'))
                            <a href="{{ url('/rolesitem') }}"><i data-feather="list" class="icon-lg"></i><p>Roles Item</p></a>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
            @endif

            <li class="nav-item dropdown nav-profile">
                <a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="{{ url('storage/foto/'.Auth::user()->foto) }}" alt="userr">
                </a>
                <div class="dropdown-menu" aria-labelledby="profileDropdown">
                    <div class="dropdown-header d-flex flex-column align-items-center">
                        <div class="figure mb-3">
                            <img src="{{ url('storage/foto/'.Auth::user()->foto) }}" alt="">
                        </div>
                        <div class="info text-center">
                            <p class="name font-weight-bold mb-0">{{ Auth::user()->nama }}</p>
                            <p class="email text-muted mb-3">{{ session('roles_nama') }} - {{ session('cluster_nama') }}</p>
                        </div>
                    </div>
                    <div class="dropdown-body">
                        <ul class="profile-nav p-0 pt-3">
                            <li class="nav-item">
                                <a href="{{ url('/profil') }}" class="nav-link">
                                    <i data-feather="user"></i>
                                    <span>Profile</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('/profil/password') }}" class="nav-link">
                                    <i data-feather="edit"></i>
                                    <span>Ganti Password</span>
                                </a>
                            </li>

                            @if ($roles_count > 1)
                            <li class="nav-item">
                                <a href="{{ url('/roles/pilihan') }}" class="nav-link">
                                    <i data-feather="repeat"></i>
                                    <span>Ganti Role</span>
                                </a>
                            </li>
                            @endif

                            <li class="nav-item">
                                <a href="{{ url('/logout') }}" class="nav-link" id="logout-btn">
                                    <i data-feather="log-out"></i>
                                    <span>Log Out</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
