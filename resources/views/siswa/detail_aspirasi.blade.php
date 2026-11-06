@extends('layouts.layout_base')

@section('content')
    {{-- Bagian ini akan menggantikan @yield('content') atau {{ $slot }} di base.blade.php --}}

    <!-- Back Button & ID -->
    <div class="flex items-center justify-between mb-6 fade-in">
        <a href="{{ route('siswa.histori_aspirasi') }}"
            class="px-4 py-2 bg-white text-[#819A91] rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-2 font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
        <div class="flex items-center gap-2">
            <span class="text-sm text-[#819A91]/60">ID:</span>
            <span
                class="px-3 py-1 bg-[#D1D8BE]/30 rounded-lg text-sm font-mono font-semibold text-[#819A91]">#ASP-{{ $aspirasi->id }}</span>
        </div>
    </div>

    <!-- Main Detail Card -->
    <div class="glass-card rounded-3xl shadow-xl border border-[#D1D8BE]/50 overflow-hidden mb-6 fade-in"
        style="animation-delay: 0.1s">

        <!-- Header Card -->
        <div class="p-6 sm:p-8 border-b border-[#D1D8BE]/30">
            <div class="flex flex-wrap items-start justify-between gap-4 mb-4">
                <span
                    class="px-4 py-1.5 bg-[#A7C1A8]/20 text-[#819A91] rounded-full text-xs font-bold tracking-wide uppercase border border-[#A7C1A8]/30">
                    {{ $aspirasi->kategori->nama ?? 'Tanpa Kategori' }}
                </span>
                <div
                    class="flex items-center gap-2 px-4 py-2 rounded-full text-sm font-semibold status-pulse
                @if ($aspirasi->status == 'menunggu') bg-yellow-500 text-white
                @elseif($aspirasi->status == 'diproses') bg-blue-500 text-white
                @elseif($aspirasi->status == 'selesai') bg-green-500 text-white
                @else bg-red-500 text-white @endif">
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    {{ ucfirst($aspirasi->status) }}
                </div>
            </div>

            <h1 class="text-2xl sm:text-3xl font-bold text-[#819A91] mb-3 leading-tight">
                {{ $aspirasi->judul }}
            </h1>

            <div class="flex flex-wrap items-center gap-4 text-sm text-[#819A91]/70">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $aspirasi->lokasi }}</span>
                </div>
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>Dilaporkan {{ $aspirasi->tanggal_kirim->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="p-6 sm:p-8 border-b border-[#D1D8BE]/30">
            <h3 class="text-sm font-bold text-[#819A91] uppercase tracking-wide mb-3">Deskripsi Aspirasi</h3>
            <p class="text-[#819A91]/80 leading-relaxed text-base">
                {{ $aspirasi->deskripsi }}
            </p>
        </div>

        <!-- Photos -->
        <div class="p-6 sm:p-8">
            <h3 class="text-sm font-bold text-[#819A91] uppercase tracking-wide mb-4">Lampiran Foto</h3>
            @if ($aspirasi->fotoPengaduan->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach ($aspirasi->fotoPengaduan as $foto)
                        <div
                            class="aspect-square rounded-2xl overflow-hidden border-2 border-[#D1D8BE] cursor-pointer photo-zoom relative group max-w-[600px]">
                            <img src="{{ $foto->full_url }}" class="w-full h-full object-cover" alt="Foto aspirasi">
                            <div
                                class="absolute inset-0 bg-[#819A91]/0 group-hover:bg-[#819A91]/20 transition-colors flex items-center justify-center">
                                <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                </svg>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 mx-auto rounded-full bg-gray-100 flex items-center justify-center mb-3">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <p class="text-gray-500 text-sm">Tidak ada lampiran foto</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Admin Feedback Card - New Section -->
    @if($aspirasi->riwayatStatus->where('umpan_balik', '!=', null)->count() > 0)
    <div class="glass-card rounded-3xl shadow-lg border border-[#D1D8BE]/50 p-6 sm:p-8 mb-6 fade-in"
        style="animation-delay: 0.15s">
        <h3 class="text-lg font-bold text-[#819A91] mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#A7C1A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                </path>
            </svg>
            Feedback dari Admin
        </h3>

        <div class="space-y-4">
            @foreach($aspirasi->riwayatStatus->where('umpan_balik', '!=', null)->sortByDesc('created_at') as $feedback)
            <div class="bg-[#EEEFE0] rounded-2xl p-5 border border-[#D1D8BE]/50 hover:shadow-md transition-shadow">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-[#819A91] flex items-center justify-center">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <span class="font-semibold text-[#819A91]">{{ $feedback->admin->nama ?? 'Admin' }}</span>
                            <div class="flex items-center gap-2 text-xs text-[#819A91]/60">
                                <span>{{ $feedback->created_at->format('d M Y, H:i') }}</span>
                                <span class="w-1 h-1 rounded-full bg-[#819A91]/30"></span>
                                <span class="px-2 py-0.5 rounded-full text-xs font-medium
                                    @if($feedback->status == 'menunggu') bg-yellow-100 text-yellow-700
                                    @elseif($feedback->status == 'diproses') bg-blue-100 text-blue-700
                                    @elseif($feedback->status == 'selesai') bg-green-100 text-green-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($feedback->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Feedback Message -->
                <div class="ml-10">
                    <p class="text-[#819A91]/90 leading-relaxed text-base">
                        {{ $feedback->umpan_balik }}
                    </p>

                    @if($feedback->keterangan)
                    <div class="mt-3 p-4 bg-white/50 rounded-xl border border-[#D1D8BE]/30">
                        <p class="text-sm font-medium text-[#819A91]/70 mb-1">Keterangan tambahan:</p>
                        <p class="text-[#819A91]/80 text-sm italic">
                            "{{ $feedback->keterangan }}"
                        </p>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Progress Timeline -->
    <div class="glass-card rounded-3xl shadow-lg border border-[#D1D8BE]/50 p-6 sm:p-8 fade-in"
        style="animation-delay: 0.2s">
        <h3 class="text-lg font-bold text-[#819A91] mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-[#A7C1A8]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                </path>
            </svg>
            Riwayat Progress
        </h3>

        <div class="relative space-y-8">
            <!-- Timeline Line -->
            <div class="timeline-line"></div>

            @if ($aspirasi->status == 'selesai' && $aspirasi->tanggal_selesai)
                <!-- Item 1: Selesai -->
                <div class="relative flex gap-4">
                    <div
                        class="relative z-10 w-10 h-10 rounded-full bg-green-500 border-4 border-[#EEEFE0] flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-[#EEEFE0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 pt-1">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-bold text-[#819A91]">Aspirasi Selesai</h4>
                            <span
                                class="text-xs text-[#819A91]/60">{{ $aspirasi->tanggal_selesai->format('d M Y, H:i') }}</span>
                        </div>
                        <p class="text-sm text-[#819A91]/80 mb-2">Aspirasi telah selesai ditangani.</p>
                        <div
                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-semibold">
                            <span class="w-1.5 h-1.5 bg-green-700 rounded-full"></span>
                            Selesai
                        </div>
                    </div>
                </div>
            @endif

            @if ($aspirasi->status == 'diproses' || $aspirasi->status == 'selesai')
                <!-- Item 2: Diproses -->
                <div class="relative flex gap-4">
                    <div
                        class="relative z-10 w-10 h-10 rounded-full bg-blue-500 border-4 border-[#EEEFE0] flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5 text-[#EEEFE0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 pt-1">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-bold text-[#819A91]">Status Diproses</h4>
                            @php
                                $diprosesHistory = $aspirasi->riwayatStatus->where('status', 'diproses')->first();
                            @endphp
                            <span class="text-xs text-[#819A91]/60">
                                {{ $diprosesHistory ? $diprosesHistory->created_at->format('d M Y, H:i') : $aspirasi->updated_at->format('d M Y, H:i') }}
                            </span>
                        </div>
                        <p class="text-sm text-[#819A91]/80 mb-2">Aspirasi sedang dalam proses penanganan oleh tim terkait.
                        </p>
                        <div
                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">
                            <span class="w-1.5 h-1.5 bg-blue-700 rounded-full"></span>
                            Diproses
                        </div>
                    </div>
                </div>
            @endif

            <!-- Item 3: Submitted -->
            <div class="relative flex gap-4">
                <div
                    class="relative z-10 w-10 h-10 rounded-full bg-[#819A91] border-4 border-[#EEEFE0] flex items-center justify-center shadow-md">
                    <svg class="w-5 h-5 text-[#EEEFE0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1 pt-1">
                    <div class="flex items-center justify-between mb-1">
                        <h4 class="font-bold text-[#819A91]">Aspirasi Diajukan</h4>
                        <span class="text-xs text-[#819A91]/60">{{ $aspirasi->tanggal_kirim->format('d M Y') }},
                            {{ $aspirasi->created_at->format('H:i') }}</span>
                    </div>
                    <p class="text-sm text-[#819A91]/80">Laporan berhasil dikirim dan masuk ke dalam sistem.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tambahkan CSS tambahan jika base.blade.php tidak memilikinya --}}
    @push('styles')
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }

            .glass-card {
                background: rgba(238, 239, 224, 0.95);
                backdrop-filter: blur(20px);
            }

            /* Timeline line */
            .timeline-line {
                position: absolute;
                left: 20px;
                top: 40px;
                bottom: 0;
                width: 2px;
                background: linear-gradient(to bottom, #A7C1A8, #D1D8BE);
            }

            /* Status badge pulse */
            @keyframes pulse-soft {

                0%,
                100% {
                    box-shadow: 0 0 0 0 rgba(129, 154, 145, 0.4);
                }

                50% {
                    box-shadow: 0 0 0 8px rgba(129, 154, 145, 0);
                }
            }

            .status-pulse {
                animation: pulse-soft 2s infinite;
            }

            /* Photo hover zoom */
            .photo-zoom {
                transition: transform 0.3s ease;
            }

            .photo-zoom:hover {
                transform: scale(1.05);
            }

            /* Smooth fade */
            .fade-in {
                animation: fadeIn 0.5s ease-out forwards;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush

    {{-- Tambahkan JavaScript jika diperlukan --}}
    @section('scripts')
        <script>
            // Kamu bisa menambahkan JavaScript interaktif di sini jika diperlukan
            console.log('Detail aspirasi loaded');
        </script>
    @endsection
@endsection
