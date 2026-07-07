<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PELINDO System' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --pelindo-blue: #007BFF;
            --pelindo-dark-blue: #005FCC;
            --bg-light: #F4F7FB;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --sidebar: #E5E5E5;
        }

        body {
            background: var(--bg-light);
            margin: 0;
            font-family: "Inter", sans-serif;
        }

        /* NAVBAR ATAS */
        .navbar-top {
            background: white;
            height: 82px;
            border-bottom: 1px solid rgba(0,0,0,0.08);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 999;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            box-shadow: 0 1px 6px rgba(0,0,0,0.06);
        }

        .top-info {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        /* LOGO YANG BISA DIKLIK */
        .top-logo {
            height: 100px;
            cursor: pointer;
            transition: 0.25s;
        }
        .top-logo:hover {
            transform: scale(1.05);
        }

        .top-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--pelindo-dark-blue);
        }

        .top-subtitle {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: -3px;
        }

        /* PROFILE NAVBAR KANAN */
        .profile-container {
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: end;
            gap: 6px;
        }

        #clock {
            font-size: 15px;
            font-weight: 700;
            color: #0F4C81;
        }

        .profile-box {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 50px;
            cursor: pointer;
            transition: 0.25s;
        }

        .profile-box:hover {
            background: white;
        }

        .profile-box img {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #0F4C81;
        }

        .profile-text {
            margin-left: 10px;
            line-height: 1.2;
        }

        .profile-name {
            font-weight: 700;
            color: #0F4C81;
            font-size: 15px;
        }

        .profile-role {
            font-size: 13px;
            color: #6c757d;
        }

        /* Dropdown Logout */
        .dropdown-logout {
            position: absolute;
            top: 78px;
            right: 0;
            width: 160px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
            padding: 8px 0;
            display: none;
            animation: fadeIn .25s ease;
            z-index: 20;
        }

        .dropdown-logout button {
            width: 100%;
            background: none;
            border: none;
            padding: 10px;
            text-align: left;
            font-size: 14px;
            color: #dc3545;
            font-weight: 600;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from { opacity:0; transform: translateY(-4px); }
            to   { opacity:1; transform: translateY(0); }
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 82px;
            left: 0;
            width: 250px;
            height: calc(100% - 82px);
            background: white;
            padding-top: 20px;
            border-right: 1px solid rgba(0,0,0,0.1);
            box-shadow: 4px 0 12px rgba(0,0,0,0.04);
            transition: .35s ease;
            z-index: 998;
        }

        .sidebar.closed {
            transform: translateX(-260px);
        }

        .sidebar a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 26px;
            margin: 4px 12px;
            border-radius: 10px;
            font-size: 15px;
            color: #0374BE;
            text-decoration: none;
            transition: 0.25s ease;
            background: #D9D9D9;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #0374BE;
            color: white;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
        }

        .logout-section {
            position: absolute;
            bottom: 25px;
            width: 100%;
            padding: 0 20px;
        }

        .logout-btn {
            width: 100%;
            background: #d9534f;
            border: none;
            color: white;
            padding: 12px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            gap: 10px;
            font-weight: 600;
            transition: .2s;
        }

        .logout-btn:hover {
            background: #c64541;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
            padding-top: 110px;
            min-height: 100vh;
            transition: .35s ease;
        }

        .content.full {
            margin-left: 0 !important;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-260px); }
            .sidebar.closed { transform: translateX(0); }
            .content { margin-left: 0 !important; }
        }
    </style>
</head>

<body>

<div class="navbar-top">

    <div class="d-flex align-items-center">

        <!-- LOGO YANG BISA DIKLIK UNTUK TOGGLE SIDEBAR -->
        <div class="top-info">
            <img id="logoToggle" src="{{ asset('images/logobulet.png') }}" class="top-logo" alt="PELINDO">
            <div>
                <div class="top-title">SANDRA</div>
                <div class="top-subtitle">Smart Discharging and Recording System</div>
            </div>
        </div>
    </div>

    <!-- PROFILE -->
    <div class="profile-container">

        <div class="profile-box" id="profileToggle">
            <img src="{{ asset('images/pp.png') }}">
            <div class="profile-text">
                <div class="profile-name">{{ Session::get('username') }}</div>
                <div class="profile-role">Sistem Operator • Active</div>
            </div>
        </div>

        <div class="dropdown-logout" id="logoutMenu">
            <form action="{{ url('/logout') }}" method="POST">
                @csrf
                <button type="submit"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</button>
            </form>
        </div>

    </div>
</div>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar">

    <a href="{{ route('tally.pilihKapal') }}" class="{{ request()->routeIs('tally.pilihKapal') ? 'active' : '' }}">
        <i class="fa-solid fa-ship"></i> Pilih Kapal
    </a>

    <a href="{{ route('tally.konfirmasi') }}" class="{{ request()->routeIs('tally.konfirmasi') ? 'active' : '' }}">
        <i class="fa-solid fa-list-check"></i> Tally Konfirmasi
    </a>

    <a href="{{ route('discharging') }}" class="{{ request()->routeIs('discharging') ? 'active' : '' }}">
        <i class="fa-solid fa-box-open"></i> Discharging
    </a>

    <a href="#" class="btn-gateout-database">
        <i class="fa-solid fa-database"></i> Gate Out Database
    </a>

    <a href="#" class="btn-gateout-filter">
        <i class="fa-solid fa-filter"></i> Filter & Export
    </a>

    <a href="{{ route('gateout.chart') }}" class="{{ request()->routeIs('gateout.chart') ? 'active' : '' }}">
    <i class="fa-solid fa-chart-line"></i> Total Discharge
</a>




    <div class="logout-section">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="logout-btn">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </form>
    </div>
</div>

<!-- CONTENT -->
<div id="content" class="content">
    @yield('content')
</div>

<script>
    // Toggle Sidebar
    function toggleSidebar() {
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");

        sidebar.classList.toggle("closed");
        content.classList.toggle("full");
    }

    // Logo kini berfungsi untuk toggle sidebar
    document.getElementById("logoToggle").addEventListener("click", toggleSidebar);

    // Toggle Profile Dropdown
    const profileToggle = document.getElementById("profileToggle");
    const logoutMenu = document.getElementById("logoutMenu");

    profileToggle.addEventListener("click", () => {
        logoutMenu.style.display =
            logoutMenu.style.display === "block" ? "none" : "block";
    });

</script>

<script>
document.addEventListener("DOMContentLoaded", function() {

    document.querySelector(".btn-gateout-database")
      ?.addEventListener("click", function(e) {
        e.preventDefault();
        new bootstrap.Modal(document.getElementById('gateoutModal')).show();
    });

    document.querySelector(".btn-gateout-filter")
      ?.addEventListener("click", function(e) {
        e.preventDefault();
        new bootstrap.Modal(document.getElementById('gateoutModal')).show();
    });

});
</script>

</body>
</html>
