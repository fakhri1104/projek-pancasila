@extends('layouts.layout_base')

@section('content')
    <div class="p-6 md:p-8 max-w-6xl mx-auto">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-bold text-[#5C6B65]">Data Siswa</h1>
                <p class="text-[#819A91] mt-1">Kelola data siswa aktif</p>
            </div>
            <a href="{{ route('admin.siswa.create') }}"
                class="px-6 py-3 bg-gradient-to-r from-[#819A91] to-[#A7C1A8] text-white rounded-2xl shadow-lg shadow-[#819A91]/30 hover:shadow-xl hover:shadow-[#819A91]/40 transform hover:-translate-y-0.5 transition-all flex items-center gap-2 font-semibold">
                <i data-lucide="plus" class="w-5 h-5"></i> Tambah Siswa
            </a>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-[#819A91] font-medium uppercase">Total</p>
                        <p class="text-2xl font-bold text-[#5C6B65]">{{ $siswas->total() }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-[#819A91]/20 flex items-center justify-center text-[#819A91]">
                        <i data-lucide="users" class="w-5 h-5"></i>
                    </div>
                </div>
            </div>
            {{-- <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[#819A91] font-medium uppercase">X RPL</p>
                    <p class="text-2xl font-bold text-[#5C6B65]">62</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#A7C1A8]/30 flex items-center justify-center text-[#5C6B65]">
                    <i data-lucide="laptop" class="w-5 h-5"></i>
                </div>
            </div>
        </div> --}}
            {{-- <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[#819A91] font-medium uppercase">XI RPL</p>
                    <p class="text-2xl font-bold text-[#5C6B65]">58</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#D1D8BE]/50 flex items-center justify-center text-[#5C6B65]">
                    <i data-lucide="code" class="w-5 h-5"></i>
                </div>
            </div>
        </div> --}}
            {{-- <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[#819A91] font-medium uppercase">XII RPL</p>
                    <p class="text-2xl font-bold text-[#5C6B65]">64</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#819A91]/20 flex items-center justify-center text-[#819A91]">
                    <i data-lucide="graduation-cap" class="w-5 h-5"></i>
                </div>
            </div>
        </div> --}}
        </div>

        <!-- Search & Filter -->
        <div
            class="bg-white/80 backdrop-blur-lg rounded-2xl p-4 shadow-sm border border-white/50 mb-6 flex flex-col md:flex-row gap-4">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91] w-5 h-5"></i>
                <input type="text" placeholder="Cari nama, NISN, atau email..."
                    class="w-full pl-12 pr-4 py-3 bg-white/50 border border-[#D1D8BE] rounded-xl focus:outline-none focus:border-[#819A91] focus:bg-white transition-all"
                    oninput="filterTable(this.value)">
            </div>
            <div class="flex gap-3">
                <select id="kelasFilter" onchange="filterByKelas(this.value)"
                    class="px-4 py-3 bg-white/50 border border-[#D1D8BE] rounded-xl focus:outline-none focus:border-[#819A91] focus:bg-white transition-all text-[#5C6B65] cursor-pointer">
                    <option value="">Semua Kelas</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas }}">{{ $kelas }}</option>
                    @endforeach
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
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Siswa
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">NISN
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Kelas
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">
                                Aspirasi</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#EEEFE0]" id="tableBody">
                        @forelse($siswas as $siswa)
                            <tr class="hover:bg-[#EEEFE0]/30 transition-all duration-200 group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-[#819A91] to-[#A7C1A8] flex items-center justify-center text-white font-bold text-sm">
                                            {{ strtoupper(substr($siswa->nama, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-[#5C6B65]">{{ $siswa->nama }}</p>
                                            <p class="text-xs text-[#819A91]">Aktif</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-[#5C6B65] font-medium">{{ $siswa->nisn }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 bg-[#A7C1A8]/20 text-[#5C6B65] rounded-full text-xs font-semibold whitespace-nowrap">
                                        {{ preg_replace('/\s+/', ' ', trim($siswa->kelas)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-[#819A91]">{{ $siswa->email }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-sm font-semibold text-[#5C6B65]">{{ $siswa->aspirasis_count ?? 0 }}</span>
                                        <div class="w-16 h-1.5 bg-[#D1D8BE] rounded-full overflow-hidden">
                                            <div class="h-full bg-[#819A91] rounded-full"
                                                style="width: {{ min(($siswa->aspirasis_count ?? 0) * 10, 100) }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div
                                        class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <button
                                            onclick="window.location.href='{{ route('admin.siswa.edit', $siswa->id) }}'"
                                            class="w-8 h-8 rounded-lg bg-[#819A91]/10 text-[#819A91] hover:bg-[#819A91] hover:text-white transition-all flex items-center justify-center"
                                            title="Edit">
                                            <i data-lucide="edit" class="w-4 h-4"></i>
                                        </button>
                                        <button
                                            class="w-8 h-8 rounded-lg bg-red-100 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center"
                                            title="Hapus"
                                            onclick="confirmDelete(this, {{ $siswa->id }}, '{{ $siswa->nama }}')">
                                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 bg-[#D1D8BE]/30 rounded-full flex items-center justify-center mb-4">
                                            <i data-lucide="users" class="w-8 h-8 text-[#819A91]"></i>
                                        </div>
                                        <p class="text-[#5C6B65] font-semibold mb-1">Belum Ada Data Siswa</p>
                                        <p class="text-[#819A91] text-sm mb-4">Klik tombol Tambah Siswa untuk menambahkan
                                            data siswa baru</p>
                                        <a href="{{ route('admin.siswa.create') }}"
                                            class="px-4 py-2 bg-[#819A91] text-white rounded-xl hover:bg-[#5C6B65] transition-all text-sm font-medium">
                                            <i data-lucide="plus" class="w-4 h-4 inline"></i> Tambah Siswa
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-[#EEEFE0] flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-sm text-[#819A91]">
                    Menampilkan {{ $siswas->firstItem() ?? 0 }} - {{ $siswas->lastItem() ?? 0 }} dari
                    {{ $siswas->total() }} data siswa
                </p>
                @if ($siswas->hasPages())
                    <div class="flex items-center gap-2">
                        {{-- Previous Button --}}
                        @if ($siswas->onFirstPage())
                            <button
                                class="w-8 h-8 rounded-lg border border-[#D1D8BE] text-[#819A91] transition-all flex items-center justify-center disabled:opacity-50 cursor-not-allowed"
                                disabled>
                                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            </button>
                        @else
                            <a href="{{ $siswas->previousPageUrl() }}"
                                class="w-8 h-8 rounded-lg border border-[#D1D8BE] text-[#819A91] hover:bg-[#819A91] hover:text-white hover:border-[#819A91] transition-all flex items-center justify-center">
                                <i data-lucide="chevron-left" class="w-4 h-4"></i>
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach ($siswas->getUrlRange(1, $siswas->lastPage()) as $page => $url)
                            @if ($page == $siswas->currentPage())
                                <button
                                    class="w-8 h-8 rounded-lg bg-[#819A91] text-white font-medium text-sm">{{ $page }}</button>
                            @else
                                <a href="{{ $url }}"
                                    class="w-8 h-8 rounded-lg border border-[#D1D8BE] text-[#819A91] hover:bg-[#819A91] hover:text-white hover:border-[#819A91] transition-all font-medium text-sm flex items-center justify-center">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if ($siswas->hasMorePages())
                            <a href="{{ $siswas->nextPageUrl() }}"
                                class="w-8 h-8 rounded-lg border border-[#D1D8BE] text-[#819A91] hover:bg-[#819A91] hover:text-white hover:border-[#819A91] transition-all flex items-center justify-center">
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </a>
                        @else
                            <button
                                class="w-8 h-8 rounded-lg border border-[#D1D8BE] text-[#819A91] transition-all flex items-center justify-center disabled:opacity-50 cursor-not-allowed"
                                disabled>
                                <i data-lucide="chevron-right" class="w-4 h-4"></i>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300"
            id="deleteContent">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="alert-triangle" class="w-8 h-8 text-red-500"></i>
            </div>
            <h3 class="text-xl font-bold text-[#5C6B65] mb-2">Hapus Data Siswa?</h3>
            <p class="text-[#819A91] text-sm mb-2">Data siswa <strong id="siswaName"></strong> akan dihapus permanen.</p>
            <p class="text-[#819A91] text-sm mb-6">Tindakan ini tidak dapat dibatalkan. Lanjutkan?</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()"
                    class="flex-1 py-3 border border-[#D1D8BE] text-[#5C6B65] rounded-xl hover:bg-[#EEEFE0] transition-all font-medium">
                    Batal
                </button>
                <button onclick="executeDelete()"
                    class="flex-1 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all font-medium">
                    Hapus
                </button>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast"
        class="fixed bottom-6 right-6 transform translate-y-20 opacity-0 transition-all duration-500 z-50">
        <div id="toastContent"
            class="bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 border-red-500 min-w-[300px]">
            <div id="toastIcon" class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center">
                <i data-lucide="trash-2" class="w-6 h-6 text-red-500"></i>
            </div>
            <div>
                <h4 id="toastTitle" class="font-bold text-[#5C6B65]">Terhapus!</h4>
                <p id="toastMessage" class="text-sm text-[#819A91]">Data siswa telah dihapus</p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let rowToDelete = null;
        let siswaIdToDelete = null;

        function filterTable(search) {
            const rows = document.querySelectorAll('#tableBody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(search.toLowerCase()) ? '' : 'none';
            });
        }

        function filterByKelas(kelas) {
            const rows = document.querySelectorAll('#tableBody tr');
            rows.forEach(row => {
                if (!kelas) {
                    row.style.display = '';
                } else {
                    const kelasCell = row.querySelector('td:nth-child(3)');
                    if (kelasCell) {
                        const kelasText = kelasCell.textContent.trim();
                        row.style.display = kelasText === kelas ? '' : 'none';
                    }
                }
            });
        }

        function confirmDelete(btn, siswaId, siswaName) {
            rowToDelete = btn.closest('tr');
            siswaIdToDelete = siswaId;
            document.getElementById('siswaName').textContent = siswaName;

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
                rowToDelete = null;
                siswaIdToDelete = null;
            }, 300);
        }

        function executeDelete() {
            if (!siswaIdToDelete) {
                alert('ID siswa tidak ditemukan');
                return;
            }

            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                alert('CSRF token not found');
                return;
            }

            // Send DELETE request to backend
            fetch(`/admin/siswa/${siswaIdToDelete}/delete`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Animate row removal
                        if (rowToDelete) {
                            rowToDelete.style.transform = 'translateX(100%)';
                            rowToDelete.style.opacity = '0';
                            setTimeout(() => {
                                rowToDelete.remove();
                                showToast(data.message, 'success');
                            }, 300);
                        }
                    } else {
                        showToast(data.message || 'Gagal menghapus data siswa', 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Terjadi kesalahan saat menghapus data', 'error');
                })
                .finally(() => {
                    closeDeleteModal();
                });
        }

        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastContent = document.getElementById('toastContent');
            const toastIcon = document.getElementById('toastIcon');
            const toastTitle = document.getElementById('toastTitle');
            const toastMessage = document.getElementById('toastMessage');

            if (type === 'success') {
                toastContent.classList.remove('border-red-500');
                toastContent.classList.add('border-green-500');
                toastIcon.classList.remove('bg-red-100');
                toastIcon.classList.add('bg-green-100');
                toastIcon.innerHTML = '<i data-lucide="check-circle" class="w-6 h-6 text-green-500"></i>';
                toastTitle.textContent = 'Berhasil!';
            } else {
                toastContent.classList.remove('border-green-500');
                toastContent.classList.add('border-red-500');
                toastIcon.classList.remove('bg-green-100');
                toastIcon.classList.add('bg-red-100');
                toastIcon.innerHTML = '<i data-lucide="x-circle" class="w-6 h-6 text-red-500"></i>';
                toastTitle.textContent = 'Gagal!';
            }

            toastMessage.textContent = message;

            // Show toast
            toast.classList.remove('translate-y-20', 'opacity-0');
            lucide.createIcons();

            // Hide after 5 seconds
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 5000);
        }

        // Close modal on outside click
        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) closeDeleteModal();
        });

        // Check for success message from sessionStorage
        window.addEventListener('DOMContentLoaded', () => {
            const successMessage = sessionStorage.getItem('successMessage');
            if (successMessage) {
                showToast(successMessage, 'success');
                sessionStorage.removeItem('successMessage');
            }
        });

        // Initialize Lucide icons
        lucide.createIcons();
    </script>
@endsection
