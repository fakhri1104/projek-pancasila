@extends('layouts.auth_layout')

@section('title', 'Login Aspirasi Siswa')

@section('content')

    <!-- Background Blob -->
    <div class="blob bg-[#A7C1A8] w-96 h-96 rounded-full -top-20 -left-20"></div>
    <div class="blob bg-[#D1D8BE] w-80 h-80 rounded-full bottom-0 right-0 translate-x-1/3 translate-y-1/3"></div>
    <div class="blob bg-[#819A91] w-64 h-64 rounded-full top-1/2 left-1/3 opacity-40"></div>

    <div class="relative z-10 h-full w-full flex items-center justify-center p-4 lg:p-8">

        <div
            class="w-full max-w-6xl h-[90vh] lg:h-[85vh] glass-effect rounded-3xl shadow-2xl overflow-hidden flex flex-col lg:flex-row">

            {{-- LEFT SIDE --}}
            <div class="lg:w-1/2 w-full bg-[#A7C1A8] p-8 lg:p-12 flex flex-col justify-between relative overflow-hidden">

                <div class="absolute inset-0 opacity-10">
                    <svg class="w-full h-full">
                        <defs>
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <circle cx="1" cy="1" r="1" fill="#EEEFE0" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                <div class="relative z-10 p-6">
                    <!-- Header Logo -->
                    <div class="flex items-center gap-3 mb-6">
                        <!-- Container lebih gede, shadow kayak Figma -->
                        <div class="w-[90px] h-[80px] rounded-xl bg-[#EEEFE0] flex items-center justify-center shadow-lg">
                            <img src="{{ asset('assets/image/konyol.png') }}"
                                class="w-full h-full object-contain scale-120"" alt="Logo SpeakUp">
                        </div>
                        <div>
                            <h1 class="font-bold text-[#EEEFE0] text-xl leading-tight tracking-wide">SPEAKUP</h1>
                        </div>
                    </div>

                    <!-- Content -->
                    <h2 class="text-lg font-bold text-[#D1D8BE]/70 mb-1 tracking-wider uppercase">
                        Aspirasi<span class="text-[#D1D8BE]">Siswa</span>
                    </h2>

                    <h1 class="text-4xl font-extrabold text-[#EEEFE0] mb-4 leading-[1.1]">
                        Suara Siswa,<br>
                        <span class="text-[#D1D8BE]">Aspirasi Nyata</span>
                    </h1>

                    <p class="text-[#EEEFE0]/80 text-base leading-relaxed max-w-md">
                        Platform pengaduan dan aspirasi untuk membangun lingkungan sekolah yang lebih baik. Setiap suara
                        counts, setiap aspirasi matters.
                    </p>
                </div>

                {{-- <p class="text-[#EEEFE0]/80 text-sm">
                    Bergabung dengan 1,200+ siswa aktif
                </p> --}}

            </div>

            {{-- RIGHT SIDE --}}
            <div class="lg:w-1/2 w-full bg-[#EEEFE0] p-8 lg:p-12 flex flex-col justify-center">

                {{-- Tab Switch --}}
                <div class="flex p-1 bg-[#D1D8BE]/50 rounded-2xl mb-8 w-full max-w-md mx-auto">
                    <button onclick="switchTab('siswa')" id="tab-siswa"
                        class="flex-1 py-3 px-6 rounded-xl text-sm font-semibold bg-[#819A91] text-[#EEEFE0]">
                        Siswa
                    </button>

                    <button onclick="switchTab('admin')" id="tab-admin"
                        class="flex-1 py-3 px-6 rounded-xl text-sm font-semibold text-[#819A91]">
                        Administrator
                    </button>
                </div>

                <div class="w-full max-w-md mx-auto">

                    {{-- FORM SISWA --}}
                    <div id="form-siswa">

                        <h3 class="text-2xl font-bold text-[#819A91] mb-0">Login Siswa</h3>
                        <p class="text-sm font-light text-[#819A91] mb-6">
                            Masukkan NISN dan Password untuk mengirim aspirasi
                        </p>

                        {{-- Error Alert --}}
                        @if ($errors->has('nisn') && session('login_role') === 'siswa')
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold">Login Gagal</p>
                                    <p class="text-sm">{{ $errors->first('nisn') }}</p>
                                </div>
                            </div>
                        @endif

                        <form method="POST" action="/login-siswa" class="space-y-5">
                            @csrf

                            <input type="text" placeholder="NISN" name="nisn"
                                class="w-full px-5 py-4 bg-[#D1D8BE]/30 border-2 border-[#D1D8BE] rounded-xl focus:border-[#819A91] focus:outline-none transition-colors"
                                value="{{ old('nisn') }}">

                            <input type="password" placeholder="Password" name="password"
                                class="w-full px-5 py-4 bg-[#D1D8BE]/30 border-2 border-[#D1D8BE] rounded-xl focus:border-[#819A91] focus:outline-none transition-colors">

                            <button class="w-full py-4 bg-[#819A91] text-[#EEEFE0] font-bold rounded-xl hover:bg-[#6b8279] transition-colors">
                                Masuk sebagai Siswa
                            </button>

                        </form>

                    </div>

                    {{-- FORM ADMIN --}}
                    <div id="form-admin" class="hidden">

                        <h3 class="text-2xl font-bold text-[#819A91] mb-0">Login Admin</h3>
                        <p class="text-sm font-light text-[#819A91] mb-6">
                            Akses dashboard untuk mengelola aspirasi
                        </p>

                        {{-- Error Alert --}}
                        @if ($errors->has('email') && session('login_role') === 'admin')
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-xl flex items-start gap-3">
                                <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold">Login Gagal</p>
                                    <p class="text-sm">{{ $errors->first('email') }}</p>
                                </div>
                            </div>
                        @endif

                        <form class="space-y-5" method="POST" action="/login-admin">
                            @csrf

                            <input type="email" placeholder="Email" name="email"
                                class="w-full px-5 py-4 bg-[#D1D8BE]/30 border-2 border-[#D1D8BE] rounded-xl focus:border-[#819A91] focus:outline-none transition-colors"
                                value="{{ old('email') }}" required>

                            <input type="password" placeholder="Password" name="password"
                                class="w-full px-5 py-4 bg-[#D1D8BE]/30 border-2 border-[#D1D8BE] rounded-xl focus:border-[#819A91] focus:outline-none transition-colors" required>

                            <button class="w-full py-4 bg-[#A7C1A8] text-[#EEEFE0] font-bold rounded-xl hover:bg-[#8fa998] transition-colors">
                                Masuk sebagai Admin
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection


@section('scripts')
    <script>
        function switchTab(role) {
            const tabSiswa = document.getElementById('tab-siswa');
            const tabAdmin = document.getElementById('tab-admin');
            const formSiswa = document.getElementById('form-siswa');
            const formAdmin = document.getElementById('form-admin');

            // Reset semua tab
            [tabSiswa, tabAdmin].forEach(tab => {
                tab.classList.remove('bg-[#819A91]', 'text-[#EEEFE0]');
                tab.classList.add('text-[#819A91]');
            });

            // Reset semua form
            [formSiswa, formAdmin].forEach(form => {
                form.classList.add('hidden');
            });

            if (role === 'siswa') {
                // Aktifkan tab siswa
                tabSiswa.classList.add('bg-[#819A91]', 'text-[#EEEFE0]');
                tabSiswa.classList.remove('text-[#819A91]');
                formSiswa.classList.remove('hidden');
            } else {
                // Aktifkan tab admin
                tabAdmin.classList.add('bg-[#819A91]', 'text-[#EEEFE0]');
                tabAdmin.classList.remove('text-[#819A91]');
                formAdmin.classList.remove('hidden');
            }
        }

        // Auto switch ke tab yang error saat page load
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('login_role') === 'admin')
                switchTab('admin');
            @elseif(session('login_role') === 'siswa')
                switchTab('siswa');
            @endif
        });
    </script>
@endsection
