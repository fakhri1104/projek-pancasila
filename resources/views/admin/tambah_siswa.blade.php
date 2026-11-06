@extends('layouts.layout_base')

@section('content')
<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#5C6B65]">Tambah Siswa</h1>
            <p class="text-[#819A91] mt-1">Isi data di bawah untuk mendaftarkan siswa baru</p>
        </div>
        <a href="{{ route('admin.siswa.index') }}" class="px-5 py-2.5 bg-white text-[#819A91] rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-2 font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl shadow-xl shadow-[#819A91]/10 overflow-hidden">
        <!-- Progress Bar -->
        <div class="h-1.5 bg-[#D1D8BE]/30">
            <div class="h-full w-1/3 bg-gradient-to-r from-[#819A91] to-[#A7C1A8] rounded-full transition-all duration-500" id="progressBar"></div>
        </div>

        <div class="p-8 md:p-10">
            <form id="siswaForm" class="space-y-6">
                @csrf
                <!-- Nama -->
                <div class="group">
                    <label class="block text-sm font-semibold text-[#5C6B65] mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <i data-lucide="user" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91] w-5 h-5"></i>
                        <input type="text" name="nama" id="nama" required placeholder="Masukkan nama siswa"
                            class="w-full pl-12 pr-4 py-4 bg-[#EEEFE0]/50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#A7C1A8] outline-none transition-all duration-300"
                            onfocus="updateProgress(20)">
                        <span class="text-red-500 text-xs mt-1 hidden" id="error-nama"></span>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <!-- NISN -->
                    <div>
                        <label class="block text-sm font-semibold text-[#5C6B65] mb-2">NISN</label>
                        <div class="relative">
                            <i data-lucide="id-card" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91] w-5 h-5"></i>
                            <input type="text" name="nisn" id="nisn" required maxlength="10" placeholder="0098765432"
                                class="w-full pl-12 pr-4 py-4 bg-[#EEEFE0]/50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#A7C1A8] outline-none transition-all duration-300"
                                onfocus="updateProgress(40)">
                            <span class="text-red-500 text-xs mt-1 hidden" id="error-nisn"></span>
                        </div>
                    </div>

                    <!-- Kelas (diubah menjadi input text) -->
                    <div>
                        <label class="block text-sm font-semibold text-[#5C6B65] mb-2">Kelas</label>
                        <div class="relative">
                            <i data-lucide="school" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91] w-5 h-5"></i>
                            <input type="text" name="kelas" id="kelas" required placeholder="Contoh: X RPL 1"
                                class="w-full pl-12 pr-4 py-4 bg-[#EEEFE0]/50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#A7C1A8] outline-none transition-all duration-300"
                                onfocus="updateProgress(60)">
                            <span class="text-red-500 text-xs mt-1 hidden" id="error-kelas"></span>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-[#5C6B65] mb-2">Email</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91] w-5 h-5"></i>
                        <input type="email" name="email" id="email" required placeholder="siswa@email.com"
                            class="w-full pl-12 pr-4 py-4 bg-[#EEEFE0]/50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#A7C1A8] outline-none transition-all duration-300"
                            onfocus="updateProgress(80)">
                        <span class="text-red-500 text-xs mt-1 hidden" id="error-email"></span>
                    </div>
                </div>

                <!-- Password (tanpa tombol generate) -->
                <div>
                    <label class="block text-sm font-semibold text-[#5C6B65] mb-2">Password</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91] w-5 h-5"></i>
                        <input type="password" name="kata_sandi" id="password" required placeholder="Minimal 6 karakter"
                            class="w-full pl-12 pr-12 py-4 bg-[#EEEFE0]/50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#A7C1A8] outline-none transition-all duration-300"
                            onfocus="updateProgress(100)">
                        <button type="button" onclick="togglePass()" class="absolute right-4 top-1/2 -translate-y-1/2 text-[#819A91] hover:text-[#5C6B65] transition-colors">
                            <i data-lucide="eye" id="eyeIcon" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <span class="text-red-500 text-xs mt-1 hidden" id="error-kata_sandi"></span>
                    <p class="text-xs text-gray-500 mt-2">
                        <i data-lucide="info" class="w-3 h-3 inline"></i>
                        Siswa akan login menggunakan <strong>NISN</strong> dan <strong>password ini</strong>
                    </p>
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#819A91] to-[#A7C1A8] text-white font-bold rounded-2xl shadow-lg shadow-[#819A91]/30 hover:shadow-xl hover:shadow-[#819A91]/40 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 group">
                        <i data-lucide="save" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-6 right-6 transform translate-y-20 opacity-0 transition-all duration-500 z-50">
    <div id="toastContent" class="bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 min-w-[300px]">
        <div id="toastIcon" class="w-12 h-12 rounded-full flex items-center justify-center">
            <i data-lucide="check-circle" class="w-6 h-6"></i>
        </div>
        <div>
            <h4 id="toastTitle" class="font-bold text-[#5C6B65]">Berhasil!</h4>
            <p id="toastMessage" class="text-sm text-[#819A91]">Data siswa telah disimpan</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateProgress(percent) {
        document.getElementById('progressBar').style.width = percent + '%';
    }

    function togglePass() {
        const pass = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (pass.type === 'password') {
            pass.type = 'text';
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            pass.type = 'password';
            eyeIcon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    }

    function showToast(message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastContent = document.getElementById('toastContent');
        const toastIcon = document.getElementById('toastIcon');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');

        if (type === 'success') {
            toastContent.className = 'bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 border-green-500 min-w-[300px]';
            toastIcon.className = 'w-12 h-12 rounded-full bg-green-100 flex items-center justify-center';
            toastIcon.innerHTML = '<i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>';
            toastTitle.textContent = 'Berhasil!';
        } else {
            toastContent.className = 'bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 border-red-500 min-w-[300px]';
            toastIcon.className = 'w-12 h-12 rounded-full bg-red-100 flex items-center justify-center';
            toastIcon.innerHTML = '<i data-lucide="x-circle" class="w-6 h-6 text-red-500"></i>';
            toastTitle.textContent = 'Gagal!';
        }

        toastMessage.textContent = message;
        lucide.createIcons();

        toast.classList.remove('translate-y-20', 'opacity-0');

        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 5000);
    }

    document.getElementById('siswaForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        // Hide all error messages
        document.querySelectorAll('[id^="error-"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });

        // Get form data
        const formData = {
            nama: document.getElementById('nama').value,
            nisn: document.getElementById('nisn').value,
            kelas: document.getElementById('kelas').value,
            email: document.getElementById('email').value,
            kata_sandi: document.getElementById('password').value,
        };

        // Disable submit button
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i data-lucide="loader" class="w-5 h-5 animate-spin"></i> Menyimpan...';
        lucide.createIcons();

        // Send to backend
        fetch('/admin/siswa/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            lucide.createIcons();

            if (data.success) {
                showToast(`Data siswa ${data.data.nama} berhasil ditambahkan! NISN: ${data.data.nisn}`, 'success');

                // Redirect ke halaman data siswa setelah 1.5 detik
                setTimeout(() => {
                    window.location.href = '{{ route("admin.siswa.index") }}';
                }, 1500);
            } else {
                showToast(data.message || 'Gagal menyimpan data siswa', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan saat menyimpan data', 'error');

            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            lucide.createIcons();
        });
    });

    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
