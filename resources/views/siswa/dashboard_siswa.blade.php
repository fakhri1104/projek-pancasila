@extends('layouts.layout_base')

@section('content')
    <div class="p-6 md:p-8 max-w-7xl mx-auto">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-[#819A91]">Dashboard Aspirasi</h1>
            <p class="text-gray-600 mt-2">Selamat datang di sistem aspirasi sekolah</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="glass-panel rounded-2xl p-5 hover-card border border-[#D1D8BE]">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-[#819A91]/10 flex items-center justify-center">
                        <i data-lucide="folder" class="w-5 h-5 text-[#819A91]"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Total</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalAspirasi }}</h3>
                <p class="text-xs text-gray-500 mt-1">Total Aspirasi</p>
            </div>

            <div class="glass-panel rounded-2xl p-5 hover-card border border-[#D1D8BE]">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i data-lucide="clock" class="w-5 h-5 text-yellow-600"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Menunggu</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $menunggu }}</h3>
                <p class="text-xs text-gray-500 mt-1">Belum diproses</p>
            </div>

            <div class="glass-panel rounded-2xl p-5 hover-card border border-[#D1D8BE]">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i data-lucide="loader" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Proses</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $diproses }}</h3>
                <p class="text-xs text-gray-500 mt-1">Sedang dikerjakan</p>
            </div>

            <div class="glass-panel rounded-2xl p-5 hover-card border border-[#D1D8BE]">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-[#A7C1A8]/20 flex items-center justify-center">
                        <i data-lucide="check-circle" class="w-5 h-5 text-[#819A91]"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Selesai</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $selesai }}</h3>
                <p class="text-xs text-gray-500 mt-1">Telah diselesaikan</p>
            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="glass-panel rounded-2xl border border-[#D1D8BE] overflow-hidden mb-8">
            <div class="p-6 border-b border-[#D1D8BE]/50 flex items-center justify-between">
                <h3 class="font-bold text-lg text-gray-800">Aspirasi Terbaru</h3>
                <a href="{{ route('siswa.histori_aspirasi') }}"
                    class="text-sm text-[#819A91] hover:text-[#6b8279] font-medium flex items-center gap-1">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            @if ($recentAspirasi->count() > 0)
                <div class="divide-y divide-[#D1D8BE]/30">
                    @foreach ($recentAspirasi as $aspirasi)
                        <div class="p-6 hover:bg-[#D1D8BE]/10 transition-colors cursor-pointer"
                            onclick="window.location='{{ route('aspirasi.show', $aspirasi->id) }}'">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-2">
                                        <h4 class="font-semibold text-gray-800 truncate">{{ $aspirasi->judul }}</h4>
                                        <span
                                            class="px-3 py-1 text-xs font-medium rounded-full whitespace-nowrap
                                            @if ($aspirasi->status == 'menunggu') bg-yellow-100 text-yellow-700
                                            @elseif($aspirasi->status == 'diproses') bg-blue-100 text-blue-700
                                            @elseif($aspirasi->status == 'selesai') bg-green-100 text-green-700
                                            @else bg-red-100 text-red-700 @endif">
                                            {{ ucfirst($aspirasi->status) }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-2 line-clamp-2">{{ $aspirasi->deskripsi }}</p>
                                    <div class="flex items-center gap-4 text-xs text-gray-500">
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="tag" class="w-3 h-3"></i>
                                            {{ $aspirasi->kategori->nama ?? 'Tanpa Kategori' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="map-pin" class="w-3 h-3"></i>
                                            {{ $aspirasi->lokasi }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i data-lucide="calendar" class="w-3 h-3"></i>
                                            {{ $aspirasi->tanggal_kirim->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                                @if ($aspirasi->fotoPengaduan->count() > 0)
                                    <div class="w-40 h-40 rounded-lg overflow-hidden flex-shrink-0">
                                        <img src="{{ $aspirasi->fotoPengaduan->first()->full_url }}" alt="Foto aspirasi"
                                            class="w-full h-full object-cover hover:opacity-90 transition-opacity cursor-pointer"
                                            onclick="window.open('{{ $aspirasi->fotoPengaduan->first()->full_url }}', '_blank')">
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-4">
                        <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
                    </div>
                    <h4 class="font-semibold text-gray-700 mb-2">Belum ada aspirasi</h4>
                    <p class="text-gray-500 text-sm mb-6">Mulai dengan membuat aspirasi pertama Anda</p>
                    <a href="{{ route('siswa.tambah_aspirasi') }}"
                        class="inline-flex items-center gap-2 bg-[#819A91] hover:bg-[#6b8279] text-white px-6 py-3 rounded-xl shadow-lg shadow-[#819A91]/20 transition-all font-medium">
                        <i data-lucide="plus" class="w-5 h-5"></i>
                        Buat Aspirasi Baru
                    </a>
                </div>
            @endif
        </div>

        <!-- Progress Timeline Section -->
        <div id="timelineSection" class="hidden glass-panel rounded-2xl border border-[#D1D8BE] p-6 md:p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-bold text-xl text-gray-800">Progres Perbaikan</h3>
                    <p class="text-sm text-gray-500 mt-1">Detail aspirasi</p>
                </div>
                <button onclick="hideTimeline()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <div class="relative pl-8 space-y-8">
                <div class="absolute left-3 top-2 bottom-2 w-0.5 timeline-line rounded-full"></div>

                <div class="relative">
                    <div class="absolute -left-8 mt-1.5">
                        <div
                            class="w-6 h-6 rounded-full bg-[#819A91] border-4 border-[#D1D8BE] flex items-center justify-center">
                            <i data-lucide="check" class="w-3 h-3 text-white"></i>
                        </div>
                    </div>
                    <div class="bg-white/50 rounded-xl p-4 border border-[#D1D8BE]/50">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-gray-800">Aspirasi Diterima</h4>
                            <span class="text-xs text-gray-500">-</span>
                        </div>
                        <p class="text-sm text-gray-600">Sistem menerima laporan dan diteruskan ke admin sarana.</p>
                    </div>
                </div>

                <div class="relative opacity-60">
                    <div class="absolute -left-8 mt-1.5">
                        <div class="w-6 h-6 rounded-full bg-gray-300 border-4 border-[#D1D8BE]"></div>
                    </div>
                    <div class="bg-white/30 rounded-xl p-4 border border-[#D1D8BE]/30">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-gray-600">Dalam Pengecekan</h4>
                            <span class="text-xs text-gray-400">Menunggu</span>
                        </div>
                        <p class="text-sm text-gray-500">Petugas sarana akan melakukan pengecekan di lokasi.</p>
                    </div>
                </div>

                <div class="relative opacity-60">
                    <div class="absolute -left-8 mt-1.5">
                        <div class="w-6 h-6 rounded-full bg-gray-300 border-4 border-[#D1D8BE]"></div>
                    </div>
                    <div class="bg-white/30 rounded-xl p-4 border border-[#D1D8BE]/30">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-semibold text-gray-600">Perbaikan Selesai</h4>
                            <span class="text-xs text-gray-400">Menunggu</span>
                        </div>
                        <p class="text-sm text-gray-500">Menunggu konfirmasi penyelesaian dari petugas.</p>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @section('scripts')
        <script>
            // function showDetail() {
            //     const timeline = document.getElementById('timelineSection');
            //     timeline.classList.remove('hidden');
            //     timeline.scrollIntoView({
            //         behavior: 'smooth',
            //         block: 'center'
            //     });
            // }

            // function hideTimeline() {
            //     document.getElementById('timelineSection').classList.add('hidden');
            // }

            // function openModal() {
            //     // Fungsi untuk membuka modal buat aspirasi baru
            //     alert('Modal buat aspirasi baru akan ditampilkan di sini');
            // }
        </script>
    @endsection
