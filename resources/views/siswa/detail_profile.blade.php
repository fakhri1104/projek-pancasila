@extends('layouts.layout_base')

@section('content')
    <div class="pt-8 pb-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <!-- Back Button -->
        <div class="mb-4">
            @if (isset($isAdmin) && $isAdmin)
                <a href="{{ route('admin.siswa.index') }}"
                    class="px-4 py-2 bg-white text-[#819A91] rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-2 font-medium inline-flex">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Data Siswa
                </a>
            @else
                <a href="{{ route('siswa.dashboard') }}"
                    class="px-4 py-2 bg-white text-[#819A91] rounded-xl shadow-sm hover:shadow-md transition-all flex items-center gap-2 font-medium inline-flex">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
                </a>
            @endif
        </div>

        <!-- Header Section -->
        <div class="mb-6 animate-fade-in">
            @if (isset($isAdmin) && $isAdmin)
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Data Siswa</h1>
                <p class="text-gray-600">Kelola informasi data siswa ({{ $siswa->nama }})</p>
            @else
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Profil Siswa</h1>
                <p class="text-gray-600">Kelola informasi pribadi siswa</p>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            <!-- Left Column: Profile Card -->
            <div class="lg:col-span-4 space-y-6 animate-slide-up">
                <!-- Main Profile Card -->
                <div
                    class="bg-white/85 backdrop-blur-lg rounded-3xl p-6 shadow-xl border border-white/60 relative overflow-hidden group">
                    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-[#D1D8BE]/50 to-transparent"></div>

                    <div class="relative flex flex-col items-center">
                        <div class="relative mb-4">
                            <div class="w-28 h-28 rounded-full p-1 bg-gradient-to-br from-[#819A91] to-[#A7C1A8] shadow-lg">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->nama) }}&background=819A91&color=fff&size=112"
                                    alt="Foto Profil" class="w-full h-full rounded-full object-cover border-4 border-white"
                                    id="profileImage">
                            </div>
                            <div class="absolute top-0 right-0 w-5 h-5 bg-green-500 border-4 border-white rounded-full"
                                title="Online"></div>
                        </div>

                        <h2 class="text-xl font-bold text-gray-800 mb-1" id="displayNama">{{ $siswa->nama }}</h2>
                        <p class="text-[#819A91] font-medium mb-3" id="displayNisn">NISN: {{ $siswa->nisn }}</p>

                        <div
                            class="flex items-center space-x-2 bg-[#EEEFE0] px-4 py-2 rounded-full border border-[#D1D8BE]">
                            <i class="fas fa-shield-alt text-[#819A91]"></i>
                            <span class="text-sm font-semibold text-[#819A91]">Status: Aktif</span>
                        </div>
                    </div>
                </div>

                <!-- Quick Info Cards -->
                <div class="grid grid-cols-1 gap-4">
                    <div
                        class="bg-white/80 backdrop-blur-lg rounded-2xl p-4 hover:shadow-lg transition-all cursor-pointer group border border-white/60">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#D1D8BE]/50 flex items-center justify-center mb-3 group-hover:bg-[#819A91] transition-colors">
                            <i class="fas fa-envelope text-[#819A91] group-hover:text-white transition-colors"></i>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">Email</p>
                        <p class="text-sm font-semibold text-gray-800 truncate" id="displayEmail">{{ $siswa->email }}</p>
                    </div>

                    <div
                        class="bg-white/80 backdrop-blur-lg rounded-2xl p-4 hover:shadow-lg transition-all cursor-pointer group border border-white/60">
                        <div
                            class="w-10 h-10 rounded-xl bg-[#D1D8BE]/50 flex items-center justify-center mb-3 group-hover:bg-[#819A91] transition-colors">
                            <i class="fas fa-key text-[#819A91] group-hover:text-white transition-colors"></i>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">Kata Sandi</p>
                        <p class="text-sm font-semibold text-gray-800">••••••••</p>
                    </div>
                </div>
            </div>

            <!-- Right Column: Details -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Detailed Information Form -->
                <div class="bg-white/85 backdrop-blur-lg rounded-3xl p-6 shadow-xl border border-white/60 animate-slide-up"
                    style="animation-delay: 0.2s;">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Informasi Detail</h3>
                            <p class="text-sm text-gray-600 mt-1">Data lengkap profil siswa sesuai database</p>
                        </div>
                        <button onclick="toggleEdit()" id="editBtn"
                            class="px-6 py-2.5 bg-[#819A91] text-white rounded-xl font-medium hover:bg-[#6b8279] transition-all shadow-lg hover:shadow-xl flex items-center space-x-2 transform hover:-translate-y-0.5">
                            <i class="fas fa-edit"></i>
                            <span>Edit Profil</span>
                        </button>
                    </div>

                    <form id="profileForm" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <!-- Read-only Fields Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <!-- Nama -->
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class="fas fa-user text-[#819A91] mr-2 w-4"></i>
                                    Nama Lengkap
                                </label>
                                <input type="text" id="inputNama" name="nama" value="{{ $siswa->nama }}"
                                    @if (!isset($isAdmin) || !$isAdmin) disabled @endif
                                    class="w-full px-4 py-3 rounded-xl {{ isset($isAdmin) && $isAdmin ? 'bg-gray-100 border-gray-200' : 'bg-gray-100 border-gray-200' }} text-gray-800 font-medium {{ isset($isAdmin) && $isAdmin ? '' : 'cursor-not-allowed' }} transition-all">
                            </div>

                            <!-- Email -->
                            <div class="space-y-2 md:col-span-2">
                                <label class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class="fas fa-envelope text-[#819A91] mr-2 w-4"></i>
                                    Email
                                </label>
                                <input type="email" id="inputEmail" name="email" value="{{ $siswa->email }}" disabled
                                    class="w-full px-4 py-3 rounded-xl bg-gray-100 border border-gray-200 text-gray-800 font-medium transition-all disabled:cursor-not-allowed">
                            </div>

                            <!-- NISN -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class="fas fa-id-card text-[#819A91] mr-2 w-4"></i>
                                    NISN
                                </label>
                                <input type="text" id="inputNisn" name="nisn" value="{{ $siswa->nisn }}"
                                    @if (!isset($isAdmin) || !$isAdmin) disabled @endif
                                    class="w-full px-4 py-3 rounded-xl {{ isset($isAdmin) && $isAdmin ? 'bg-gray-100 border-gray-200' : 'bg-gray-100 border-gray-200' }} text-gray-800 font-medium {{ isset($isAdmin) && $isAdmin ? '' : 'cursor-not-allowed' }} transition-all">
                            </div>

                            <!-- Kelas -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class="fas fa-school text-[#819A91] mr-2 w-4"></i>
                                    Kelas
                                </label>
                                <input type="text" id="inputKelas" name="kelas" value="{{ $siswa->kelas }}" disabled
                                    class="w-full px-4 py-3 rounded-xl bg-gray-100 border border-gray-200 text-gray-800 font-medium transition-all disabled:cursor-not-allowed truncate">
                            </div>

                            <!-- Dibuat Pada -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class="fas fa-clock text-[#819A91] mr-2 w-4"></i>
                                    Dibuat Pada
                                </label>
                                <input type="text" value="{{ $siswa->created_at->format('d M Y H:i') }}" disabled
                                    class="w-full px-4 py-3 rounded-xl bg-gray-100 border border-gray-200 text-gray-800 font-medium cursor-not-allowed">
                            </div>

                            <!-- Diperbarui Pada -->
                            <div class="space-y-2">
                                <label class="text-sm font-semibold text-gray-700 flex items-center">
                                    <i class="fas fa-sync-alt text-[#819A91] mr-2 w-4"></i>
                                    Diperbarui Pada
                                </label>
                                <input type="text" value="{{ $siswa->updated_at->format('d M Y H:i') }}" disabled
                                    class="w-full px-4 py-3 rounded-xl bg-gray-100 border border-gray-200 text-gray-800 font-medium cursor-not-allowed">
                            </div>
                        </div>

                        <!-- Password Change Section (Hidden by default, shown when editing) -->
                        <div id="passwordSection" class="hidden mt-4 pt-4 border-t border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="w-10 h-10 rounded-xl bg-[#D1D8BE]/50 flex items-center justify-center mr-3">
                                    <i class="fas fa-lock text-[#819A91]"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800">Ubah Kata Sandi</h4>
                                    <p class="text-xs text-gray-600">Kosongkan jika tidak ingin mengubah password</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4">
                                <!-- Current Password -->
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 flex items-center">
                                        <i class="fas fa-key text-[#819A91] mr-2 w-4"></i>
                                        Password Saat Ini
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="currentPassword" name="current_password"
                                            placeholder="Masukkan password saat ini"
                                            class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-800 font-medium focus:outline-none focus:border-[#819A91] focus:ring-2 focus:ring-[#819A91]/20 transition-all pr-12">
                                        <button type="button"
                                            onclick="togglePasswordVisibility('currentPassword', 'currentPasswordIcon')"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-[#819A91] transition-colors">
                                            <i class="fas fa-eye" id="currentPasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- New Password -->
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 flex items-center">
                                        <i class="fas fa-lock text-[#819A91] mr-2 w-4"></i>
                                        Password Baru
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="newPassword" name="new_password"
                                            placeholder="Maksimal 6 karakter"
                                            class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-800 font-medium focus:outline-none focus:border-[#819A91] focus:ring-2 focus:ring-[#819A91]/20 transition-all pr-12">
                                        <button type="button"
                                            onclick="togglePasswordVisibility('newPassword', 'newPasswordIcon')"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-[#819A91] transition-colors">
                                            <i class="fas fa-eye" id="newPasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="space-y-2">
                                    <label class="text-sm font-semibold text-gray-700 flex items-center">
                                        <i class="fas fa-check-circle text-[#819A91] mr-2 w-4"></i>
                                        Konfirmasi Password Baru
                                    </label>
                                    <div class="relative">
                                        <input type="password" id="confirmPassword" name="new_password_confirmation"
                                            placeholder="Ketik ulang password baru"
                                            class="w-full px-4 py-3 rounded-xl bg-white border border-gray-200 text-gray-800 font-medium focus:outline-none focus:border-[#819A91] focus:ring-2 focus:ring-[#819A91]/20 transition-all pr-12">
                                        <button type="button"
                                            onclick="togglePasswordVisibility('confirmPassword', 'confirmPasswordIcon')"
                                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-[#819A91] transition-colors">
                                            <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Password Strength Indicator -->
                                <div id="passwordStrength" class="hidden">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-[#819A91] w-0 transition-all" id="strengthBar"></div>
                                        </div>
                                        <span class="text-xs text-gray-600" id="strengthText">Kekuatan Password</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div id="actionButtons"
                            class="hidden flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                            <button type="button" onclick="toggleEdit()"
                                class="px-6 py-2.5 rounded-xl font-medium text-gray-600 hover:bg-gray-100 transition-colors">
                                Batal
                            </button>
                            <button type="submit"
                                class="px-6 py-2.5 bg-[#819A91] text-white rounded-xl font-medium hover:bg-[#6b8279] transition-all shadow-lg hover:shadow-xl flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span>Simpan Perubahan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed bottom-8 right-8 transform translate-y-20 opacity-0 transition-all duration-300 z-50">
        <div class="bg-[#819A91] text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center space-x-3">
            <i class="fas fa-check-circle text-2xl"></i>
            <div>
                <p class="font-bold">Berhasil!</p>
                <p class="text-sm text-white/80" id="toastMessage">Perubahan telah disimpan.</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        (function() {
                let isEditing = false;

                const editBtn = document.getElementById('editBtn');
                const actionButtons = document.getElementById('actionButtons');
                const passwordSection = document.getElementById('passwordSection');
                const toast = document.getElementById('toast');
                const toastMessage = document.getElementById('toastMessage');
                const form = document.getElementById('profileForm');

                // Toggle edit mode
                window.toggleEdit = function() {
                    isEditing = !isEditing;

                    const emailInput = document.getElementById('inputEmail');
                    const kelasInput = document.getElementById('inputKelas');
                    const namaInput = document.getElementById('inputNama');
                    const nisnInput = document.getElementById('inputNisn');
                    const isAdmin = @json(isset($isAdmin) && $isAdmin);

                    if (isEditing) {
                        // Enable editing
                        passwordSection.classList.remove('hidden');
                        actionButtons.classList.remove('hidden');
                        editBtn.classList.add('hidden');

                        // Enable email and kelas fields
                        emailInput.disabled = false;
                        kelasInput.disabled = false;
                        emailInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                        emailInput.classList.add('bg-white', 'focus:border-[#819A91]', 'focus:ring-2',
                            'focus:ring-[#819A91]/20');
                        kelasInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                        kelasInput.classList.add('bg-white', 'focus:border-[#819A91]', 'focus:ring-2',
                            'focus:ring-[#819A91]/20');

                        // Enable nama and nisn ONLY for admin
                        if (isAdmin) {
                            namaInput.disabled = false;
                            nisnInput.disabled = false;
                            namaInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                            namaInput.classList.add('bg-white', 'focus:border-[#819A91]', 'focus:ring-2',
                                'focus:ring-[#819A91]/20');
                            nisnInput.classList.remove('bg-gray-100', 'cursor-not-allowed');
                            nisnInput.classList.add('bg-white', 'focus:border-[#819A91]', 'focus:ring-2',
                                'focus:ring-[#819A91]/20');
                        }
                    } else {
                        // Disable editing
                        passwordSection.classList.add('hidden');
                        actionButtons.classList.add('hidden');
                        editBtn.classList.remove('hidden');

                        // Disable email and kelas fields
                        emailInput.disabled = true;
                        kelasInput.disabled = true;
                        emailInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                        emailInput.classList.remove('bg-white', 'focus:border-[#819A91]', 'focus:ring-2',
                            'focus:ring-[#819A91]/20');
                        kelasInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                        kelasInput.classList.remove('bg-white', 'focus:border-[#819A91]', 'focus:ring-2',
                            'focus:ring-[#819A91]/20');

                        // Disable nama and nisn for admin
                        if (isAdmin) {
                            namaInput.disabled = true;
                            nisnInput.disabled = true;
                            namaInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                            namaInput.classList.remove('bg-white', 'focus:border-[#819A91]', 'focus:ring-2',
                                'focus:ring-[#819A91]/20');
                            nisnInput.classList.add('bg-gray-100', 'cursor-not-allowed');
                            nisnInput.classList.remove('bg-white', 'focus:border-[#819A91]', 'focus:ring-2',
                                'focus:ring-[#819A91]/20');
                        }

                        // Clear password fields
                        document.getElementById('currentPassword').value = '';
                        document.getElementById('newPassword').value = '';
                        document.getElementById('confirmPassword').value = '';

                        // Hide strength indicator
                        document.getElementById('passwordStrength').classList.add('hidden');
                    }
                };

                // Toggle password visibility
                window.togglePasswordVisibility = function(inputId, iconId) {
                    const input = document.getElementById(inputId);
                    const icon = document.getElementById(iconId);

                    if (input && icon) {
                        const isVisible = input.type === 'text';
                        input.type = isVisible ? 'password' : 'text';
                        icon.classList.toggle('fa-eye', isVisible);
                        icon.classList.toggle('fa-eye-slash', !isVisible);
                    }
                };

                // Password strength checker
                function checkPasswordStrength(password) {
                    const strengthDiv = document.getElementById('passwordStrength');
                    const strengthBar = document.getElementById('strengthBar');
                    const strengthText = document.getElementById('strengthText');

                    if (!password) {
                        strengthDiv.classList.add('hidden');
                        return;
                    }

                    strengthDiv.classList.remove('hidden');

                    let strength = 0;
                    if (password.length >= 6) strength += 25;
                    if (password.match(/[a-z]+/)) strength += 25;
                    if (password.match(/[A-Z]+/)) strength += 25;
                    if (password.match(/[0-9]+/)) strength += 25;

                    strengthBar.style.width = strength + '%';

                    if (strength <= 25) {
                        strengthText.textContent = 'Lemah';
                    } else if (strength <= 50) {
                        strengthText.textContent = 'Sedang';
                    } else if (strength <= 75) {
                        strengthText.textContent = 'Kuat';
                    } else {
                        strengthText.textContent = 'Sangat Kuat';
                    }
                }

                // Validate passwords
                function validatePasswords() {
                    const newPass = document.getElementById('newPassword').value;
                    const confirmPass = document.getElementById('confirmPassword').value;
                    const currentPass = document.getElementById('currentPassword').value;

                    if (!currentPass && !newPass && !confirmPass) {
                        return {
                            valid: true,
                            message: ''
                        };
                    }

                    if (!currentPass) {
                        return {
                            valid: false,
                            message: 'Password saat ini harus diisi'
                        };
                    }

                    if (!newPass) {
                        return {
                            valid: false,
                            message: 'Password baru harus diisi'
                        };
                    }

                    if (newPass.length < 6) {
                        return {
                            valid: false,
                            message: 'Password minimal 6 karakter'
                        };
                    }

                    if (newPass !== confirmPass) {
                        return {
                            valid: false,
                            message: 'Konfirmasi password tidak cocok'
                        };
                    }

                    return {
                        valid: true,
                        message: ''
                    };
                }

                // Show toast
                function showToast(message, isError = false) {
                    toastMessage.textContent = message;

                    const toastDiv = toast.querySelector('div');
                    if (isError) {
                        toastDiv.className =
                            'bg-red-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center space-x-3';
                    } else {
                        toastDiv.className =
                            'bg-[#819A91] text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center space-x-3';
                    }

                    toast.classList.remove('translate-y-20', 'opacity-0');

                    setTimeout(() => {
                        toast.classList.add('translate-y-20', 'opacity-0');
                    }, 3000);
                }

                // Event listeners
                document.getElementById('newPassword')?.addEventListener('input', function(e) {
                    checkPasswordStrength(e.target.value);
                });

                if (form) {
                    form.addEventListener('submit', async function(e) {
                            e.preventDefault();

                            const validation = validatePasswords();
                            if (!validation.valid) {
                                showToast(validation.message, true);
                                return;
                            }

                            const formData = new FormData();
                            formData.append('_token', document.querySelector('input[name="_token"]').value);
                            formData.append('email', document.getElementById('inputEmail').value);
                            formData.append('kelas', document.getElementById('inputKelas').value);

                            // Include nama and nisn if admin
                            const isAdmin = @json(isset($isAdmin) && $isAdmin);
                            if (isAdmin) {
                                formData.append('nama', document.getElementById('inputNama').value);
                                formData.append('nisn', document.getElementById('inputNisn').value);
                            }

                            const currentPass = document.getElementById('currentPassword').value;
                            const newPass = document.getElementById('newPassword').value;

                            if (currentPass && newPass) {
                                formData.append('current_password', currentPass);
                                formData.append('new_password', newPass);
                                formData.append('new_password_confirmation', document.getElementById(
                                    'confirmPassword').value);
                            }

                            try {
                                @if (isset($isAdmin) && $isAdmin)
                                    const response = await fetch('{{ route('admin.siswa.update', $siswa->id) }}', {
                                        @else
                                            const response = await fetch(
                                                '{{ route('siswa.profile.update') }}', {
                                                @endif
                                                method: 'POST',
                                                body: formData,
                                                headers: {
                                                    'X-Requested-With': 'XMLHttpRequest'
                                                }
                                            });

                                        const data = await response.json();

                                        if (response.ok && data.success) {
                                            showToast(data.message || 'Profil berhasil diperbarui!');

                                            // Update display values
                                            document.getElementById('displayEmail').textContent = document
                                                .getElementById('inputEmail').value;

                                            // Update nama display if admin edited it
                                            if (isAdmin && document.getElementById('displayNama')) {
                                                document.getElementById('displayNama').textContent = document
                                                    .getElementById('inputNama').value;
                                                document.getElementById('displayNisn').textContent = 'NISN: ' +
                                                    document.getElementById('inputNisn').value;

                                                // Update profile image
                                                const namaValue = document.getElementById('inputNama').value;
                                                const profileImage = document.getElementById('profileImage');
                                                if (profileImage) {
                                                    profileImage.src = 'https://ui-avatars.com/api/?name=' +
                                                        encodeURIComponent(namaValue) +
                                                        '&background=819A91&color=fff&size=112';
                                                }
                                            }

                                            toggleEdit();

                                            // Reload after 1.5 seconds to update all data
                                            setTimeout(() => {
                                                @if (isset($isAdmin) && $isAdmin)
                                                    window.location.href =
                                                        '{{ route('admin.siswa.index') }}';
                                                @else
                                                    location.reload();
                                                @endif
                                            }, 1500);
                                        } else {
                                            showToast(data.message || 'Gagal memperbarui profil', true);
                                        }

                                    }
                                    catch (error) {
                                        console.error('Error:', error);
                                        showToast('Terjadi kesalahan pada server', true);
                                    }
                                });
                        }
                    })();
    </script>
@endsection
