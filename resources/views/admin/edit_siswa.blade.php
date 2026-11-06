@extends('layouts.layout_base')

@section('content')
<div class="p-6 md:p-8 max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-[#819A91] rounded-xl shadow-sm hover:shadow-md transition-all font-medium">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Data Siswa
        </a>
    </div>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-[#5C6B65]">Edit Data Siswa</h1>
        <p class="text-[#819A91] mt-1">Perbarui informasi data siswa {{ $siswa->nama }}</p>
    </div>

    <!-- Form Edit -->
    <div class="bg-white rounded-3xl shadow-xl shadow-[#819A91]/10 p-8">
        <form id="editSiswaForm">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-[#5C6B65] mb-2">
                    <i data-lucide="user" class="w-4 h-4 inline mr-1"></i>
                    Nama Lengkap
                </label>
                <input type="text" id="nama" name="nama" value="{{ $siswa->nama }}" required
                    class="w-full px-4 py-3 rounded-xl border border-[#D1D8BE] focus:outline-none focus:border-[#819A91] focus:ring-2 focus:ring-[#819A91]/20 transition-all"
                    placeholder="Masukkan nama lengkap siswa">
                <p class="text-xs text-red-500 mt-1 hidden" id="namaError"></p>
            </div>

            <!-- NISN -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-[#5C6B65] mb-2">
                    <i data-lucide="credit-card" class="w-4 h-4 inline mr-1"></i>
                    NISN
                </label>
                <input type="text" id="nisn" name="nisn" value="{{ $siswa->nisn }}" required
                    class="w-full px-4 py-3 rounded-xl border border-[#D1D8BE] focus:outline-none focus:border-[#819A91] focus:ring-2 focus:ring-[#819A91]/20 transition-all"
                    placeholder="Masukkan NISN (10 digit)">
                <p class="text-xs text-red-500 mt-1 hidden" id="nisnError"></p>
            </div>

            <!-- Email & Kelas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-semibold text-[#5C6B65] mb-2">
                        <i data-lucide="mail" class="w-4 h-4 inline mr-1"></i>
                        Email
                    </label>
                    <input type="email" id="email" name="email" value="{{ $siswa->email }}" required
                        class="w-full px-4 py-3 rounded-xl border border-[#D1D8BE] focus:outline-none focus:border-[#819A91] focus:ring-2 focus:ring-[#819A91]/20 transition-all"
                        placeholder="email@example.com">
                    <p class="text-xs text-red-500 mt-1 hidden" id="emailError"></p>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-[#5C6B65] mb-2">
                        <i data-lucide="school" class="w-4 h-4 inline mr-1"></i>
                        Kelas
                    </label>
                    <input type="text" id="kelas" name="kelas" value="{{ $siswa->kelas }}" required
                        class="w-full px-4 py-3 rounded-xl border border-[#D1D8BE] focus:outline-none focus:border-[#819A91] focus:ring-2 focus:ring-[#819A91]/20 transition-all"
                        placeholder="Contoh: XII RPL 1">
                    <p class="text-xs text-red-500 mt-1 hidden" id="kelasError"></p>
                </div>
            </div>

            <!-- Password Section -->
            <div class="border-t border-[#EEEFE0] pt-6 mb-6">
                <h3 class="text-lg font-bold text-[#5C6B65] mb-4">
                    <i data-lucide="lock" class="w-5 h-5 inline mr-1"></i>
                    Ubah Password (Opsional)
                </h3>
                <p class="text-sm text-[#819A91] mb-4">Kosongkan jika tidak ingin mengubah password</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-[#5C6B65] mb-2">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="newPassword" name="new_password"
                                class="w-full px-4 py-3 rounded-xl border border-[#D1D8BE] focus:outline-none focus:border-[#819A91] focus:ring-2 focus:ring-[#819A91]/20 transition-all pr-12"
                                placeholder="Minimal 6 karakter">
                            <button type="button" onclick="togglePassword('newPassword', 'newPasswordIcon')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#819A91] hover:text-[#5C6B65]">
                                <i data-lucide="eye" id="newPasswordIcon" class="w-5 h-5"></i>
                            </button>
                        </div>
                        <p class="text-xs text-red-500 mt-1 hidden" id="newPasswordError"></p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#5C6B65] mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" id="newPasswordConfirmation" name="new_password_confirmation"
                                class="w-full px-4 py-3 rounded-xl border border-[#D1D8BE] focus:outline-none focus:border-[#819A91] focus:ring-2 focus:ring-[#819A91]/20 transition-all pr-12"
                                placeholder="Ketik ulang password">
                            <button type="button" onclick="togglePassword('newPasswordConfirmation', 'confirmPasswordIcon')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-[#819A91] hover:text-[#5C6B65]">
                                <i data-lucide="eye" id="confirmPasswordIcon" class="w-5 h-5"></i>
                            </button>
                        </div>
                        <p class="text-xs text-red-500 mt-1 hidden" id="confirmPasswordError"></p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('admin.siswa.index') }}"
                    class="px-6 py-3 border border-[#D1D8BE] text-[#5C6B65] rounded-xl hover:bg-[#EEEFE0] transition-all font-medium">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-gradient-to-r from-[#819A91] to-[#A7C1A8] text-white rounded-xl shadow-lg hover:shadow-xl transition-all font-semibold flex items-center gap-2">
                    <i data-lucide="save" class="w-5 h-5"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-6 right-6 transform translate-y-20 opacity-0 transition-all duration-500 z-50">
    <div id="toastContent" class="bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 min-w-[300px]">
        <div id="toastIcon" class="w-12 h-12 rounded-full flex items-center justify-center">
            <i data-lucide="check-circle" class="w-6 h-6"></i>
        </div>
        <div>
            <h4 id="toastTitle" class="font-bold text-[#5C6B65]"></h4>
            <p id="toastMessage" class="text-sm text-[#819A91]"></p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('data-lucide', 'eye-off');
        } else {
            input.type = 'password';
            icon.setAttribute('data-lucide', 'eye');
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

    function clearErrors() {
        document.querySelectorAll('[id$="Error"]').forEach(el => {
            el.classList.add('hidden');
            el.textContent = '';
        });
    }

    function showFieldError(field, message) {
        const errorEl = document.getElementById(field + 'Error');
        if (errorEl) {
            errorEl.textContent = message;
            errorEl.classList.remove('hidden');
        }
    }

    document.getElementById('editSiswaForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        clearErrors();

        const formData = new FormData(this);

        // Validation
        const newPassword = document.getElementById('newPassword').value;
        const confirmPassword = document.getElementById('newPasswordConfirmation').value;

        if (newPassword && newPassword !== confirmPassword) {
            showFieldError('confirmPassword', 'Konfirmasi password tidak cocok');
            return;
        }

        if (newPassword && newPassword.length < 6) {
            showFieldError('newPassword', 'Password minimal 6 karakter');
            return;
        }

        try {
            const response = await fetch('{{ route("admin.siswa.update", $siswa->id) }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (response.ok && data.success) {
                showToast(data.message || 'Data siswa berhasil diperbarui!', 'success');

                setTimeout(() => {
                    window.location.href = '{{ route("admin.siswa.index") }}';
                }, 1500);
            } else {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        showFieldError(field, data.errors[field][0]);
                    });
                } else {
                    showToast(data.message || 'Gagal memperbarui data', 'error');
                }
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Terjadi kesalahan pada server', 'error');
        }
    });

    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[#819A91] font-medium uppercase">Total</p>
                    <p class="text-2xl font-bold text-[#5C6B65]">248</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#819A91]/20 flex items-center justify-center text-[#819A91]">
                    <i data-lucide="users" class="w-5 h-5"></i>
                </div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[#819A91] font-medium uppercase">X RPL</p>
                    <p class="text-2xl font-bold text-[#5C6B65]">62</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#A7C1A8]/30 flex items-center justify-center text-[#5C6B65]">
                    <i data-lucide="laptop" class="w-5 h-5"></i>
                </div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[#819A91] font-medium uppercase">XI RPL</p>
                    <p class="text-2xl font-bold text-[#5C6B65]">58</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#D1D8BE]/50 flex items-center justify-center text-[#5C6B65]">
                    <i data-lucide="code" class="w-5 h-5"></i>
                </div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[#819A91] font-medium uppercase">XII RPL</p>
                    <p class="text-2xl font-bold text-[#5C6B65]">64</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#819A91]/20 flex items-center justify-center text-[#819A91]">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-4 shadow-sm border border-white/50 mb-6 flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91] w-5 h-5"></i>
            <input type="text" placeholder="Cari nama, NISN, atau email..."
                class="w-full pl-12 pr-4 py-3 bg-white/50 border border-[#D1D8BE] rounded-xl focus:outline-none focus:border-[#819A91] focus:bg-white transition-all"
                oninput="filterTable(this.value)">
        </div>
        <div class="flex gap-3">
            <select class="px-4 py-3 bg-white/50 border border-[#D1D8BE] rounded-xl focus:outline-none focus:border-[#819A91] focus:bg-white transition-all text-[#5C6B65] cursor-pointer">
                <option>Semua Kelas</option>
                <option>X RPL 1</option>
                <option>X RPL 2</option>
                <option>XI RPL 1</option>
                <option>XI RPL 2</option>
                <option>XII RPL 1</option>
                <option>XII RPL 2</option>
            </select>
            <button class="px-4 py-3 bg-[#819A91]/10 text-[#819A91] rounded-xl hover:bg-[#819A91]/20 transition-all">
                <i data-lucide="filter" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-xl shadow-[#819A91]/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#819A91]/10 border-b border-[#D1D8BE]">
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Siswa</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">NISN</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Email</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Aspirasi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EEEFE0]" id="tableBody">
                    <!-- Rows akan di-loop dari database nanti -->
                    <tr class="hover:bg-[#EEEFE0]/30 transition-all duration-200 group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#819A91] to-[#A7C1A8] flex items-center justify-center text-white font-bold text-sm">
                                    BS
                                </div>
                                <div>
                                    <p class="font-semibold text-[#5C6B65]">Budi Santoso</p>
                                    <p class="text-xs text-[#819A91]">Aktif</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-[#5C6B65] font-medium">0098765432</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 bg-[#A7C1A8]/20 text-[#5C6B65] rounded-full text-xs font-semibold">XII RPL 1</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-[#819A91]">budi.santoso@email.com</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-semibold text-[#5C6B65]">12</span>
                                <div class="w-16 h-1.5 bg-[#D1D8BE] rounded-full overflow-hidden">
                                    <div class="h-full w-3/4 bg-[#819A91] rounded-full"></div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button class="w-8 h-8 rounded-lg bg-[#819A91]/10 text-[#819A91] hover:bg-[#819A91] hover:text-white transition-all flex items-center justify-center" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </button>
                                <button class="w-8 h-8 rounded-lg bg-red-100 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="Hapus" onclick="confirmDelete(this)">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#EEEFE0] flex items-center justify-between">
            <p class="text-sm text-[#819A91]">Menampilkan 1-4 dari 248 data</p>
            <div class="flex items-center gap-2">
                <button class="w-8 h-8 rounded-lg border border-[#D1D8BE] text-[#819A91] hover:bg-[#819A91] hover:text-white hover:border-[#819A91] transition-all flex items-center justify-center disabled:opacity-50" disabled>
                    <i data-lucide="chevron-left" class="w-4 h-4"></i>
                </button>
                <button class="w-8 h-8 rounded-lg bg-[#819A91] text-white font-medium text-sm">1</button>
                <button class="w-8 h-8 rounded-lg border border-[#D1D8BE] text-[#819A91] hover:bg-[#819A91] hover:text-white hover:border-[#819A91] transition-all font-medium text-sm">2</button>
                <button class="w-8 h-8 rounded-lg border border-[#D1D8BE] text-[#819A91] hover:bg-[#819A91] hover:text-white hover:border-[#819A91] transition-all font-medium text-sm">3</button>
                <span class="text-[#819A91]">...</span>
                <button class="w-8 h-8 rounded-lg border border-[#D1D8BE] text-[#819A91] hover:bg-[#819A91] hover:text-white hover:border-[#819A91] transition-all flex items-center justify-center">
                    <i data-lucide="chevron-right" class="w-4 h-4"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="deleteContent">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="alert-triangle" class="w-8 h-8 text-red-500"></i>
        </div>
        <h3 class="text-xl font-bold text-[#5C6B65] mb-2">Hapus Data?</h3>
        <p class="text-[#819A91] text-sm mb-6">Data siswa akan dihapus permanen. Lanjutkan?</p>
        <div class="flex gap-3">
            <button onclick="closeDeleteModal()" class="flex-1 py-3 border border-[#D1D8BE] text-[#5C6B65] rounded-xl hover:bg-[#EEEFE0] transition-all font-medium">
                Batal
            </button>
            <button onclick="executeDelete()" class="flex-1 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all font-medium">
                Hapus
            </button>
        </div>
    </div>
</div>

<!-- Toast Notification -->
<div id="toast" class="fixed bottom-6 right-6 transform translate-y-20 opacity-0 transition-all duration-500 z-50">
    <div class="bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 border-red-500 min-w-[300px]">
        <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
            <i data-lucide="trash-2" class="w-6 h-6 text-red-500"></i>
        </div>
        <div>
            <h4 class="font-bold text-[#5C6B65]">Terhapus!</h4>
            <p class="text-sm text-[#819A91]">Data siswa telah dihapus</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let rowToDelete = null;

    function filterTable(search) {
        const rows = document.querySelectorAll('#tableBody tr');
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(search.toLowerCase()) ? '' : 'none';
        });
    }

    function confirmDelete(btn) {
        rowToDelete = btn.closest('tr');
        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    function executeDelete() {
        if (rowToDelete) {
            rowToDelete.style.transform = 'translateX(100%)';
            rowToDelete.style.opacity = '0';
            setTimeout(() => {
                rowToDelete.remove();
                showToast();
            }, 300);
        }
        closeDeleteModal();
    }

    function showToast() {
        const toast = document.getElementById('toast');
        toast.classList.remove('translate-y-20', 'opacity-0');
        setTimeout(() => {
            toast.classList.add('translate-y-20', 'opacity-0');
        }, 3000);
    }

    // Close modal on outside click
    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });

    // Initialize Lucide icons
    lucide.createIcons();
</script>
@endsection
