<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    body {
        background: #0f172a;
        color: #e2e8f0;
        font-family: 'Inter', sans-serif;
        overflow-x: hidden;
    }

    /* SIDEBAR */
    .sidebar {
        width: 260px;
        background: #020617;
        min-height: 100vh;
        padding: 20px;
        border-right: 1px solid #1e293b;
        transition: 0.3s;
    }

    .sidebar.collapsed {
        width: 80px;
    }

    .sidebar h5 {
        font-weight: 600;
        white-space: nowrap;
    }

    .sidebar.collapsed h5 span {
        display: none;
    }

    .sidebar.collapsed button span {
        display: none;
    }

    .sidebar.collapsed button {
        justify-content: center;
    }

    .nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #94a3b8;
        padding: 12px;
        border-radius: 10px;
        margin-bottom: 6px;
        transition: all 0.2s ease;
    }

    .nav-link span {
        white-space: nowrap;
    }

    .sidebar.collapsed .nav-link span {
        display: none;
    }

    .nav-link:hover {
        background: #1e293b;
        color: #fff;
    }

    .nav-link.active {
        background: rgba(59,130,246,0.15);
        color: #3b82f6;
    }

    /* MAIN */
    .main {
        flex-grow: 1;
        transition: 0.3s;
    }

    /* HEADER */
    .topbar {
        background: #020617;
        border-bottom: 1px solid #1e293b;
        padding: 15px 25px;
    }

    /* CONTENT */
    .content {
        padding: 25px;
    }

    /* CARD */
    .card-soft {
        background: #1e293b;
        border-radius: 16px;
        padding: 20px;
        border: 1px solid #334155;
        box-shadow: 0 0 0 1px rgba(255,255,255,0.02);
    }

    /* TABLE */
    .table-custom {
        width: 100%;
        color: #e2e8f0;
        border-collapse: collapse;
    }

    .table-custom thead {
        background: #1e293b;
    }

    .table-custom th {
        color: #94a3b8;
        font-size: 0.75rem;
        text-transform: uppercase;
        padding: 12px;
    }

    .table-custom td {
        padding: 12px;
        border-top: 1px solid #334155;
    }

    .table-custom tr:hover {
        background: #334155;
    }

    /* BUTTON */
    .btn-danger {
        border-radius: 10px;
    }

    /* SCROLL */
    ::-webkit-scrollbar {
        width: 6px;
    }

    ::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 10px;
    }
    </style>
</head>

<body>

<div class="d-flex">

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">
        <h5 class="text-white mb-4">
            Sistem<span class="text-primary">Akademik</span>
        </h5>

        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>

        <a href="{{ route('jurusan.index') }}" class="nav-link {{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
            <i class="bi bi-building"></i> <span>Jurusan</span>
        </a>

        <a href="{{ route('mahasiswa.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> <span>Mahasiswa</span>
        </a>

        <a href="{{ route('matakuliah.index') }}" class="nav-link {{ request()->routeIs('matakuliah.*') ? 'active' : '' }}">
            <i class="bi bi-book"></i> <span>Matakuliah</span>
        </a>

        <hr class="text-secondary">

        <button onclick="confirmLogout()" class="btn btn-danger w-100 d-flex align-items-center gap-2">
            <i class="bi bi-box-arrow-right"></i> <span>Logout</span>
        </button>

        <form id="logout-form" method="POST" action="{{ route('logout') }}">
            @csrf
        </form>
    </div>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar d-flex justify-content-between align-items-center">

            <!-- TOGGLE -->
            <button class="btn text-light" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>

            <!-- USER -->
            <div class="text-end">
                <small class="text-secondary">Login sebagai</small><br>
                <strong>{{ Auth::user()->name }}</strong>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>

    </div>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
}

function confirmLogout() {
    if (confirm("Yakin ingin logout dari sistem?")) {
        document.getElementById('logout-form').submit();
    }
}
</script>

</body>
</html>