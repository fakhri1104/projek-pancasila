@extends('layouts.layout_base')

@section('title', 'Tambah Aspirasi')

@section('content')
    <!-- Main Content -->
    <main class="pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('siswa.dashboard') }}" class="px-4 py-2 bg-white text-[#819A91] rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-2 font-medium">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
            </div>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-[#819A91] mb-2">Sampaikan Aspirasimu</h2>
            <p class="text-[#819A91]/70 text-lg">Ceritakan keluhan atau ide perbaikan untuk lingkungan sekolah yang lebih
                baik.</p>
        </div>

        <!-- Form - Tanpa Card Wrapper -->
        <form id="aspirasiForm" class="space-y-8">
            @csrf

            <!-- Title Input -->
            <div class="relative">
                <label for="judul" class="block text-sm font-semibold text-[#819A91] mb-2 ml-1">
                    Judul Aspirasi <span class="text-red-400">*</span>
                </label>

                <div class="relative">
                    <input type="text" id="judul" name="judul" required maxlength="150"
                        placeholder="Contoh: AC kelas rusak dan tidak dingin"
                        class="w-full px-4 py-4 bg-[#D1D8BE]/20 border-2 border-[#D1D8BE] rounded-2xl text-[#819A91] placeholder-[#819A91]/40 focus:outline-none focus:border-[#819A91] focus:bg-white/50 text-2sm font-semibold">

                    <div class="absolute right-4 top-1/2 -translate-y-1/2 text-xs text-[#819A91]/40" id="title-counter">
                        0/150</div>
                </div>
            </div>


            <!-- Grid for Category & Location -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category Select -->
                <div class="relative">
                    <label class="block text-sm font-semibold text-[#819A91] mb-2 ml-1">Kategori <span
                            class="text-red-400">*</span></label>
                    <div class="relative">
                        <select name="kategori_id" required
                            class="w-full px-4 py-4 bg-[#D1D8BE]/20 border-2 border-[#D1D8BE] rounded-2xl text-[#819A91] focus:outline-none focus:border-[#819A91] focus:bg-white/50 appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih kategori...</option>
                            @foreach ($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-[#819A91]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Location Input -->
                <div class="relative">
                    <label class="block text-sm font-semibold text-[#819A91] mb-2 ml-1">Lokasi Kejadian <span
                            class="text-red-400">*</span></label>
                    <div class="relative">
                        <input type="text" name="lokasi" required maxlength="100"
                            placeholder="Contoh: Kelas 12A, Kantin Lt. 2"
                            class="w-full px-4 py-4 pl-12 bg-[#D1D8BE]/20 border-2 border-[#D1D8BE] rounded-2xl text-[#819A91] placeholder-[#819A91]/40 focus:outline-none focus:border-[#819A91] focus:bg-white/50">
                        <svg class="w-5 h-5 absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91]/50" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Description Textarea -->
            <div>
                <label class="block text-sm font-semibold text-[#819A91] mb-2 ml-1">Deskripsi Detail <span
                        class="text-red-400">*</span></label>
                <textarea name="deskripsi" required rows="5" minlength="20"
                    placeholder="Jelaskan detail aspirasi atau keluhanmu di sini. Semakin detail, semakin mudah kami membantu..."
                    class="w-full px-4 py-4 bg-[#D1D8BE]/20 border-2 border-[#D1D8BE] rounded-2xl text-[#819A91] placeholder-[#819A91]/40 focus:outline-none focus:border-[#819A91] focus:bg-white/50 resize-none leading-relaxed"></textarea>
                <div class="text-right text-xs text-[#819A91]/40 mt-1">Min. 20 karakter</div>
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-sm font-semibold text-[#819A91] mb-3 ml-1">Lampiran Foto (Opsional)</label>
                <div id="dropZone"
                    class="relative w-full p-8 bg-[#D1D8BE]/20 border-2 border-dashed border-[#A7C1A8] rounded-2xl cursor-pointer hover:bg-[#A7C1A8]/10 transition-colors text-center">
                    <input type="file" id="fileInput" name="photos[]" accept="image/jpeg,image/png,image/jpg" multiple
                        class="hidden">

                    <div id="upload-default">
                        <div class="w-16 h-16 bg-[#A7C1A8]/20 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-[#819A91]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <p class="text-[#819A91] font-medium">Klik atau drag foto ke sini</p>
                        <p class="text-[#819A91]/50 text-sm mt-1">PNG, JPG up to 2MB (maks. 1280x1280)</p>
                    </div>

                    <!-- Preview -->
                    <div id="upload-preview" class="hidden mt-4">
                        <div class="flex flex-wrap gap-3 justify-center" id="preview-container"></div>
                        <button type="button" id="clearFilesBtn"
                            class="mt-4 px-4 py-2 bg-red-400 text-white rounded-xl hover:bg-red-500 transition-colors text-sm">
                            Hapus semua
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex flex-col sm:flex-row gap-4 items-center justify-between pt-4 border-t border-[#D1D8BE]/30">
                <p class="text-sm text-[#819A91]/60 text-center sm:text-left">
                    <span class="text-red-400">*</span> Wajib diisi
                </p>
                <button type="submit" id="submitBtn"
                    class="w-full sm:w-auto px-8 py-4 bg-[#819A91] text-[#EEEFE0] font-bold rounded-2xl shadow-lg hover:bg-[#819A91]/90 transition-colors flex items-center justify-center gap-2">
                    <span>Kirim Aspirasi</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </div>
        </form>
    </main>

    <!-- Success Modal -->
    <div id="successModal"
        class="fixed inset-0 bg-[#819A91]/20 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
        <div class="bg-[#EEEFE0] rounded-3xl p-8 max-w-md w-full shadow-2xl">
            <div class="w-20 h-20 bg-[#A7C1A8] rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-[#EEEFE0]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-[#819A91] text-center mb-2">Berhasil Dikirim!</h3>
            <p class="text-[#819A91]/70 text-center mb-6">Aspirasimu telah tersimpan dan akan segera ditinjau oleh admin.
            </p>
            <div class="bg-[#D1D8BE]/30 rounded-2xl p-4 mb-6">
                <p class="text-sm text-[#819A91] text-center font-medium">ID Aspirasi: <span class="font-bold"
                        id="aspirasiId"></span></p>
            </div>
            <button id="closeModalBtn"
                class="w-full py-4 bg-[#819A91] text-[#EEEFE0] font-bold rounded-2xl hover:bg-[#819A91]/90 transition-colors">
                Kembali ke Dashboard
            </button>
        </div>
    </div>

    <script>
        // Character counter
        const titleInput = document.getElementById('judul');
        const titleCounter = document.getElementById('title-counter');

        titleInput.addEventListener('input', function() {
            titleCounter.textContent = `${this.value.length}/150`;
        });

        // File upload
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('fileInput');
        let uploadedFiles = [];

        dropZone.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('bg-[#A7C1A8]/20');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('bg-[#A7C1A8]/20');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('bg-[#A7C1A8]/20');
            handleFiles(e.dataTransfer.files);
        });

        fileInput.addEventListener('change', function() {
            handleFiles(this.files);
        });

        async function handleFiles(files) {
            if (files.length > 0) {
                const validFiles = [];
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                const maxDimension = 1280;

                for (let file of Array.from(files)) {
                    // Check file size
                    if (file.size > maxSize) {
                        alert(`File "${file.name}" terlalu besar. Maksimal 2MB. Ukuran file: ${(file.size / 1024 / 1024).toFixed(2)}MB`);
                        continue;
                    }

                    // Check image dimensions
                    try {
                        const dimensions = await getImageDimensions(file);
                        if (dimensions.width > maxDimension || dimensions.height > maxDimension) {
                            alert(`File "${file.name}" resolusi terlalu besar. Maksimal ${maxDimension}x${maxDimension}. Resolusi file: ${dimensions.width}x${dimensions.height}`);
                            continue;
                        }
                        validFiles.push(file);
                    } catch (error) {
                        alert(`File "${file.name}" tidak valid atau rusak`);
                        continue;
                    }
                }

                if (validFiles.length > 0) {
                    uploadedFiles = validFiles;

                    const dataTransfer = new DataTransfer();
                    uploadedFiles.forEach(file => dataTransfer.items.add(file));
                    fileInput.files = dataTransfer.files;

                    showPreview();
                } else if (validFiles.length === 0 && files.length > 0) {
                    alert('Tidak ada file yang valid untuk diupload');
                }
            }
        }

        function getImageDimensions(file) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                const url = URL.createObjectURL(file);

                img.onload = function() {
                    URL.revokeObjectURL(url);
                    resolve({
                        width: this.width,
                        height: this.height
                    });
                };

                img.onerror = function() {
                    URL.revokeObjectURL(url);
                    reject(new Error('Failed to load image'));
                };

                img.src = url;
            });
        }

        function showPreview() {
            const previewContainer = document.getElementById('preview-container');
            const defaultView = document.getElementById('upload-default');
            const previewView = document.getElementById('upload-preview');

            previewContainer.innerHTML = '';

            uploadedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative w-40 h-40 rounded-lg overflow-hidden border-2 border-[#A7C1A8]';
                    div.innerHTML = `
                <img src="${e.target.result}" class="w-full h-full object-cover">
                <button type="button" onclick="removeFile(${index})" class="absolute top-1 right-1 w-6 h-6 bg-red-400 text-white rounded-full flex items-center justify-center hover:bg-red-500 text-xs">
                    ✕
                </button>
            `;
                    previewContainer.appendChild(div);
                };
                reader.readAsDataURL(file);
            });

            defaultView.classList.add('hidden');
            previewView.classList.remove('hidden');
        }

        function removeFile(index) {
            event.stopPropagation();
            uploadedFiles.splice(index, 1);

            const dataTransfer = new DataTransfer();
            uploadedFiles.forEach(file => dataTransfer.items.add(file));
            fileInput.files = dataTransfer.files;

            if (uploadedFiles.length === 0) {
                clearFiles();
            } else {
                showPreview();
            }
        }

        function clearFiles() {
            uploadedFiles = [];
            fileInput.value = '';
            document.getElementById('upload-default').classList.remove('hidden');
            document.getElementById('upload-preview').classList.add('hidden');
        }

        document.getElementById('clearFilesBtn')?.addEventListener('click', clearFiles);

        // Form submission
        const aspirasiForm = document.getElementById('aspirasiForm');
        const submitBtn = document.getElementById('submitBtn');

        aspirasiForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const originalContent = submitBtn.innerHTML;

            submitBtn.innerHTML = `
        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Mengirim...</span>
    `;
            submitBtn.disabled = true;

            fetch('{{ route('aspirasi.store') }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('aspirasiId').textContent = `#ASP-${data.aspirasi_id}`;
                        document.getElementById('successModal').classList.remove('hidden');
                        document.getElementById('successModal').classList.add('flex');
                        aspirasiForm.reset();
                        clearFiles();
                        titleCounter.textContent = '0/150';
                    } else {
                        alert(data.message || 'Terjadi kesalahan');
                    }
                })
                .catch(() => alert('Terjadi kesalahan. Silakan coba lagi.'))
                .finally(() => {
                    submitBtn.innerHTML = originalContent;
                    submitBtn.disabled = false;
                });
        });

        // Modal close
        document.getElementById('closeModalBtn').addEventListener('click', function() {
            window.location.href = '{{ route('siswa.dashboard') }}';
        });
    </script>
@endsection
