@extends('layouts.layout_base')

@section('content')
    <div class="p-6 md:p-8 max-w-7xl mx-auto">

        {{-- ===== HEADER ===== --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-[#819A91]">Dashboard</h1>
                <p class="text-gray-600 mt-2">Selamat datang kembali, Admin!</p>
            </div>
            {{-- Hapus button export laporan dan icon lonceng --}}
        </div>

        {{-- ===== STATS CARDS ===== --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">

            {{-- Total Aspirasi --}}
            <div class="glass-panel rounded-2xl p-5 hover-card border border-[#D1D8BE]">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-[#819A91]/10 flex items-center justify-center">
                        <i data-lucide="inbox" class="w-5 h-5 text-[#819A91]"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Total</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalAspirasi }}</h3>
                <p class="text-xs text-gray-500 mt-1">Total Aspirasi</p>
            </div>

            {{-- Menunggu --}}
            <div class="glass-panel rounded-2xl p-5 hover-card border border-[#D1D8BE]">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                        <i data-lucide="clock" class="w-5 h-5 text-yellow-600"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Menunggu</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $menunggu }}</h3>
                <p class="text-xs text-gray-500 mt-1">Perlu ditindaklanjuti</p>
            </div>

            {{-- Diproses --}}
            <div class="glass-panel rounded-2xl p-5 hover-card border border-[#D1D8BE]">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                        <i data-lucide="loader" class="w-5 h-5 text-blue-600"></i>
                    </div>
                    <span class="text-xs font-medium text-gray-500">Diproses</span>
                </div>
                <h3 class="text-2xl font-bold text-gray-800">{{ $diproses }}</h3>
                <p class="text-xs text-gray-500 mt-1">Dalam penanganan</p>
            </div>

            {{-- Selesai --}}
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

        {{-- ===== CHART & AKTIVITAS TERBARU ===== --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">

            {{-- Bar Chart Bulanan --}}
            <div class="lg:col-span-2 glass-panel rounded-2xl p-6 border border-[#D1D8BE]">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-[#819A91]">Statistik Aspirasi Bulanan</h3>
                    <select
                        class="px-3 py-1 border border-[#D1D8BE] rounded-lg text-sm focus:outline-none focus:border-[#819A91] bg-transparent">
                        <option>2024</option>
                        <option>2023</option>
                    </select>
                </div>

                @php
                    $maxValue = max($monthlyStats) ?: 1;
                @endphp

                <div class="h-64 flex items-end justify-between gap-2 px-4">
                    @foreach ($monthlyStats as $stat)
                        @php
                            $heightPercent = $maxValue > 0 ? ($stat / $maxValue) * 100 : 0;
                        @endphp
                        <div class="flex-1 bg-[#819A91] rounded-t-lg" style="height: {{ $heightPercent }}%"></div>
                    @endforeach
                </div>

                <div class="flex justify-between mt-4 text-sm text-gray-600 px-4">
                    <span>Jan</span><span>Feb</span><span>Mar</span>
                    <span>Apr</span><span>Mei</span><span>Jun</span>
                </div>
            </div>

            {{-- Aktivitas Terbaru --}}
            {{-- <div class="glass-panel rounded-2xl p-6 border border-[#D1D8BE]">
            <h3 class="text-xl font-bold text-[#819A91] mb-4">Aktivitas Terbaru</h3>
            <div class="flex flex-col items-center justify-center h-64 text-center">
                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                    <i data-lucide="bell" class="w-8 h-8 text-gray-400"></i>
                </div>
                <p class="text-gray-500 text-sm">Belum ada aktivitas terbaru</p>
            </div>
        </div> --}}

        </div>

        {{-- ===== TABEL ASPIRASI TERBARU ===== --}}
        <div class="glass-panel rounded-2xl border border-[#D1D8BE] overflow-hidden mb-8">
            <div class="p-6 border-b border-[#D1D8BE]/50 flex items-center justify-between">
                <h3 class="font-bold text-lg text-gray-800">Aspirasi Terbaru</h3>
                <a href="#" class="text-sm text-[#819A91] hover:text-[#6b8279] font-medium flex items-center gap-1">
                    Lihat Semua <i data-lucide="arrow-right" class="w-4 h-4"></i>
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-[#D1D8BE]/30">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">ID</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Judul</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Pengirim</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Kategori</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#D1D8BE]/30">
                        @forelse($recentAspirasi as $aspirasi)
                            <tr class="hover:bg-gray-50 transition-all">
                                <td class="px-6 py-4 text-sm text-gray-700">#{{ $aspirasi->id }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-800">
                                    {{ Str::limit($aspirasi->judul, 40) }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $aspirasi->siswa->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-700">{{ $aspirasi->kategori->nama ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $aspirasi->tanggal_kirim->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-3 py-1 {{ $aspirasi->getStatusBadgeClass() }} rounded-full text-xs font-medium capitalize">
                                        {{ $aspirasi->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <button onclick="window.showDetail({{ $aspirasi->id }})"
                                        class="text-[#819A91] hover:text-[#5C6B65] font-medium text-sm flex items-center gap-1">
                                        <i data-lucide="eye" class="w-4 h-4"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mb-4">
                                            <i data-lucide="inbox" class="w-8 h-8 text-gray-400"></i>
                                        </div>
                                        <p class="text-gray-500 text-sm mb-2">Belum ada aspirasi</p>
                                        <p class="text-gray-400 text-xs">Aspirasi yang masuk akan muncul di sini</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ===== RINGKASAN KATEGORI ===== --}}
        {{-- Bagian ini dihapus sesuai permintaan --}}

    </div>

    {{-- ===== MODAL DETAIL ASPIRASI ===== --}}
    <div id="detailModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">

            {{-- Header Modal --}}
            <div class="p-6 border-b border-[#D1D8BE]/50 flex justify-between items-center">
                <h3 class="text-xl font-bold text-[#819A91]">Detail Aspirasi</h3>
                <button onclick="window.hideModal()" class="text-gray-400 hover:text-gray-600">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            {{-- Konten Modal (diisi via JS) --}}
            <div id="modalContent" class="p-6 space-y-4">
                <div class="flex justify-center items-center py-12">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#819A91]"></div>
                </div>
            </div>

        </div>
    </div>

    <div id="statusToast" class="fixed bottom-6 right-6 z-50 hidden">
        <div id="statusToastContent" class="bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 min-w-[300px]">
            <div id="statusToastIcon" class="w-12 h-12 rounded-full flex items-center justify-center"></div>
            <div>
                <h4 id="statusToastTitle" class="font-bold text-[#5C6B65]">Berhasil!</h4>
                <p id="statusToastMessage" class="text-sm text-[#819A91]"></p>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        // =============================================
        // STATE
        // =============================================
        let currentAspirasiId = null;

        // =============================================
        // HELPER
        // =============================================

        /**
         * Mapping status ke class badge Tailwind
         */
        const STATUS_BADGE = {
            menunggu: 'bg-yellow-100 text-yellow-800',
            diproses: 'bg-blue-100 text-blue-800',
            selesai: 'bg-green-100 text-green-800',
            ditolak: 'bg-red-100 text-red-800',
        };

        /**
         * Format tanggal ke format Indonesia
         * @param {string} dateString
         * @returns {string}
         */
        function formatTanggal(dateString) {
            if (!dateString) return '-';

            const date = new Date(dateString);
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            };

            return date.toLocaleDateString('id-ID', options);
        }

        function showStatusToast(message, type = 'success') {
            const toast = document.getElementById('statusToast');
            const toastContent = document.getElementById('statusToastContent');
            const toastIcon = document.getElementById('statusToastIcon');
            const toastTitle = document.getElementById('statusToastTitle');
            const toastMessage = document.getElementById('statusToastMessage');

            if (!toast || !toastContent || !toastIcon || !toastTitle || !toastMessage) {
                alert(message);
                return;
            }

            if (type === 'success') {
                toastContent.className = 'bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 border-green-500 min-w-[300px]';
                toastIcon.className = 'w-12 h-12 rounded-full bg-green-100 flex items-center justify-center';
                toastIcon.innerHTML = '<svg class="w-6 h-6 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>';
                toastTitle.textContent = 'Berhasil!';
            } else {
                toastContent.className = 'bg-white rounded-2xl shadow-2xl p-4 flex items-center gap-4 border-l-4 border-red-500 min-w-[300px]';
                toastIcon.className = 'w-12 h-12 rounded-full bg-red-100 flex items-center justify-center';
                toastIcon.innerHTML = '<svg class="w-6 h-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>';
                toastTitle.textContent = 'Gagal!';
            }

            toastMessage.textContent = message;
            toast.classList.remove('hidden');

            setTimeout(() => {
                toast.classList.add('hidden');
            }, 2500);
        }

        // =============================================
        // MODAL
        // =============================================

        /**
         * Tampilkan modal dan ambil data dari server
         * @param {number} id - ID aspirasi
         */
        window.showDetail = function(id) {
            currentAspirasiId = id;

            const modal = document.getElementById('detailModal');
            const modalContent = document.getElementById('modalContent');

            // Tampilkan modal + loading spinner
            modal.classList.remove('hidden');
            modalContent.innerHTML = `
            <div class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#819A91]"></div>
            </div>
        `;

            // Fetch data dari server
            fetch(`/admin/aspirasi/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        renderModalContent(data.aspirasi);
                        // Re-initialize lucide icons for the new content
                        if (typeof lucide !== 'undefined' && lucide.createIcons) {
                            lucide.createIcons();
                        }
                    } else {
                        modalContent.innerHTML = `
                        <div class="text-center py-8 text-red-500">
                            Gagal memuat data: ${data.message || 'Unknown error'}
                        </div>
                    `;
                    }
                })
                .catch(err => {
                    console.error('Gagal fetch detail:', err);
                    modalContent.innerHTML = `
                    <div class="text-center py-8 text-red-500">
                        Gagal memuat data. Coba lagi. <br>
                        <small class="text-xs">${err.message}</small>
                    </div>
                `;
                });
        };

        /** Sembunyikan modal dan reset state */
        window.hideModal = function() {
            document.getElementById('detailModal').classList.add('hidden');
            currentAspirasiId = null;
        };

        /**
         * Render isi modal berdasarkan data aspirasi
         * @param {Object} aspirasi
         */
        function renderModalContent(aspirasi) {
            const modalContent = document.getElementById('modalContent');

            const fotosHtml = aspirasi.foto_pengaduan?.length ?
                aspirasi.foto_pengaduan.map(foto => `
            <img src="${foto.url_foto}" class="w-40 h-40 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity" alt="Foto bukti" onclick="window.open('${foto.url_foto}', '_blank')">
          `).join('') :
                `<div class="w-40 h-40 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
               <i data-lucide="image" class="w-8 h-8"></i>
           </div>`;

            const riwayatHtml = aspirasi.riwayat_status?.length ?
                aspirasi.riwayat_status.map((riwayat, index) => `
            <div class="border-l-2 border-[#819A91] pl-4 pb-4 ${index === aspirasi.riwayat_status.length - 1 ? '' : 'mb-4'}">
                <div class="flex justify-between items-start mb-2">
                    <span class="px-3 py-1 ${STATUS_BADGE[riwayat.status] ?? ''} rounded-full text-xs font-medium capitalize">
                        ${riwayat.status}
                    </span>
                    <span class="text-xs text-gray-500">${formatTanggal(riwayat.created_at)}</span>
                </div>
                <p class="text-sm text-gray-700 mb-1">${riwayat.umpan_balik || '-'}</p>
                ${riwayat.keterangan ? `<p class="text-xs text-gray-500 italic">${riwayat.keterangan}</p>` : ''}
                <p class="text-xs text-gray-400 mt-1">oleh ${riwayat.admin?.nama ?? 'Admin'}</p>
            </div>
          `).join('') :
                `<div class="text-center py-4 text-gray-500 text-sm">
               <i data-lucide="clock" class="w-8 h-8 mx-auto mb-2 text-gray-400"></i>
               <p>Belum ada riwayat update</p>
           </div>`;

            modalContent.innerHTML = `
        <!-- Info utama -->
        <div class="flex justify-between items-start">
            <div>
                <h4 class="text-lg font-semibold">${aspirasi.judul || '-'}</h4>
                <p class="text-sm text-gray-500">
                    Dikirim oleh ${aspirasi.siswa?.nama ?? '-'} • ${formatTanggal(aspirasi.tanggal_kirim)}
                </p>
            </div>
            <span class="px-3 py-1 ${STATUS_BADGE[aspirasi.status] ?? ''} rounded-full text-sm font-medium capitalize">
                ${aspirasi.status || '-'}
            </span>
        </div>

        <!-- Deskripsi -->
        <div class="bg-[#EEEFE0] p-4 rounded-lg">
            <p class="text-gray-700 leading-relaxed">${aspirasi.deskripsi || '-'}</p>
        </div>

        <!-- Lokasi & Kategori -->
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-500">Lokasi</p>
                <p class="font-semibold">${aspirasi.lokasi || '-'}</p>
            </div>
            <div>
                <p class="text-gray-500">Kategori</p>
                <p class="font-semibold">${aspirasi.kategori?.nama ?? '-'}</p>
            </div>
        </div>

        <!-- Foto Bukti -->
        <div class="border-t border-[#D1D8BE]/30 pt-4">
            <h5 class="font-semibold mb-3">Foto Bukti</h5>
            <div class="flex gap-2 flex-wrap">${fotosHtml}</div>
        </div>

        <!-- Riwayat Status & Umpan Balik -->
        <div class="border-t border-[#D1D8BE]/30 pt-4">
            <h5 class="font-semibold mb-3">Riwayat Status & Umpan Balik</h5>
            <div class="max-h-60 overflow-y-auto">
                ${riwayatHtml}
            </div>
        </div>

        <!-- Update Status -->
        <div class="border-t border-[#D1D8BE]/30 pt-4">
            <h5 class="font-semibold mb-3">Update Status</h5>
            ${getUpdateStatusSection(aspirasi.status)}
        </div>
    `;
        }

        /**
         * Generate section Update Status berdasarkan status sekarang
         * @param {string} currentStatus
         */
        function getUpdateStatusSection(currentStatus) {
            // Jika status sudah final (selesai/ditolak), tidak bisa diubah
            if (currentStatus === 'selesai' || currentStatus === 'ditolak') {
                return `
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-center">
                    <i data-lucide="lock" class="w-8 h-8 mx-auto mb-2 text-gray-400"></i>
                    <p class="text-gray-600 font-medium">Status <span class="capitalize">"${currentStatus}"</span> sudah final</p>
                    <p class="text-sm text-gray-500 mt-1">Status ini tidak dapat diubah lagi</p>
                </div>
            `;
            }

            // Tentukan tombol status yang boleh muncul
            const allowedStatuses = {
                'menunggu': [{
                        value: 'diproses',
                        label: 'Proses',
                        color: 'bg-blue-500 hover:bg-blue-600'
                    },
                    {
                        value: 'ditolak',
                        label: 'Tolak',
                        color: 'bg-red-500 hover:bg-red-600'
                    }
                ],
                'diproses': [{
                        value: 'selesai',
                        label: 'Selesai',
                        color: 'bg-green-500 hover:bg-green-600'
                    },
                    {
                        value: 'ditolak',
                        label: 'Tolak',
                        color: 'bg-red-500 hover:bg-red-600'
                    }
                ]
            };

            const buttons = allowedStatuses[currentStatus] || [];

            if (buttons.length === 0) {
                return `<p class="text-gray-500">Tidak ada opsi update status tersedia.</p>`;
            }

            const buttonsHtml = buttons.map(btn => `
            <button onclick="window.selectStatus('${btn.value}')"
                    class="status-btn px-4 py-2 ${btn.color} text-white rounded-lg transition-all text-sm"
                    data-status="${btn.value}">
                ${btn.label}
            </button>
        `).join('');

            return `
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Baru</label>
                    <div class="flex gap-2 flex-wrap">
                        ${buttonsHtml}
                    </div>
                    <input type="hidden" id="selectedStatus" value="${currentStatus}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Umpan Balik*</label>
                    <textarea
                        id="umpanBalikText"
                        class="w-full p-3 border border-[#D1D8BE] rounded-lg focus:outline-none focus:border-[#819A91] resize-none"
                        rows="3"
                        placeholder="Tulis umpan balik untuk siswa..."
                    ></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Tambahan (opsional)</label>
                    <textarea
                        id="keteranganText"
                        class="w-full p-3 border border-[#D1D8BE] rounded-lg focus:outline-none focus:border-[#819A91] resize-none"
                        rows="2"
                        placeholder="Keterangan tambahan (jika ada)..."
                    ></textarea>
                </div>

                <button onclick="window.updateStatusWithFeedback()" class="w-full px-4 py-2 bg-[#819A91] text-white rounded-lg hover:bg-[#5C6B65] transition-all font-medium">
                    Update Status & Kirim Umpan Balik
                </button>
            </div>
        `;
        }

        // =============================================
        // AKSI ADMIN
        // =============================================

        /**
         * Pilih status dan highlight button
         * @param {string} status
         */
        window.selectStatus = function(status) {
            // Update hidden input
            document.getElementById('selectedStatus').value = status;

            // Highlight selected button
            document.querySelectorAll('.status-btn').forEach(btn => {
                if (btn.dataset.status === status) {
                    btn.classList.add('ring-4', 'ring-opacity-50');
                } else {
                    btn.classList.remove('ring-4', 'ring-opacity-50');
                }
            });
        };

        /**
         * Update status aspirasi dengan umpan balik
         */
        window.updateStatusWithFeedback = function() {
            if (!currentAspirasiId) {
                alert('Tidak ada data yang dipilih.');
                return;
            }

            const status = document.getElementById('selectedStatus').value;
            const umpanBalik = document.getElementById('umpanBalikText')?.value.trim() ?? '';
            const keterangan = document.getElementById('keteranganText')?.value.trim() ?? '';

            if (!umpanBalik) {
                alert('Mohon isi umpan balik terlebih dahulu.');
                return;
            }

            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                alert('CSRF token not found');
                return;
            }

            fetch(`/admin/aspirasi/${currentAspirasiId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        status: status,
                        umpan_balik: umpanBalik,
                        keterangan: keterangan || null,
                    }),
                })
                .then(res => {
                    // Handle both success and error responses
                    return res.json().then(data => ({
                        status: res.status,
                        data
                    }));
                })
                .then(({
                    status,
                    data
                }) => {
                    if (status === 200 && data.success) {
                        showStatusToast(data.message || 'Status berhasil diperbarui!');
                        setTimeout(() => {
                            location.reload();
                        }, 700);
                    } else {
                        // Handle validation errors or business logic errors
                        showStatusToast(data.message || 'Gagal memperbarui status.', 'error');
                    }
                })
                .catch(err => {
                    console.error('Gagal update status:', err);
                    showStatusToast('Gagal memperbarui status. Coba lagi.', 'error');
                });
        };

        /**
         * Kirim feedback/respon admin ke siswa (tanpa ubah status)
         */
        window.sendFeedbackOnly = function() {
            if (!currentAspirasiId) return;

            const umpanBalik = document.getElementById('feedbackOnlyText')?.value.trim() ?? '';
            const keterangan = document.getElementById('keteranganOnlyText')?.value.trim() ?? '';

            if (!umpanBalik) {
                alert('Mohon isi umpan balik terlebih dahulu.');
                return;
            }

            // Get CSRF token from meta tag
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                alert('CSRF token not found');
                return;
            }

            fetch(`/admin/aspirasi/${currentAspirasiId}/feedback`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        umpan_balik: umpanBalik,
                        keterangan: keterangan || null
                    }),
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        showStatusToast(data.message || 'Umpan balik berhasil dikirim!');
                        window.showDetail(currentAspirasiId); // refresh isi modal
                    } else {
                        showStatusToast(data.message || 'Gagal mengirim umpan balik.', 'error');
                    }
                })
                .catch(err => {
                    console.error('Gagal kirim feedback:', err);
                    showStatusToast('Gagal mengirim umpan balik. Coba lagi.', 'error');
                });
        };

        // =============================================
        // EVENT LISTENER
        // =============================================

        // Tutup modal kalau klik area luar modal
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('detailModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) window.hideModal();
                });
            }

            // Initialize Lucide icons if available
            if (typeof lucide !== 'undefined' && lucide.createIcons) {
                lucide.createIcons();
            }
        });
    </script>
@endsection
