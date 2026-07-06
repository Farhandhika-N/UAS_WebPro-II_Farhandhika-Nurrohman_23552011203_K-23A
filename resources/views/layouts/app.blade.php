<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Akademik</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
    body{
        background:#0f172a;
        color:#e2e8f0;
        font-family:'Inter',sans-serif;
        overflow-x:hidden;
    }

    /* Layout Structure */
    .app-wrapper {
        display: flex;
        width: 100%;
        min-height: 100vh;
    }

    /* Sidebar */
    .sidebar{
        width:260px;
        height: 100vh;         
        position: sticky;     
        top: 0;
        background:#020617;
        border-right:1px solid #1e293b;
        padding:20px;
        flex-shrink: 0;
        z-index: 1040;
        overflow-y: auto;     
        display: flex;
        flex-direction: column;
    }

    /* RESPONSIVE LAYOUT & SIDEBAR MOBILE */
    @media (max-width: 991.98px) {
        .sidebar {
            position: fixed;
            left: -260px; 
            top: 0;
            bottom: 0;
            height: 100vh;
        }
    }

    .sidebar.collapsed{
        width:80px;
    }
    .sidebar-toggle-animated {
        transition: width 0.3s ease;
    }
    .sidebar.collapsed span,
    .sidebar.collapsed .menu-title,
    .sidebar.collapsed .logo-text{
        display:none;
    }

    .sidebar.collapsed .nav-link{
        justify-content:center;
    }

    .sidebar.collapsed .btn-logout span {
        display: none;
    }
    
    .sidebar.collapsed .btn-logout {
        padding: 12px 0;
    }

    .logo{
        display:flex;
        align-items:center;
        gap:10px;
        margin-bottom:30px;
    }

    .logo i{
        color:#3b82f6;
        font-size:28px;
    }

    .logo h5{
        margin:0;
        font-weight:700;
    }

    .menu-title{
        color:#64748b;
        font-size:12px;
        text-transform:uppercase;
        letter-spacing:1px;
        margin-top:25px;
        margin-bottom:10px;
    }

    .nav-link{
        color:#94a3b8;
        display:flex;
        align-items:center;
        gap:10px;
        padding:12px;
        border-radius:10px;
        margin-bottom:6px;
        transition:.25s;
    }

    .nav-link:hover{
        background:#1e293b;
        color:white;
    }

    .nav-link.active{
        background:rgba(59,130,246,.15);
        color:#3b82f6;
    }

    /* Main Content Area */
    .main{
        flex:1;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }

    .topbar{
        background:#020617;
        border-bottom:1px solid #1e293b;
        padding:15px 25px;
    }

    .content{
        padding:25px;
        flex: 1;
    }

    .user-box{
        text-align:right;
    }

    .user-box strong{
        display:block;
    }

    .badge-role{
        background:#3b82f6;
        color:white;
        padding:4px 10px;
        border-radius:20px;
        font-size:12px;
    }

    .btn-logout{
        border-radius:10px;
        transition: .2s;
    }

    /* KUSTOMISASI SWEETALERT2 UNTUK LAYAR DESTOP */
    .swal2-popup {
        background: #020617 !important; 
        border: 1px solid #1e293b !important; 
        border-radius: 14px !important;
        padding: 2rem !important;
    }
    .swal2-title {
        color: #ffffff !important;
        font-family: 'Inter', sans-serif !important;
        font-size: 1.35rem !important;
        font-weight: 600 !important;
    }
    .swal2-html-container {
        color: #94a3b8 !important; 
        font-family: 'Inter', sans-serif !important;
        font-size: 0.9rem !important;
    }
    .swal2-actions {
        gap: 12px !important;
        margin-top: 1.5rem !important;
    }
    .swal2-styled {
        padding: 10px 24px !important;
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        font-family: 'Inter', sans-serif !important;
        border-radius: 8px !important;
        margin: 0 !important;
        transition: 0.2s !important;
    }
    .swal2-styled:focus {
        box-shadow: none !important;
    }

    ::-webkit-scrollbar{
        width:6px;
    }
    ::-webkit-scrollbar-thumb{
        background:#334155;
        border-radius:20px;
    }

    /* RESPONSIVE LAYOUT & SIDEBAR MOBILE */
    @media (max-width: 991.98px) {
        .sidebar {
            position: fixed;
            left: -260px; 
            top: 0;
            bottom: 0;
        }
        .sidebar.collapsed {
            left: 0; 
            width: 260px;
        }
        .sidebar.collapsed span,
        .sidebar.collapsed .menu-title,
        .sidebar.collapsed .logo-text,
        .sidebar.collapsed .btn-logout span {
            display: inline-block;
        }
        .sidebar.collapsed .menu-title {
            display: block;
        }
        .sidebar.collapsed .nav-link {
            justify-content: flex-start;
        }
        .content {
            padding: 15px;
        }
    }

    /* RESPONSIVE SWEETALERT2 UNTUK LAYAR MOBILE */
    @media (max-width: 576px) {
        .swal2-popup {
            padding: 1.25rem !important;
            width: 90% !important;
        }
        .swal2-title {
            font-size: 1.15rem !important;
        }
        .swal2-html-container {
            font-size: 0.85rem !important;
        }
        .swal2-actions {
            flex-direction: column-reverse !important;
            width: 100% !important;
            gap: 8px !important;
        }
        .swal2-styled {
            width: 100% !important;
            padding: 12px 16px !important;
            font-size: 0.9rem !important;
        }
        .user-box strong {
            font-size: 0.85rem;
        }
        .topbar {
            padding: 10px 15px;
        }
    }
    </style>
</head>

<body>

<div class="app-wrapper">

    {{-- SIDEBAR --}}
    <div class="sidebar" id="sidebar">
        <script>
            (function() {
                const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
                if (isCollapsed && window.innerWidth > 991.98) {
                    // Langsung mengunci kelas tanpa memicu transisi .sidebar-toggle-animated
                    document.getElementById('sidebar').classList.add('collapsed');
                }
            })();
        </script>

        <div class="logo">
            <i class="bi bi-mortarboard-fill"></i>
            <div class="logo-text">
                <h5>Sistem Akademik</h5>
            </div>
        </div>

        {{-- Dashboard --}}
        <a href="{{ route('dashboard') }}"
            class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>

        {{-- MASTER DATA --}}
        <div class="menu-title">Master Data</div>

        {{-- Jurusan (Admin saja) --}}
        @if(Auth::user()->role == 'admin')
            <a href="{{ route('jurusan.index') }}"
                class="nav-link {{ request()->routeIs('jurusan.*') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Jurusan</span>
            </a>
        @endif

        {{-- Mahasiswa --}}
        <a href="{{ route('mahasiswa.index') }}"
            class="nav-link {{ request()->routeIs('mahasiswa.*') ? 'active' : '' }}">
            <i class="bi bi-people-fill"></i>
            <span>Mahasiswa</span>
        </a>

        {{-- Dosen --}}
        <a href="{{ route('dosen.index') }}"
            class="nav-link {{ request()->routeIs('dosen.*') ? 'active' : '' }}">
            <i class="bi bi-person-badge-fill"></i>
            <span>Dosen</span>
        </a>

        {{-- Mata Kuliah --}}
        <a href="{{ route('matakuliah.index') }}"
            class="nav-link {{ request()->routeIs('matakuliah.*') ? 'active' : '' }}">
            <i class="bi bi-book-fill"></i>
            <span>Mata Kuliah</span>
        </a>

        {{-- TRANSAKSI --}}
        <div class="menu-title">Transaksi</div>

        {{-- KRS --}}
        <a href="{{ route('krs.index') }}"
            class="nav-link {{ request()->routeIs('krs.*') ? 'active' : '' }}">
            <i class="bi bi-journal-check"></i>
            <span>KRS</span>
        </a>

        {{-- Nilai --}}
        <a href="{{ route('nilai.index') }}"
            class="nav-link {{ request()->routeIs('nilai.*') ? 'active' : '' }}">
            <i class="bi bi-award-fill"></i>
            <span>Nilai</span>
        </a>

        {{-- Transkrip --}}
        <a href="{{ route('transkrip.index') }}"
            class="nav-link {{ request()->routeIs('transkrip.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Transkrip Nilai</span>
        </a>

        {{-- USER (Admin saja) --}}
        @if(Auth::user()->role == 'admin')
            <div class="menu-title">Administrator</div>

            <a href="{{ route('activity-log.index') }}"
                class="nav-link {{ request()->routeIs('activity-log.*') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Activity Log</span>
            </a>

            <a href="{{ route('user.index') }}"
                class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i>
                <span>Manajemen User</span>
            </a>
        @endif

        <hr class="text-secondary">

        <a href="#" onclick="confirmLogout(event)" class="btn btn-danger btn-logout w-100 d-flex align-items-center justify-content-center gap-2">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>

    </div>

    {{-- MAIN --}}
    <div class="main">

        {{-- TOPBAR --}}
        <div class="topbar d-flex justify-content-between align-items-center">

            <button class="btn text-light" onclick="toggleSidebar()">
                <i class="bi bi-list fs-3"></i>
            </button>

            <div class="user-box">
                <small class="text-secondary">Login sebagai</small>
                <strong>{{ Auth::user()->name }}</strong>
                <span class="badge-role">{{ strtoupper(Auth::user()->role) }}</span>
            </div>

        </div>

        {{-- CONTENT --}}
        <div class="content">
            @yield('content')
        </div>

    </div>

</div>

<!-- Scripts diletakkan di paling bawah agar render halaman -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sidebar = document.getElementById('sidebar');
    const isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';
    
    // Hanya berlaku untuk tampilan desktop (Layar lebar)
    if (window.innerWidth > 991.98) {
        if (isCollapsed) {
            sidebar.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
        }
    }
});
function toggleSidebar(){
    const sidebar = document.getElementById('sidebar');
        
        // Tambahkan class animasi hanya saat tombol diklik manual
        sidebar.classList.add('sidebar-toggle-animated');
        
        // Jalankan toggle core
        sidebar.classList.toggle('collapsed');
        
        // Simpan status terbaru ke local storage
        if (window.innerWidth > 991.98) {
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebar_collapsed', isCollapsed);
        }
    }

function confirmLogout(event){
    event.preventDefault(); 
    
    Swal.fire({
        title: 'Konfirmasi Keluar',
        text: 'Apakah Anda yakin ingin mengakhiri sesi ini?',
        icon: 'warning',
        iconColor: '#f59e0b',
        showCancelButton: true,
        confirmButtonColor: '#3b82f6',
        cancelButtonColor: '#1e293b',
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('logout-form').submit();
        }
    });
}

// DELETE-FORMS
document.addEventListener('DOMContentLoaded', function () {
    document.body.addEventListener('submit', function (event) {
        const form = event.target;
        
        if (form.classList.contains('delete-form')) {
            event.preventDefault();
            
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Apakah Anda yakin ingin menghapus data ini? Tindakan ini permanen.',
                icon: 'error',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#1e293b',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    });
});
</script>

</body>
</html>