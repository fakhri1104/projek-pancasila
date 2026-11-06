@extends('layouts.layout_base')

@section('content')
<div class="p-6 md:p-8 max-w-6xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-[#5C6B65]">Data Kategori</h1>
            <p class="text-[#819A91] mt-1">Kelola kategori aspirasi</p>
        </div>
        <a href="{{ route('admin.kategori.create') }}" class="px-6 py-3 bg-gradient-to-r from-[#819A91] to-[#A7C1A8] text-white rounded-2xl shadow-lg shadow-[#819A91]/30 hover:shadow-xl hover:shadow-[#819A91]/40 transform hover:-translate-y-0.5 transition-all flex items-center gap-2 font-semibold">
            <i data-lucide="plus" class="w-5 h-5"></i> Tambah Kategori
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[#819A91] font-medium uppercase">Total Kategori</p>
                    <p class="text-2xl font-bold text-[#5C6B65]">{{ $kategoris->count() }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#819A91]/20 flex items-center justify-center text-[#819A91]">
                    <i data-lucide="folder" class="w-5 h-5"></i>
                </div>
            </div>
        </div>
        <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-5 shadow-sm border border-white/50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-[#819A91] font-medium uppercase">Total Aspirasi</p>
                    <p class="text-2xl font-bold text-[#5C6B65]">{{ $kategoris->sum('aspirasis_count') }}</p>
                </div>
                <div class="w-10 h-10 rounded-xl bg-[#A7C1A8]/30 flex items-center justify-center text-[#5C6B65]">
                    <i data-lucide="message-square" class="w-5 h-5"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="bg-white/80 backdrop-blur-lg rounded-2xl p-4 shadow-sm border border-white/50 mb-6 flex flex-col md:flex-row gap-4">
        <div class="relative flex-1">
            <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-[#819A91] w-5 h-5"></i>
            <input type="text" placeholder="Cari kategori..."
                class="w-full pl-12 pr-4 py-3 bg-white/50 border border-[#D1D8BE] rounded-xl focus:outline-none focus:border-[#819A91] focus:bg-white transition-all"
                oninput="filterTable(this.value)">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-xl shadow-[#819A91]/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-[#819A91]/10 border-b border-[#D1D8BE]">
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Nama Kategori</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Jumlah Aspirasi</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-[#5C6B65] uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EEEFE0]" id="tableBody">
                    @forelse($kategoris as $kategori)
                    <tr class="hover:bg-[#EEEFE0]/30 transition-all duration-200 group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#819A91] to-[#A7C1A8] flex items-center justify-center text-white font-bold text-sm">
                                    <i data-lucide="folder" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-[#5C6B65]">{{ $kategori->nama }}</p>
                                    <p class="text-xs text-[#819A91]">{{ $kategori->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-[#5C6B65]">
                            {{ Str::limit($kategori->deskripsi, 80) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 bg-[#A7C1A8]/20 text-[#5C6B65] rounded-full text-xs font-semibold">
                                    {{ $kategori->aspirasis_count ?? 0 }} aspirasi
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.kategori.edit', $kategori->id) }}" class="w-8 h-8 rounded-lg bg-[#819A91]/10 text-[#819A91] hover:bg-[#819A91] hover:text-white transition-all flex items-center justify-center" title="Edit">
                                    <i data-lucide="edit" class="w-4 h-4"></i>
                                </a>
                                <button class="w-8 h-8 rounded-lg bg-red-100 text-red-500 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center" title="Hapus" onclick="confirmDelete({{ $kategori->id }}, '{{ $kategori->nama }}', {{ $kategori->aspirasis_count ?? 0 }})">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-[#D1D8BE]/30 rounded-full flex items-center justify-center mb-4">
                                    <i data-lucide="folder" class="w-8 h-8 text-[#819A91]"></i>
                                </div>
                                <p class="text-[#5C6B65] font-semibold mb-1">Belum Ada Data Kategori</p>
                                <p class="text-[#819A91] text-sm mb-4">Klik tombol Tambah Kategori untuk menambahkan kategori baru</p>
                                <a href="{{ route('admin.kategori.create') }}" class="px-4 py-2 bg-[#819A91] text-white rounded-xl hover:bg-[#5C6B65] transition-all text-sm font-medium">
                                    <i data-lucide="plus" class="w-4 h-4 inline"></i> Tambah Kategori
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-[#EEEFE0] flex items-center justify-between">
            <p class="text-sm text-[#819A91]">Menampilkan {{ $kategoris->count() }} data kategori</p>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="deleteContent">
        <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="alert-triangle" class="w-8 h-8 text-red-500"></i>
        </div>
        <h3 class="text-xl font-bold text-[#5C6B65] mb-2">Hapus Kategori?</h3>
        <p class="text-[#819A91] text-sm mb-6" id="deleteMessage"></p>
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
    <div id="toastContent" class="bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 min-w-[300px]">
        <div class="w-10 h-10 rounded-full flex items-center justify-center" id="toastIcon">
            <i data-lucide="check-circle" class="w-6 h-6"></i>
        </div>
        <div class="flex-1">
            <p class="font-semibold text-sm" id="toastTitle"></p>
            <p class="text-xs text-[#819A91]" id="toastMessage"></p>
        </div>
        <button onclick="hideToast()" class="text-[#819A91] hover:text-[#5C6B65]">
            <i data-lucide="x" class="w-5 h-5"></i>
        </button>
    </div>
</div>

<script>
    let deleteId = null;

    function filterTable(query) {
        const rows = document.querySelectorAll('#tableBody tr');
        const searchQuery = query.toLowerCase();

        rows.forEach(row => {
            const kategoriName = row.querySelector('td:first-child')?.textContent.toLowerCase() || '';
            const deskripsi = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';

            if (kategoriName.includes(searchQuery) || deskripsi.includes(searchQuery)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    function confirmDelete(id, nama, jumlahAspirasi) {
        deleteId = id;
        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteContent');
        const message = document.getElementById('deleteMessage');

        if (jumlahAspirasi > 0) {
            message.textContent = `Kategori "${nama}" masih digunakan oleh ${jumlahAspirasi} aspirasi. Kategori tidak dapat dihapus.`;
            document.querySelector('#deleteModal button.bg-red-500').disabled = true;
            document.querySelector('#deleteModal button.bg-red-500').classList.add('opacity-50', 'cursor-not-allowed');
        } else {
            message.textContent = `Kategori "${nama}" akan dihapus permanen. Lanjutkan?`;
            document.querySelector('#deleteModal button.bg-red-500').disabled = false;
            document.querySelector('#deleteModal button.bg-red-500').classList.remove('opacity-50', 'cursor-not-allowed');
        }

        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        const content = document.getElementById('deleteContent');

        content.classList.add('scale-95', 'opacity-0');
        content.classList.remove('scale-100', 'opacity-100');

        setTimeout(() => {
            modal.classList.add('hidden');
            deleteId = null;
        }, 300);
    }

    async function executeDelete() {
        if (!deleteId) return;

        try {
            const response = await fetch(`/admin/kategori/${deleteId}/delete`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            closeDeleteModal();

            if (data.success) {
                showToast('Berhasil!', data.message, 'success');
                setTimeout(() => {
                    location.reload();
                }, 1500);
            } else {
                showToast('Gagal!', data.message, 'error');
            }
        } catch (error) {
            closeDeleteModal();
            showToast('Error!', 'Terjadi kesalahan saat menghapus kategori', 'error');
        }
    }

    function showToast(title, message, type = 'success') {
        const toast = document.getElementById('toast');
        const toastContent = document.getElementById('toastContent');
        const toastIcon = document.getElementById('toastIcon');
        const toastTitle = document.getElementById('toastTitle');
        const toastMessage = document.getElementById('toastMessage');

        toastTitle.textContent = title;
        toastMessage.textContent = message;

        if (type === 'success') {
            toastContent.classList.remove('border-red-500');
            toastContent.classList.add('border-green-500');
            toastIcon.classList.remove('bg-red-100', 'text-red-500');
            toastIcon.classList.add('bg-green-100', 'text-green-500');
            toastIcon.innerHTML = '<i data-lucide="check-circle" class="w-6 h-6"></i>';
        } else {
            toastContent.classList.remove('border-green-500');
            toastContent.classList.add('border-red-500');
            toastIcon.classList.remove('bg-green-100', 'text-green-500');
            toastIcon.classList.add('bg-red-100', 'text-red-500');
            toastIcon.innerHTML = '<i data-lucide="x-circle" class="w-6 h-6"></i>';
        }

        toast.classList.remove('translate-y-20', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        lucide.createIcons();

        setTimeout(() => {
            hideToast();
        }, 5000);
    }

    function hideToast() {
        const toast = document.getElementById('toast');
        toast.classList.add('translate-y-20', 'opacity-0');
        toast.classList.remove('translate-y-0', 'opacity-100');
    }

    // Initialize Lucide icons when page loads
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();

        // Check for success message from add/edit operations
        const successMessage = sessionStorage.getItem('successMessage');
        if (successMessage) {
            showToast('Berhasil!', successMessage, 'success');
            sessionStorage.removeItem('successMessage');
        }
    });
</script>
@endsection
