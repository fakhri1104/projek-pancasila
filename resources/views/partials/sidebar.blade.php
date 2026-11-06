<style>
    #sidebar {
        height: 100vh;
        width: 240px;
        transition: width 0.3s ease-in-out;
        position: fixed;
        left: 0;
        top: 0;
        z-index: 40;
        display: flex;
        flex-direction: column;
        background: rgba(119, 136, 115, 0.85);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border-right: 1px solid rgba(209, 216, 190, 0.5);
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 10px 25px -5px rgba(0, 0, 0, 0.1);
    }

    /* Toggle button normal (sidebar terbuka) */
    #toggleButton {
        position: fixed;
        left: 248px;
        top: 20px;
        z-index: 50;
        transition: left 0.3s ease-in-out, opacity 0.2s ease;
        background: none;
        border: none;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    #toggleButton:hover {
        opacity: 0.7;
    }

    /* Logo header wrapper */
    #logo-header {
        cursor: default;
        transition: background 0.2s ease;
        border-radius: 12px;
        position: relative;
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Saat sidebar collapsed, logo jadi toggle */
    #sidebar.is-collapsed #logo-header {
        cursor: pointer;
    }

    #sidebar.is-collapsed #logo-header:hover {
        background: rgba(209, 216, 190, 0.2);
    }

    /* Logo image — hilang saat hover + collapsed */
    #logo-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 10px;
        background: #EEEFE0;
        transition: opacity 0.2s ease;
    }

    #sidebar.is-collapsed #logo-header:hover #logo-img {
        opacity: 0;
    }

    /* Overlay toggle icon */
    #logo-toggle-overlay {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    /* Muncul saat hover + collapsed */
    #sidebar.is-collapsed #logo-header:hover #logo-toggle-overlay {
        opacity: 1;
    }

    .sidebar-text {
        transition: opacity 0.2s ease-in-out;
        opacity: 1;
        white-space: nowrap;
        overflow: hidden;
    }

    .sidebar-text.collapsed {
        opacity: 0;
        width: 0 !important;
        margin: 0 !important;
        display: none;
    }

    .nav-link {
        display: flex;
        align-items: center;
        transition: background 0.2s ease;
        overflow: hidden;
    }

    .sidebar-content {
        flex: 1;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 1rem;
    }

    .sidebar-footer {
        border-top: 1px solid rgba(209, 216, 190, 0.5);
        padding: 1rem;
        overflow: hidden;
    }

    /* Footer content wrapper */
    .footer-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    /* Profile section dalam footer */
    .profile-section {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        min-width: 0;
        flex: 1;
    }

    /* Saat collapsed, profile section diatur agar kontennya rata tengah */
    #sidebar.is-collapsed .profile-section {
        justify-content: center;
        width: 100%;
    }

    /* Profil image - ukuran menyesuaikan saat collapsed */
    .profile-image {
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 9999px;
        border: 2px solid #A7C1A8;
        flex-shrink: 0;
        transition: all 0.3s ease-in-out;
    }

    /* Saat collapsed, foto profil diperbesar */
    #sidebar.is-collapsed .profile-image {
        width: 2.5rem;
        height: 2.5rem;
    }

    /* Container untuk teks profile (nama & role) */
    .profile-info {
        min-width: 0;
        flex: 1;
    }

    /* Logout button container */
    .logout-container {
        flex-shrink: 0;
        transition: opacity 0.2s ease;
    }

    /* Sembunyikan logout container saat collapsed */
    #sidebar.is-collapsed .logout-container {
        display: none;
    }

    /* Profile link - hanya untuk siswa */
    .profile-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex: 1;
        min-width: 0;
        text-decoration: none;
    }

    /* Saat collapsed, profile link diatur agar kontennya rata tengah */
    #sidebar.is-collapsed .profile-link {
        justify-content: center;
        width: 100%;
    }

    /* Hover effect untuk profile link */
    .profile-link:hover .profile-image {
        border-color: #D1D8BE;
    }
</style>

@php
    $user = null;
    $role = null;

    if (auth()->guard('admin')->check()) {
        $user = auth()->guard('admin')->user();
        $role = 'admin';
    } elseif (auth()->guard('siswa')->check()) {
        $user = auth()->guard('siswa')->user();
        $role = 'siswa';
    }
@endphp

<!-- Sidebar -->
<aside id="sidebar" class="flex flex-col">

    <!-- Header -->
    <div class="p-4 flex items-center border-b border-[#D1D8BE]/50" style="min-height: 72px;">
        <div class="flex items-center gap-3 min-w-0">

            <!-- Logo — jadi toggle saat sidebar collapsed -->
            <div id="logo-header">
                <img id="logo-img" src="{{ asset('assets/image/konyol.png') }}" alt="Logo SpeakUp">
                <!-- Overlay icon toggle (muncul saat hover + collapsed) -->
                <div id="logo-toggle-overlay">
                    <img src="{{ asset('assets/icons/button-collapse copy.svg') }}" alt="Buka Sidebar" style="width: 20px; height: 20px;">
                </div>
            </div>

            <div id="sidebar-logo-text" class="sidebar-text">
                <h1 class="font-bold text-[#D1D8BE] text-lg leading-tight">SpeakUp</h1>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="sidebar-content">
        <nav class="space-y-1">
            @if ($role === 'siswa')
                <a href="{{ route('siswa.dashboard') }}"
                    class="nav-link px-3 py-3 rounded-xl gap-3 {{ request()->routeIs('siswa.dashboard') ? 'bg-[#819A91] text-white' : 'text-white hover:bg-[#D1D8BE]/30' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="font-medium sidebar-text">Dashboard</span>
                </a>

                <a href="{{ route('siswa.histori_aspirasi') }}"
                    class="nav-link px-3 py-3 rounded-xl gap-3 {{ request()->routeIs('siswa.histori_aspirasi') ? 'bg-[#819A91] text-white' : 'text-white hover:bg-[#D1D8BE]/30' }}">
                    <i data-lucide="history" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="font-medium sidebar-text">Histori Aspirasi</span>
                </a>

                <a href="{{ route('siswa.tambah_aspirasi') }}"
                    class="nav-link px-3 py-3 rounded-xl gap-3 {{ request()->routeIs('siswa.tambah_aspirasi') ? 'bg-[#819A91] text-white' : 'text-white hover:bg-[#D1D8BE]/30' }}">
                    <i data-lucide="plus-circle" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="font-medium sidebar-text">Buat Aspirasi</span>
                </a>

            @elseif ($role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link px-3 py-3 rounded-xl gap-3 {{ request()->routeIs('admin.dashboard') ? 'bg-[#819A91] text-white' : 'text-white hover:bg-[#D1D8BE]/30' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="font-medium sidebar-text">Dashboard</span>
                </a>

                <a href="{{ route('admin.siswa.index') }}"
                    class="nav-link px-3 py-3 rounded-xl gap-3 {{ request()->routeIs('admin.siswa.*') ? 'bg-[#819A91] text-white' : 'text-white hover:bg-[#D1D8BE]/30' }}">
                    <i data-lucide="users" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="font-medium sidebar-text">Data Siswa</span>
                </a>

                <a href="{{ route('admin.aspirasi.index') }}"
                    class="nav-link px-3 py-3 rounded-xl gap-3 {{ request()->routeIs('admin.aspirasi.*') ? 'bg-[#819A91] text-white' : 'text-white hover:bg-[#D1D8BE]/30' }}">
                    <i data-lucide="inbox" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="font-medium sidebar-text">Daftar Aspirasi</span>
                </a>

                <a href="{{ route('admin.kategori.index') }}"
                    class="nav-link px-3 py-3 rounded-xl gap-3 {{ request()->routeIs('admin.kategori.*') ? 'bg-[#819A91] text-white' : 'text-white hover:bg-[#D1D8BE]/30' }}">
                    <i data-lucide="folder" class="w-5 h-5 flex-shrink-0"></i>
                    <span class="font-medium sidebar-text">Kategori</span>
                </a>
            @endif
        </nav>
    </div>

    <!-- User Profile Footer -->
    <div class="sidebar-footer">
        <div class="footer-content">
            @if ($role === 'siswa')
                <a href="{{ route('siswa.profile') }}" class="profile-link">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? ($user->nama ?? 'User')) }}&background=819A91&color=fff"
                        class="profile-image" alt="Profile">
                    <div class="profile-info sidebar-text">
                        <p class="font-medium text-sm text-white truncate">{{ $user->name ?? ($user->nama ?? 'User') }}</p>
                        <p class="text-xs text-[#D1D8BE] truncate capitalize">{{ $role }}</p>
                    </div>
                </a>
            @else
                <div class="profile-section">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name ?? ($user->nama ?? 'User')) }}&background=819A91&color=fff"
                        class="profile-image" alt="Profile">
                    <div class="profile-info sidebar-text">
                        <p class="font-medium text-sm text-white truncate">{{ $user->name ?? ($user->nama ?? 'User') }}</p>
                        <p class="text-xs text-[#D1D8BE] truncate capitalize">{{ $role }}</p>
                    </div>
                </div>
            @endif

            <div class="logout-container">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Logout">
                        <i data-lucide="log-out" class="w-4 h-4 text-white hover:text-[#D1D8BE] transition-colors"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>

<!-- Toggle Button (hanya muncul saat sidebar TERBUKA, di pinggir kanan sidebar) -->
<button id="toggleButton" aria-label="Tutup Sidebar">
    <img src="{{ asset('assets/icons/button-collapse copy.svg') }}" alt="Toggle Sidebar" style="width: 20px; height: 20px;">
</button>

<script>
    lucide.createIcons();

    const sidebar      = document.getElementById('sidebar');
    const toggleButton = document.getElementById('toggleButton');
    const logoHeader   = document.getElementById('logo-header');

    let isCollapsed = false;

    function updateToggleVisibility() {
        if (window.innerWidth >= 768 && !isCollapsed) {
            toggleButton.style.display = 'flex';
        } else {
            toggleButton.style.display = 'none';
        }
    }

    updateToggleVisibility();
    window.addEventListener('resize', updateToggleVisibility);

    // Collapse sidebar
    function collapseSidebar() {
        isCollapsed = true;
        sidebar.style.width = '68px';
        sidebar.classList.add('is-collapsed');

        document.querySelectorAll('.sidebar-text').forEach(el => el.classList.add('collapsed'));

        const mainContent = document.querySelector('main');
        if (mainContent) mainContent.style.marginLeft = '68px';

        // Sembunyiin toggle button — logo yang jadi toggle
        toggleButton.style.display = 'none';
    }

    // Expand sidebar
    function expandSidebar() {
        isCollapsed = false;
        sidebar.style.width = '240px';
        sidebar.classList.remove('is-collapsed');

        document.querySelectorAll('.sidebar-text').forEach(el => el.classList.remove('collapsed'));

        const mainContent = document.querySelector('main');
        if (mainContent) mainContent.style.marginLeft = '240px';

        // Tampilin toggle button lagi
        if (window.innerWidth >= 768) toggleButton.style.display = 'flex';
    }

    // Toggle button → tutup sidebar
    toggleButton.addEventListener('click', () => {
        collapseSidebar();
    });

    // Logo header → buka sidebar (hanya saat collapsed)
    logoHeader.addEventListener('click', () => {
        if (isCollapsed) expandSidebar();
    });
</script>
