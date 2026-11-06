@extends('layouts.layout_base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-[#f8faf8] via-white to-[#e8f0e8] p-4 md:p-8">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- Hero Header dengan Pattern -->
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#819A91] to-[#A7C1A8] p-8 md:p-12 text-white shadow-2xl">
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                        <circle cx="1" cy="1" r="1" fill="currentColor"/>
                    </pattern>
                    <rect width="100" height="100" fill="url(#grid)"/>
                </svg>
            </div>
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-20 -bottom-20 w-48 h-48 bg-[#D1D8BE]/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div class="space-y-2">
                    <div class="flex items-center gap-2 text-[#D1D8BE] text-sm font-medium tracking-wider uppercase">
                        <i data-lucide="history" class="w-4 h-4"></i>
                        Riwayat Aktivitas
                    </div>
                    <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                        Histori <span class="text-[#D1D8BE]">Aspirasi</span>
                    </h1>
                    <p class="text-white/80 text-lg max-w-xl">
                        Pantau perkembangan setiap aspirasi yang telah kamu sampaikan dalam satu dashboard interaktif
                    </p>
                </div>

                <a href="{{ route('siswa.tambah_aspirasi') }}"
                   class="group relative px-8 py-4 bg-white text-[#819A91] rounded-2xl font-bold shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#D1D8BE] to-[#A7C1A8] opacity-0 group-hover:opacity-10 transition-opacity"></div>
                    <span class="relative flex items-center gap-3">
                        <span class="flex items-center justify-center w-8 h-8 bg-[#819A91] text-white rounded-lg group-hover:rotate-90 transition-transform duration-300">
                            <i data-lucide="plus" class="w-5 h-5"></i>
                        </span>
                        <span>Buat Aspirasi Baru</span>
                    </span>
                </a>
            </div>
        </div>

        <!-- Stats Cards dengan Animasi -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            @php
                $stats = [
                    ['label' => 'Total Aspirasi', 'value' => $aspirasis->count(), 'icon' => 'layers', 'color' => 'from-[#819A91] to-[#6b8580]', 'bg' => 'bg-[#819A91]/10'],
                    ['label' => 'Menunggu', 'value' => $aspirasis->where('status', 'menunggu')->count(), 'icon' => 'clock', 'color' => 'from-amber-400 to-orange-500', 'bg' => 'bg-amber-100'],
                    ['label' => 'Diproses', 'value' => $aspirasis->where('status', 'diproses')->count(), 'icon' => 'refresh-cw', 'color' => 'from-blue-400 to-indigo-500', 'bg' => 'bg-blue-100'],
                    ['label' => 'Selesai', 'value' => $aspirasis->where('status', 'selesai')->count(), 'icon' => 'check-circle', 'color' => 'from-emerald-400 to-teal-500', 'bg' => 'bg-emerald-100'],
                ];
            @endphp

            @foreach($stats as $index => $stat)
            <div class="group relative bg-white rounded-2xl p-6 shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-[#D1D8BE]/50 overflow-hidden" style="animation-delay: {{ $index * 100 }}ms">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br {{ $stat['color'] }} opacity-5 rounded-full -mr-16 -mt-16 group-hover:scale-150 transition-transform duration-500"></div>

                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 rounded-xl {{ $stat['bg'] }} text-[#819A91] group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="{{ $stat['icon'] }}" class="w-6 h-6"></i>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">{{ $stat['label'] }}</span>
                    </div>

                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-bold text-gray-800 counter" data-target="{{ $stat['value'] }}">0</span>
                        <span class="text-sm text-gray-500">aspirasi</span>
                    </div>

                    <div class="mt-3 h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r {{ $stat['color'] }} rounded-full transition-all duration-1000 ease-out" style="width: 0%" data-width="{{ $aspirasis->count() > 0 ? ($stat['value'] / $aspirasis->count() * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Filter Section yang lebih compact -->
        <div class="bg-white rounded-2xl shadow-lg border border-[#D1D8BE]/30 overflow-hidden">
            <div class="p-6 border-b border-[#D1D8BE]/20">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">

                    <!-- Status Filter Pills -->
                    <div class="flex flex-wrap gap-2">
                        @php
                            $filters = [
                                ['key' => null, 'label' => 'Semua', 'color' => 'gray'],
                                ['key' => 'menunggu', 'label' => 'Menunggu', 'color' => 'amber'],
                                ['key' => 'diproses', 'label' => 'Diproses', 'color' => 'blue'],
                                ['key' => 'selesai', 'label' => 'Selesai', 'color' => 'emerald'],
                                ['key' => 'ditolak', 'label' => 'Ditolak', 'color' => 'red'],
                            ];
                        @endphp

                        @foreach($filters as $filter)
                        <a href="{{ $filter['key'] ? route('siswa.histori_aspirasi', array_merge(request()->except('status'), ['status' => $filter['key']])) : route('siswa.histori_aspirasi') }}"
                           class="relative px-4 py-2 rounded-full text-sm font-semibold transition-all duration-300
                           {{ !request('status') && !$filter['key'] || request('status') == $filter['key']
                              ? "bg-{$filter['color']}-500 text-white shadow-lg scale-105"
                              : "bg-gray-100 text-gray-600 hover:bg-{$filter['color']}-50 hover:text-{$filter['color']}-600" }}">
                            {{ $filter['label'] }}
                            @if(!request('status') && !$filter['key'] || request('status') == $filter['key'])
                            <span class="absolute inset-0 rounded-full ring-2 ring-offset-2 ring-{{ $filter['color'] }}-500 animate-pulse"></span>
                            @endif
                        </a>
                        @endforeach
                    </div>

                    <!-- Search & Sort -->
                    <form method="GET" action="{{ route('siswa.histori_aspirasi') }}" class="flex gap-3 w-full lg:w-auto">
                        @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        @endif

                        <div class="relative flex-1 lg:w-64 group">
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Cari aspirasi..."
                                   class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border-2 border-transparent focus:bg-white focus:border-[#819A91] rounded-xl transition-all outline-none">
                            <i data-lucide="search" class="absolute left-3 top-3 w-5 h-5 text-gray-400 group-focus-within:text-[#819A91] transition-colors"></i>
                        </div>

                        <div class="relative">
                            <select name="sort" onchange="this.form.submit()"
                                    class="appearance-none px-4 py-2.5 pr-10 bg-gray-50 border-2 border-transparent focus:bg-white focus:border-[#819A91] rounded-xl cursor-pointer outline-none transition-all">
                                <option value="terbaru" {{ request('sort') == 'terbaru' || !request('sort') ? 'selected' : '' }}>Terbaru Dulu</option>
                                <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama Dulu</option>
                            </select>
                            <i data-lucide="chevron-down" class="absolute right-3 top-3 w-4 h-4 text-gray-400 pointer-events-none"></i>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Active Filters -->
            @if(request('search') || request('status'))
            <div class="px-6 py-3 bg-[#D1D8BE]/10 flex items-center gap-2 flex-wrap">
                <span class="text-sm text-gray-500">Filter aktif:</span>
                @if(request('status'))
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-white border border-[#819A91] text-[#819A91] rounded-full text-sm font-medium shadow-sm">
                    Status: {{ ucfirst(request('status')) }}
                    <a href="{{ route('siswa.histori_aspirasi', request()->except('status')) }}" class="ml-1 hover:text-red-500 transition-colors">
                        <i data-lucide="x" class="w-3 h-3"></i>
                    </a>
                </span>
                @endif
                @if(request('search'))
                <span class="inline-flex items-center gap-1 px-3 py-1 bg-white border border-[#819A91] text-[#819A91] rounded-full text-sm font-medium shadow-sm">
                    "{{ request('search') }}"
                    <a href="{{ route('siswa.histori_aspirasi', request()->except('search')) }}" class="ml-1 hover:text-red-500 transition-colors">
                        <i data-lucide="x" class="w-3 h-3"></i>
                    </a>
                </span>
                @endif
                <a href="{{ route('siswa.histori_aspirasi') }}" class="text-sm text-[#819A91] hover:text-[#6b8580] font-medium ml-auto flex items-center gap-1">
                    <i data-lucide="refresh-cw" class="w-3 h-3"></i> Reset
                </a>
            </div>
            @endif
        </div>

        <!-- Content Area -->
        @if($aspirasis->count() > 0)
        <div class="space-y-6">
            <!-- Results Counter -->
            <div class="flex items-center justify-between px-2">
                <p class="text-gray-600">
                    Menampilkan <span class="font-bold text-[#819A91] text-lg">{{ $aspirasis->count() }}</span> aspirasi
                </p>
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <i data-lucide="layout-grid" class="w-4 h-4"></i>
                    <span>Timeline View</span>
                </div>
            </div>

            <!-- Timeline Container -->
            <div class="relative">
                <!-- Timeline Line -->
                <div class="absolute left-8 top-0 bottom-0 w-0.5 bg-gradient-to-b from-[#819A91] via-[#A7C1A8] to-[#D1D8BE] hidden md:block"></div>

                <!-- Aspirasi Items -->
                <div class="space-y-6">
                    @foreach($aspirasis as $index => $aspirasi)
                    @php
                        $statusColors = [
                            'menunggu' => ['bg' => 'bg-amber-500', 'light' => 'bg-amber-50', 'border' => 'border-amber-200', 'text' => 'text-amber-700'],
                            'diproses' => ['bg' => 'bg-blue-500', 'light' => 'bg-blue-50', 'border' => 'border-blue-200', 'text' => 'text-blue-700'],
                            'selesai' => ['bg' => 'bg-emerald-500', 'light' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-700'],
                            'ditolak' => ['bg' => 'bg-red-500', 'light' => 'bg-red-50', 'border' => 'border-red-200', 'text' => 'text-red-700'],
                        ];
                        $colors = $statusColors[$aspirasi->status] ?? $statusColors['menunggu'];
                    @endphp

                    <div class="relative group perspective-1000" style="animation: slideIn 0.5s ease-out {{ $index * 0.1 }}s both">
                        <!-- Timeline Dot (Desktop) -->
                        <div class="absolute left-6 top-8 w-4 h-4 {{ $colors['bg'] }} rounded-full border-4 border-white shadow-lg hidden md:block z-10 group-hover:scale-125 transition-transform"></div>

                        <!-- Card -->
                        <div class="md:ml-16 bg-white rounded-2xl shadow-md hover:shadow-2xl transition-all duration-300 border-l-4 {{ $colors['bg'] }} overflow-hidden group-hover:-translate-y-1">

                            <!-- Card Header -->
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-4">
                                    <div class="flex items-center gap-3 flex-wrap">
                                        <span class="px-4 py-1.5 {{ $colors['light'] }} {{ $colors['text'] }} rounded-full text-xs font-bold uppercase tracking-wider border {{ $colors['border'] }} flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 {{ $colors['bg'] }} rounded-full animate-pulse"></span>
                                            {{ ucfirst($aspirasi->status) }}
                                        </span>

                                        <div class="flex items-center gap-2 text-sm text-gray-500 bg-gray-50 px-3 py-1.5 rounded-full">
                                            <i data-lucide="calendar" class="w-4 h-4 text-[#819A91]"></i>
                                            <span class="font-medium">{{ $aspirasi->tanggal_kirim->format('d M Y') }}</span>
                                            <span class="text-gray-300">|</span>
                                            <span class="text-xs">{{ $aspirasi->tanggal_kirim->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <a href="{{ route('aspirasi.show', $aspirasi->id) }}"
                                       class="flex items-center gap-2 px-4 py-2 bg-gray-50 hover:bg-[#819A91] text-gray-600 hover:text-white rounded-xl transition-all duration-300 group/btn">
                                        <span class="text-sm font-medium">Detail</span>
                                        <i data-lucide="arrow-right" class="w-4 h-4 group-hover/btn:translate-x-1 transition-transform"></i>
                                    </a>
                                </div>

                                <!-- Content -->
                                <a href="{{ route('aspirasi.show', $aspirasi->id) }}" class="block group/link">
                                    <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover/link:text-[#819A91] transition-colors {{ $aspirasi->status == 'ditolak' ? 'line-through text-gray-400' : '' }}">
                                        {{ $aspirasi->judul }}
                                    </h3>
                                    <p class="text-gray-600 leading-relaxed line-clamp-2 mb-4 {{ $aspirasi->status == 'ditolak' ? 'text-gray-400' : '' }}">
                                        {{ $aspirasi->deskripsi }}
                                    </p>
                                </a>

                                <!-- Meta Tags -->
                                <div class="flex flex-wrap items-center gap-3 mb-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#D1D8BE]/30 text-[#5C6B65] rounded-lg text-xs font-semibold">
                                        <i data-lucide="tag" class="w-3.5 h-3.5"></i>
                                        {{ $aspirasi->kategori->nama ?? 'Umum' }}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-[#D1D8BE]/30 text-[#5C6B65] rounded-lg text-xs font-semibold">
                                        <i data-lucide="map-pin" class="w-3.5 h-3.5"></i>
                                        {{ $aspirasi->lokasi }}
                                    </span>
                                    @if($aspirasi->fotoPengaduan->count() > 0)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-semibold border border-blue-100">
                                        <i data-lucide="paperclip" class="w-3.5 h-3.5"></i>
                                        {{ $aspirasi->fotoPengaduan->count() }} Lampiran
                                    </span>
                                    @endif
                                </div>

                                <!-- Status Message -->
                                @if($aspirasi->status == 'menunggu')
                                <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl border border-amber-100">
                                    <div class="w-10 h-10 bg-amber-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="clock" class="w-5 h-5 text-amber-600 animate-pulse"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-amber-800">Menunggu Verifikasi Admin</p>
                                        <p class="text-xs text-amber-600">Estimasi proses 1-2 hari kerja</p>
                                    </div>
                                </div>

                                @elseif($aspirasi->status == 'diproses')
                                <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="loader" class="w-5 h-5 text-blue-600 animate-spin"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-blue-800">Sedang Dalam Penanganan</p>
                                        <div class="mt-2 h-1.5 bg-blue-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-blue-500 rounded-full animate-progress" style="width: 60%"></div>
                                        </div>
                                    </div>
                                </div>

                                @elseif($aspirasi->status == 'selesai')
                                <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl border border-emerald-100">
                                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-emerald-800">Aspirasi Telah Selesai</p>
                                        <p class="text-xs text-emerald-600">Terima kasih atas partisipasimu</p>
                                    </div>
                                </div>
                                @endif
                            </div>

                            <!-- Hover Action Bar -->
                            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <span class="text-xs text-gray-500">ID: #{{ $aspirasi->id }}</span>
                                <div class="flex gap-2">
                                    <button class="text-xs text-[#819A91] hover:text-[#6b8580] font-medium flex items-center gap-1">
                                        <i data-lucide="share-2" class="w-3 h-3"></i> Bagikan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        @else
        <!-- Empty State yang lebih menarik -->
        <div class="relative overflow-hidden bg-white rounded-3xl shadow-xl border border-[#D1D8BE]/30 p-12 text-center">
            <div class="absolute inset-0 opacity-5">
                <div class="absolute inset-0" style="background-image: radial-gradient(#819A91 1px, transparent 1px); background-size: 20px 20px;"></div>
            </div>

            <div class="relative z-10 max-w-md mx-auto">
                <div class="relative w-32 h-32 mx-auto mb-6">
                    <div class="absolute inset-0 bg-[#D1D8BE] rounded-full animate-ping opacity-20"></div>
                    <div class="relative w-32 h-32 bg-gradient-to-br from-[#D1D8BE] to-[#A7C1A8] rounded-full flex items-center justify-center shadow-xl">
                        <i data-lucide="{{ request('search') || request('status') ? 'search-x' : 'inbox' }}" class="w-16 h-16 text-white"></i>
                    </div>
                </div>

                @if(request('search') || request('status'))
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Tidak Ada Hasil</h3>
                    <p class="text-gray-500 mb-8 leading-relaxed">
                        Tidak ditemukan aspirasi yang sesuai dengan filter yang kamu pilih. Coba ubah kata kunci atau reset filter.
                    </p>
                    <a href="{{ route('siswa.histori_aspirasi') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 bg-[#819A91] text-white rounded-xl font-semibold hover:bg-[#6b8580] transition-all shadow-lg hover:shadow-xl">
                        <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                        Lihat Semua Aspirasi
                    </a>
                @else
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Aspirasi</h3>
                    <p class="text-gray-500 mb-8 leading-relaxed">
                        Kamu belum pernah mengirimkan aspirasi. Yuk, jadi bagian dari perubahan dengan menyampaikan ide dan masukanmu!
                    </p>
                    <a href="{{ route('siswa.tambah_aspirasi') }}"
                       class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-[#819A91] to-[#A7C1A8] text-white rounded-xl font-bold hover:shadow-xl transition-all transform hover:-translate-y-1">
                        <i data-lucide="plus-circle" class="w-5 h-5"></i>
                        Buat Aspirasi Pertama
                    </a>
                @endif
            </div>
        </div>
        @endif

    </div>
</div>

<style>
@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes progress {
    0% { width: 0%; }
    100% { width: 60%; }
}

.animate-progress {
    animation: progress 1.5s ease-out forwards;
}

.perspective-1000 {
    perspective: 1000px;
}

/* Custom scrollbar */
::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}
::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}
::-webkit-scrollbar-thumb {
    background: #819A91;
    border-radius: 4px;
}
::-webkit-scrollbar-thumb:hover {
    background: #6b8580;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate counters
    const counters = document.querySelectorAll('.counter');
    counters.forEach(counter => {
        const target = parseInt(counter.getAttribute('data-target'));
        const duration = 1000;
        const step = target / (duration / 16);
        let current = 0;

        const updateCounter = () => {
            current += step;
            if (current < target) {
                counter.textContent = Math.floor(current);
                requestAnimationFrame(updateCounter);
            } else {
                counter.textContent = target;
            }
        };

        // Start animation when element is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    updateCounter();
                    observer.unobserve(entry.target);
                }
            });
        });
        observer.observe(counter);
    });

    // Animate progress bars
    const progressBars = document.querySelectorAll('[data-width]');
    setTimeout(() => {
        progressBars.forEach(bar => {
            bar.style.width = bar.getAttribute('data-width');
        });
    }, 500);

    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>
@endsection
