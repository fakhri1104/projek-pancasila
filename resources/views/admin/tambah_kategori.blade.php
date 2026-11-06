@extends('layouts.layout_base')

@section('content')
<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#5C6B65]">Tambah Kategori</h1>
            <p class="text-[#819A91] mt-1">Isi data di bawah untuk menambahkan kategori baru</p>
        </div>
        <a href="{{ route('admin.kategori.index') }}" class="px-5 py-2.5 bg-white text-[#819A91] rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-2 font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-3xl shadow-xl shadow-[#819A91]/10 overflow-hidden">
        <!-- Progress Bar -->
        <div class="h-1.5 bg-[#D1D8BE]/30">
            <div class="h-full w-1/2 bg-gradient-to-r from-[#819A91] to-[#A7C1A8] rounded-full transition-all duration-500" id="progressBar"></div>
        </div>

        <div class="p-8 md:p-10">
            <form id="kategoriForm" class="space-y-6">
                @csrf
                <!-- Nama Kategori -->
                <div class="group">
                    <label class="block text-sm font-semibold text-[#5C6B65] mb-2">Nama Kategori</label>
                    <div class="relative">
                        <i data-lucide="folder" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91] w-5 h-5"></i>
                        <input type="text" name="nama" id="nama" required placeholder="Masukkan nama kategori"
                            class="w-full pl-12 pr-4 py-4 bg-[#EEEFE0]/50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#A7C1A8] outline-none transition-all duration-300"
                            onfocus="updateProgress(50)">
                        <span class="text-red-500 text-xs mt-1 hidden" id="error-nama"></span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">
                        <i data-lucide="info" class="w-3 h-3 inline"></i>
                        Contoh: Fasilitas Sekolah, Kebersihan, Pembelajaran
                    </p>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label class="block text-sm font-semibold text-[#5C6B65] mb-2">Deskripsi</label>
                    <div class="relative">
                        <i data-lucide="align-left" class="absolute left-4 top-4 text-[#819A91] w-5 h-5"></i>
                        <textarea name="deskripsi" id="deskripsi" required rows="5" maxlength="500" placeholder="Jelaskan kategori ini..."
                            class="w-full pl-12 pr-4 py-4 bg-[#EEEFE0]/50 border-2 border-transparent rounded-2xl focus:bg-white focus:border-[#A7C1A8] outline-none transition-all duration-300 resize-none"
                            onfocus="updateProgress(100)"></textarea>
                        <span class="text-red-500 text-xs mt-1 hidden" id="error-deskripsi"></span>
                    </div>
                    <div class="flex justify-between items-center mt-2">
                        <p class="text-xs text-gray-500">
                            <i data-lucide="info" class="w-3 h-3 inline"></i>
                            Jelaskan jenis aspirasi yang cocok untuk kategori ini
                        </p>
                        <span class="text-xs text-[#819A91]" id="charCount">0/500</span>
                    </div>
                </div>

                <!-- Submit -->
                <div class="pt-4">
                    <button type="submit" class="w-full py-4 bg-gradient-to-r from-[#819A91] to-[#A7C1A8] text-white font-bold rounded-2xl shadow-lg shadow-[#819A91]/30 hover:shadow-xl hover:shadow-[#819A91]/40 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 group">
                        <i data-lucide="save" class="w-5 h-5 group-hover:scale-110 transition-transform"></i>
                        Simpan Kategori
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
            <p id="toastMessage" class="text-sm text-[#819A91]">Data kategori telah disimpan</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function updateProgress(percent) {
        document.getElementById('progressBar').style.width = percent + '%';
    }

    // Character counter for deskripsi
    document.getElementById('deskripsi')?.addEventListener('input', function() {
        const charCount = document.getElementById('charCount');
        charCount.textContent = this.value.length + '/500';
    });

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

    document.getElementById('kategoriForm')?.addEventListener('submit', function(e) {
        e.preventDefault();

        // Hide all error messages
        document.querySelectorAll('[id^="error-"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });

        // Get form data
        const formData = {
            nama: document.getElementById('nama').value,
            deskripsi: document.getElementById('deskripsi').value,
        };

        // Disable submit button
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalBtnText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i data-lucide="loader" class="w-5 h-5 animate-spin"></i> Menyimpan...';
        lucide.createIcons();

        // Send to backend
        fetch('/admin/kategori/store', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalBtnText;
            lucide.createIcons();

            if (data.success) {
                showToast(`Kategori "${data.data.nama}" berhasil ditambahkan!`, 'success');

                // Redirect ke halaman data kategori setelah 1.5 detik
                setTimeout(() => {
                    window.location.href = '{{ route("admin.kategori.index") }}';
                }, 1500);
            } else {
                // Show validation errors
                if (data.errors) {
                    Object.keys(data.errors).forEach(key => {
                        const errorEl = document.getElementById(`error-${key}`);
                        if (errorEl) {
                            errorEl.textContent = data.errors[key][0];
                            errorEl.classList.remove('hidden');
                        }
                    });
                } else {
                    showToast(data.message || 'Gagal menyimpan kategori', 'error');
                }
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
