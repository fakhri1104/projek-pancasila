@extends('layouts.layout_base')

@section('content')
    <div class="flex-1 flex flex-col h-full overflow-hidden">

        <!-- HEADER -->
        <header
            class="bg-white/50 backdrop-blur-lg border-b border-[#819A91]/15 px-8 py-5 flex items-center justify-between">
            <div>
                <h1 class="font-['DM_Serif_Display'] text-2xl font-bold text-[#1e2e28]">Daftar Aspirasi</h1>
                <p class="text-xs text-[#7a9488] mt-0.5">Kelola dan tanggapi aspirasi dari siswa</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="bg-white/80 border border-[#819A91]/20 rounded-xl px-4 py-2.5 flex items-center gap-2.5 w-80">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#819A91" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Cari aspirasi..."
                        class="bg-transparent border-none outline-none text-sm text-[#2d3b35] w-full"
                        onkeyup="filterAspirasi(this.value)">
                </div>

                <button
                    class="bg-[#819A91] text-white px-5 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 hover:bg-[#6b8279] transition-all">
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </button>
            </div>
        </header>

        <!-- CONTENT AREA -->
        <div class="flex-1 p-6 overflow-hidden flex flex-col">

            <!-- Stats Cards -->
            <div class="grid grid-cols-4 gap-4 mb-6">
                <div class="bg-white/70 backdrop-blur-lg border border-white/80 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-[#7a9488] font-medium">Total Aspirasi</span>
                        <div class="w-8 h-8 bg-[#819A91]/15 rounded-lg flex items-center justify-center">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#819A91"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3z" />
                            </svg>
                        </div>
                    </div>
                    <p class="font-['DM_Serif_Display'] text-2xl font-bold text-[#2d3b35]">{{ $totalAspirasi }}</p>
                    <p class="text-[11px] text-[#7a9488]">Total seluruhnya</p>
                </div>

                <div class="bg-white/70 backdrop-blur-lg border border-white/80 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-[#7a9488] font-medium">Belum Diproses</span>
                        <div class="w-8 h-8 bg-blue-500/15 rounded-lg flex items-center justify-center">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#3b82f6"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="font-['DM_Serif_Display'] text-2xl font-bold text-[#1e40af]">{{ $menunggu }}</p>
                    <p class="text-[11px] text-[#7a9488]">Perlu ditindaklanjuti</p>
                </div>

                <div class="bg-white/70 backdrop-blur-lg border border-white/80 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-[#7a9488] font-medium">Sedang Diproses</span>
                        <div class="w-8 h-8 bg-yellow-500/15 rounded-lg flex items-center justify-center">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#f59e0b"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                        </div>
                    </div>
                    <p class="font-['DM_Serif_Display'] text-2xl font-bold text-[#92400e]">{{ $diproses }}</p>
                    <p class="text-[11px] text-[#7a9488]">Dalam penanganan</p>
                </div>

                <div class="bg-white/70 backdrop-blur-lg border border-white/80 rounded-2xl p-4">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-[#7a9488] font-medium">Selesai</span>
                        <div class="w-8 h-8 bg-green-500/15 rounded-lg flex items-center justify-center">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="#10b981"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <p class="font-['DM_Serif_Display'] text-2xl font-bold text-[#065f46]">{{ $selesai }}</p>
                    <p class="text-[11px] text-[#7a9488]">
                        {{ $totalAspirasi > 0 ? number_format(($selesai / $totalAspirasi) * 100, 1) : 0 }}% terselesaikan</p>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white/70 backdrop-blur-lg border border-white/80 rounded-2xl flex flex-col overflow-hidden">
                <!-- Table Header -->
                <div
                    class="grid grid-cols-[60px_1fr_140px_120px_100px_80px] items-center px-6 py-4 bg-[#819A91]/10 text-[11px] font-semibold text-[#7a9488] uppercase tracking-wider border-b border-[#819A91]/10">
                    <div>ID</div>
                    <div>Aspirasi</div>
                    <div>Kategori</div>
                    <div>Tanggal</div>
                    <div>Status</div>
                    <div>Aksi</div>
                </div>

                <!-- Rows Container -->
                <div class="divide-y divide-[#819A91]/10" id="aspirasiTableBody">
                    @forelse($aspirasi as $item)
                        <div
                            class="grid grid-cols-[60px_1fr_140px_120px_100px_80px] items-center px-6 py-4 hover:bg-[#819A91]/5 transition-colors">
                            <div class="font-mono text-xs text-[#7a9488]">#{{ str_pad($item->id, 3, '0', STR_PAD_LEFT) }}
                            </div>
                            <div>
                                <p class="font-semibold text-sm text-[#2d3b35] mb-1">{{ Str::limit($item->judul, 50) }}</p>
                                <p class="text-xs text-[#7a9488] truncate max-w-xs">{{ Str::limit($item->deskripsi, 60) }}
                                </p>
                            </div>
                            <div>
                                <span class="text-xs px-3 py-1.5 bg-[#A7C1A8]/30 text-[#2d3b35] rounded-md font-medium">
                                    {{ $item->kategori->nama ?? 'Tanpa Kategori' }}
                                </span>
                            </div>
                            <div class="text-xs text-[#617d74]">
                                {{ $item->tanggal_kirim->format('d M Y') }}
                            </div>
                            <div>
                                <span
                                    class="text-xs font-semibold px-3 py-1.5 rounded-full uppercase tracking-wider
                            @if ($item->status === 'menunggu') bg-blue-100 text-blue-700
                            @elseif($item->status === 'diproses') bg-yellow-100 text-yellow-700
                            @elseif($item->status === 'selesai') bg-green-100 text-green-700
                            @else bg-red-100 text-red-700 @endif">
                                    {{ $item->status }}
                                </span>
                            </div>
                            <div>
                                <button onclick="showDetail({{ $item->id }})"
                                    class="flex items-center gap-1.5 text-xs font-semibold text-[#819A91] hover:text-[#5c6b65] transition-colors px-3 py-1.5 rounded-lg hover:bg-[#819A91]/10">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Detail
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-6 py-12 text-center">
                            <div
                                class="w-16 h-16 mx-auto bg-[#819A91]/10 rounded-full flex items-center justify-center mb-4">
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="#819A91"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-3 3-3-3z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-[#2d3b35] mb-1">Belum ada aspirasi</p>
                            <p class="text-xs text-[#7a9488]">Aspirasi yang masuk akan muncul di sini</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-4">
                <p class="text-xs text-[#7a9488]">
                    Menampilkan {{ $aspirasi->firstItem() ?? 0 }}-{{ $aspirasi->lastItem() ?? 0 }} dari
                    {{ $aspirasi->total() }} aspirasi
                </p>
                <div class="flex items-center gap-2">
                    @if ($aspirasi->onFirstPage())
                        <button
                            class="w-9 h-9 rounded-xl border border-[#819A91]/20 flex items-center justify-center opacity-50 cursor-not-allowed"
                            disabled>
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                    @else
                        <a href="{{ $aspirasi->previousPageUrl() }}"
                            class="w-9 h-9 rounded-xl border border-[#819A91]/20 flex items-center justify-center hover:bg-[#819A91]/10 transition-all">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    @endif

                    @foreach ($aspirasi->getUrlRange(1, $aspirasi->lastPage()) as $page => $url)
                        @if ($page == $aspirasi->currentPage())
                            <button
                                class="w-9 h-9 rounded-xl bg-[#819A91] text-white text-sm font-semibold">{{ $page }}</button>
                        @else
                            <a href="{{ $url }}"
                                class="w-9 h-9 rounded-xl border border-[#819A91]/20 text-[#617d74] text-sm font-medium hover:bg-[#819A91]/10 transition-all flex items-center justify-center">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach

                    @if ($aspirasi->hasMorePages())
                        <a href="{{ $aspirasi->nextPageUrl() }}"
                            class="w-9 h-9 rounded-xl border border-[#819A91]/20 flex items-center justify-center hover:bg-[#819A91]/10 transition-all">
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <button
                            class="w-9 h-9 rounded-xl border border-[#819A91]/20 flex items-center justify-center opacity-50 cursor-not-allowed"
                            disabled>
                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <!-- ===== MODAL DETAIL ASPIRASI ===== -->
    <div id="detailModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl">

            <!-- Header Modal -->
            <div class="p-6 border-b border-[#D1D8BE]/50 flex justify-between items-center sticky top-0 bg-white z-10">
                <h3 class="text-xl font-bold text-[#819A91]">Detail Aspirasi</h3>
                <button onclick="hideModal()"
                    class="w-8 h-8 flex items-center justify-center rounded-lg hover:bg-gray-100 text-gray-400 hover:text-gray-600 transition-colors">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Konten Modal (diisi via JS) -->
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

        const STATUS_BADGE = {
            menunggu: 'bg-blue-100 text-blue-700',
            diproses: 'bg-yellow-100 text-yellow-700',
            selesai: 'bg-green-100 text-green-700',
            ditolak: 'bg-red-100 text-red-700',
        };

        function formatTanggal(dateString) {
            if (!dateString) return '-';
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
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
        // FILTER
        // =============================================

        function filterAspirasi(search) {
            const rows = document.querySelectorAll('#aspirasiTableBody > div');
            const searchLower = search.toLowerCase();
            rows.forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(searchLower) ? '' : 'none';
            });
        }

        // =============================================
        // MODAL
        // =============================================

        function showDetail(id) {
            currentAspirasiId = id;

            const modal = document.getElementById('detailModal');
            const modalContent = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            modalContent.innerHTML = `
            <div class="flex justify-center items-center py-12">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-[#819A91]"></div>
            </div>
        `;

            fetch('/admin/aspirasi/' + id)
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        renderModalContent(data.aspirasi);
                    } else {
                        modalContent.innerHTML = '<div class="text-center py-8 text-red-500">Gagal memuat data: ' + (
                            data.message || 'Unknown error') + '</div>';
                    }
                })
                .catch(err => {
                    console.error('Gagal fetch detail:', err);
                    modalContent.innerHTML =
                        '<div class="text-center py-8 text-red-500">Gagal memuat data. Coba lagi.<br><small class="text-xs">' +
                        err.message + '</small></div>';
                });
        }

        function hideModal() {
            document.getElementById('detailModal').classList.add('hidden');
            currentAspirasiId = null;
        }

        function renderModalContent(aspirasi) {
            const modalContent = document.getElementById('modalContent');

            const fotosHtml = aspirasi.foto_pengaduan?.length ?
                aspirasi.foto_pengaduan.map(foto => `
                <img src="${foto.url_foto}" class="w-40 h-40 object-cover rounded-lg cursor-pointer hover:opacity-90 transition-opacity" alt="Foto bukti" onclick="window.open('${foto.url_foto}', '_blank')">
              `).join('') :
                `<div class="w-40 h-40 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">Tidak ada foto</div>`;

            const riwayatHtml = aspirasi.riwayat_status?.length ?
                aspirasi.riwayat_status.map((riwayat, index) => `
                <div class="border-l-2 border-[#819A91] pl-4 pb-4 ${index === aspirasi.riwayat_status.length - 1 ? '' : 'mb-4'}">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-3 py-1 ${STATUS_BADGE[riwayat.status] ?? 'bg-gray-100 text-gray-700'} rounded-full text-xs font-semibold capitalize">
                            ${riwayat.status}
                        </span>
                        <span class="text-xs text-gray-500">${formatTanggal(riwayat.created_at)}</span>
                    </div>
                    <p class="text-sm text-gray-700 mb-1">${riwayat.umpan_balik || '-'}</p>
                    ${riwayat.keterangan ? `<p class="text-xs text-gray-500 italic">${riwayat.keterangan}</p>` : ''}
                    <p class="text-xs text-gray-400 mt-1">oleh ${riwayat.admin?.nama ?? 'Admin'}</p>
                </div>
              `).join('') :
                `<div class="text-center py-4 text-gray-500 text-sm">Belum ada riwayat update</div>`;

            modalContent.innerHTML = `
            <!-- Info utama -->
            <div class="flex justify-between items-start gap-4">
                <div>
                    <h4 class="text-lg font-semibold text-[#1e2e28]">${aspirasi.judul || '-'}</h4>
                    <p class="text-sm text-gray-500 mt-1">
                        Dikirim oleh <strong>${aspirasi.siswa?.nama ?? '-'}</strong> &bull; ${formatTanggal(aspirasi.tanggal_kirim)}
                    </p>
                </div>
                <span class="shrink-0 px-3 py-1 ${STATUS_BADGE[aspirasi.status] ?? 'bg-gray-100 text-gray-700'} rounded-full text-xs font-semibold capitalize">
                    ${aspirasi.status || '-'}
                </span>
            </div>

            <!-- Deskripsi -->
            <div class="bg-[#f4f6ee] p-4 rounded-xl">
                <p class="text-gray-700 leading-relaxed text-sm">${aspirasi.deskripsi || '-'}</p>
            </div>

            <!-- Lokasi & Kategori -->
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-gray-400 text-xs mb-1">Lokasi</p>
                    <p class="font-semibold text-[#2d3b35]">${aspirasi.lokasi || '-'}</p>
                </div>
                <div class="bg-gray-50 rounded-xl p-3">
                    <p class="text-gray-400 text-xs mb-1">Kategori</p>
                    <p class="font-semibold text-[#2d3b35]">${aspirasi.kategori?.nama ?? '-'}</p>
                </div>
            </div>

            <!-- Foto Bukti -->
            <div class="border-t border-gray-100 pt-4">
                <h5 class="font-semibold text-sm text-[#2d3b35] mb-3">Foto Bukti</h5>
                <div class="flex gap-2 flex-wrap">${fotosHtml}</div>
            </div>

            <!-- Riwayat Status -->
            <div class="border-t border-gray-100 pt-4">
                <h5 class="font-semibold text-sm text-[#2d3b35] mb-3">Riwayat Status & Umpan Balik</h5>
                <div class="max-h-60 overflow-y-auto pr-1">
                    ${riwayatHtml}
                </div>
            </div>

            <!-- Update Status -->
            <div class="border-t border-gray-100 pt-4">
                <h5 class="font-semibold text-sm text-[#2d3b35] mb-3">Update Status</h5>
                ${getUpdateStatusSection(aspirasi.status)}
            </div>
        `;
        }

        function getUpdateStatusSection(currentStatus) {
            if (currentStatus === 'selesai' || currentStatus === 'ditolak') {
                return `
                <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center">
                    <p class="text-gray-600 font-medium text-sm">Status <span class="capitalize">"${currentStatus}"</span> sudah final</p>
                    <p class="text-xs text-gray-400 mt-1">Status ini tidak dapat diubah lagi</p>
                </div>
            `;
            }

            const allowedStatuses = {
                'menunggu': [{
                        value: 'diproses',
                        label: 'Proses',
                        color: 'bg-yellow-500 hover:bg-yellow-600'
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
            if (buttons.length === 0) return '<p class="text-gray-500 text-sm">Tidak ada opsi update status tersedia.</p>';

            const buttonsHtml = buttons.map(btn => `
            <button onclick="selectStatus('${btn.value}')"
                    class="status-btn px-4 py-2 ${btn.color} text-white rounded-lg transition-all text-sm font-medium"
                    data-status="${btn.value}">
                ${btn.label}
            </button>
        `).join('');

            return `
            <div class="space-y-3">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pilih Status Baru</label>
                    <div class="flex gap-2 flex-wrap">
                        ${buttonsHtml}
                    </div>
                    <input type="hidden" id="selectedStatus" value="${currentStatus}">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Umpan Balik <span class="text-red-400">*</span></label>
                    <textarea
                        id="umpanBalikText"
                        class="w-full p-3 border border-[#D1D8BE] rounded-xl focus:outline-none focus:border-[#819A91] resize-none text-sm"
                        rows="3"
                        placeholder="Tulis umpan balik untuk siswa..."></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Keterangan Tambahan <span class="text-gray-400">(opsional)</span></label>
                    <textarea
                        id="keteranganText"
                        class="w-full p-3 border border-[#D1D8BE] rounded-xl focus:outline-none focus:border-[#819A91] resize-none text-sm"
                        rows="2"
                        placeholder="Keterangan tambahan jika ada..."></textarea>
                </div>

                <button onclick="updateStatusWithFeedback()" class="w-full px-4 py-2.5 bg-[#819A91] text-white rounded-xl hover:bg-[#5C6B65] transition-all font-semibold text-sm">
                    Update Status & Kirim Umpan Balik
                </button>
            </div>
        `;
        }

        // =============================================
        // AKSI ADMIN
        // =============================================

        function selectStatus(status) {
            document.getElementById('selectedStatus').value = status;
            document.querySelectorAll('.status-btn').forEach(btn => {
                if (btn.dataset.status === status) {
                    btn.classList.add('ring-4', 'ring-black/20');
                } else {
                    btn.classList.remove('ring-4', 'ring-black/20');
                }
            });
        }

        function updateStatusWithFeedback() {
            if (!currentAspirasiId) return;

            const status = document.getElementById('selectedStatus').value;
            const umpanBalik = document.getElementById('umpanBalikText')?.value.trim() ?? '';
            const keterangan = document.getElementById('keteranganText')?.value.trim() ?? '';

            if (!umpanBalik) {
                alert('Mohon isi umpan balik terlebih dahulu.');
                return;
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            if (!csrfToken) {
                alert('CSRF token not found');
                return;
            }

            fetch('/admin/aspirasi/' + currentAspirasiId + '/update-status', {
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
                .then(res => res.json().then(data => ({
                    status: res.status,
                    data
                })))
                .then(({
                    status: httpStatus,
                    data
                }) => {
                    if (httpStatus === 200 && data.success) {
                        showStatusToast(data.message || 'Status berhasil diperbarui!');
                        setTimeout(() => {
                            location.reload();
                        }, 700);
                    } else {
                        showStatusToast(data.message || 'Gagal memperbarui status.', 'error');
                    }
                })
                .catch(err => {
                    console.error('Gagal update status:', err);
                    showStatusToast('Gagal memperbarui status. Coba lagi.', 'error');
                });
        }

        // =============================================
        // EVENT LISTENERS
        // =============================================

        document.addEventListener('DOMContentLoaded', function() {
            // Tutup modal kalau klik area luar modal
            const modal = document.getElementById('detailModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) hideModal();
                });
            }

            // Tutup modal dengan tombol ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') hideModal();
            });
        });
    </script>
@endsection
