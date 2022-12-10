<nav class="sidebar">
    <div class="sidebar-header">
      <a style="padding-top: 10px;" href="#" class="sidebar-brand">
        <img src="{{ url('storage/'.$logo) }}" width="70%">
      </a>
      <div class="sidebar-toggler not-active">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
    <div class="sidebar-body">
    @if (session()->has('roles_nama'))
      <ul class="nav">
        <li class="nav-item nav-category">Main</li>
        <!-- <li class="nav-item">
          <a href="{{ route('home') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">Dashboard</span>
          </a>
        </li> -->
        <li class="nav-item">
          <a href="{{ route('sender') }}" class="nav-link">
            <i class="link-icon" data-feather="send"></i>
            <span class="link-title">Sender</span>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('bulk') }}" class="nav-link">
            <i class="link-icon" data-feather="cast"></i>
            <span class="link-title">Bulk</span>
          </a>
      </li>
        <li class="nav-item">
          <a href="{{ route('contact') }}" class="nav-link">
            <i class="link-icon" data-feather="message-circle"></i>
            <span class="link-title">Contact</span>
          </a>
      </li>
        <li class="nav-item">
          <a href="{{ route('api_wa') }}" class="nav-link">
            <i class="link-icon" data-feather="codesandbox"></i>
            <span class="link-title">API WA</span>
          </a>
      </li>
        <li class="nav-item">
          <a href="{{ route('history') }}" class="nav-link">
            <i class="link-icon" data-feather="clock"></i>
            <span class="link-title">History WA</span>
          </a>
      </li>

        @if (hakAksesMenu('itinerary','read') || hakAksesMenu('visit','read') || hakAksesMenu('sesi','read') || hakAksesMenu('monitoring','read'))
            <li class="nav-item nav-category">Activity</li>
        @endif

        @if (hakAksesMenu('itinerary','read'))
        <li class="nav-item @yield('itineraryActive')">
          <a href="{{ url('/itinerary') }}" class="nav-link">
            <i class="link-icon" data-feather="layers"></i>
            <span class="link-title">Itinerary</span>
          </a>
        </li>
        @endif

        @if (hakAksesMenu('visit','read'))
        <li class="nav-item @yield('visitActive')">
            <a href="{{ url('/visit') }}" class="nav-link">
            <i class="link-icon" data-feather="map-pin"></i>
            <span class="link-title">Visit</span>
            </a>
        </li>
        @endif

        @if (hakAksesMenu('monitoring','read'))
        <li class="nav-item @yield('monitoringActive')">
          <a href="{{ url('/monitoring') }}" class="nav-link">
            <i class="link-icon" data-feather="search"></i>
            <span class="link-title">Monitoring</span>
          </a>
        </li>
        @endif

        @if (hakAksesMenu('struk','read'))
        <li class="nav-item @yield('strukActive')">
          <a href="{{ url('/struk') }}" class="nav-link">
            <i class="link-icon" data-feather="file-text"></i>
            <span class="link-title">Struk</span>
          </a>
        </li>
        @endif

        @if (hakAksesMenu('detail','read'))
        <li class="nav-item @yield('detailActive')">
          <a href="{{ url('/detail') }}" class="nav-link">
            <i class="link-icon" data-feather="clock"></i>
            <span class="link-title">Detailing</span>
          </a>
        </li>
        @endif

        @if (hakAksesMenu('sesi','read'))
        <li class="nav-item @yield('sesiActive')">
            <a href="{{ url('/sesi') }}" class="nav-link">
                <i class="link-icon" data-feather="smartphone"></i>
                <span class="link-title">Sesi User</span>
            </a>
        </li>
        @endif


        @if (hakAksesMenu('manpower','read') || hakAksesMenu('outlet','read'))
            <li class="nav-item nav-category">Data Master</li>

            @if (hakAksesMenu('import','read'))
            <li class="nav-item @yield('import')">
                <a href="{{ url('/importdriver') }}" class="nav-link">
                <i class="link-icon" data-feather="upload"></i>
                <span class="link-title">Import</span>
                </a>
            </li>
            @endif

            @if (hakAksesMenu('manpower','read'))
            <li class="nav-item @yield('manpower')">
                <a href="{{ url('/manpower') }}" class="nav-link">
                <i class="link-icon" data-feather="users"></i>
                <span class="link-title">Manpower</span>
                </a>
            </li>
            @endif

            @if (hakAksesMenu('outlet','read'))
            <li class="nav-item @yield('outletActive')">
                <a href="{{ url('/outlet') }}" class="nav-link">
                <i class="link-icon" data-feather="home"></i>
                <span class="link-title">Outlet</span>
                </a>
            </li>
            @endif
        @endif

        @if (hakAksesMenu('attendance','read') || hakAksesMenu('transaksi','read') || hakAksesMenu('quiz','read') || hakAksesMenu('user & retention','read'))
            <li class="nav-item nav-category">Report</li>
        @endif

        @if (hakAksesMenu('transaksi','read'))
            <li class="nav-item @yield('transaksi')">
                <a href="{{ url('/report/transaksi') }}" class="nav-link">
                <i class="link-icon" data-feather="trending-up"></i>
                <span class="link-title">Transaction</span>
                </a>
            </li>
        @endif

        @if (hakAksesMenu('pricing','read'))
            <li class="nav-item @yield('pricing')">
                <a href="{{ url('/report/pricing') }}" class="nav-link">
                <i class="link-icon" data-feather="dollar-sign"></i>
                <span class="link-title">Pricing</span>
                </a>
            </li>
        @endif

        @if (hakAksesMenu('attendance','read'))
            <li class="nav-item @yield('attendance')">
                <a href="{{ url('/report/attendance') }}" class="nav-link">
                <i class="link-icon" data-feather="users"></i>
                <span class="link-title">Attendance</span>
                </a>
            </li>
        @endif

        @if (hakAksesMenu('quiz','read'))
        <li class="nav-item @yield('quizActive')">
            <a href="{{ url('/quiz') }}" class="nav-link">
            <i class="link-icon" data-feather="help-circle"></i>
            <span class="link-title">Quiz</span>
            </a>
        </li>
        @endif

        @if (hakAksesMenu('user & retention','read'))
        <li class="nav-item @yield('retentionActive')">
            <a href="{{ url('/user-retention') }}" class="nav-link">
            <i class="link-icon" data-feather="user"></i>
            <span class="link-title">User & Retention</span>
            </a>
        </li>
        @endif

        @if (hakAksesMenu('new pack','read'))
        <li class="nav-item @yield('newpackActive')">
            <a href="{{ url('/newpack') }}" class="nav-link">
            <i class="link-icon" data-feather="box"></i>
            <span class="link-title">New Pack</span>
            </a>
        </li>
        @endif

      </ul>
    @endif
    </div>
</nav>
