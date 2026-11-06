===== MODAL DETAIL ASPIRASI =====
<div id="detailModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">

        {{-- Header Modal --}}
        <div class="p-6 border-b border-[#D1D8BE]/50 flex justify-between items-center">
            <h3 class="text-xl font-bold text-[#819A91]">Detail Aspirasi</h3>
            <button onclick="hideModal()" class="text-gray-400 hover:text-gray-600">
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

<script>
    /**
     * Render isi modal berdasarkan data aspirasi
     * @param {Object} aspirasi
     */
    function renderModalContent(aspirasi) {
        const modalContent = document.getElementById('modalContent');

        // Buat HTML foto bukti
        const fotosHtml = aspirasi.foto_pengaduan?.length
            ? aspirasi.foto_pengaduan.map(foto => `
                <img src="${foto.url_foto}" class="w-24 h-24 object-cover rounded-lg" alt="Foto bukti">
              `).join('')
            : `<div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                   <i data-lucide="image" class="w-8 h-8"></i>
               </div>`;

        // Buat HTML riwayat status (jika ada)
        const riwayatHtml = aspirasi.riwayat_status?.length
            ? aspirasi.riwayat_status.map((riwayat, index) => `
                <div class="border-l-2 border-[#819A91] pl-4 pb-4 ${index === aspirasi.riwayat_status.length - 1 ? '' : 'mb-4'}">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-3 py-1 ${STATUS_BADGE[riwayat.status] ?? ''} rounded-full text-xs font-medium capitalize">
                            ${riwayat.status}
                        </span>
                        <span class="text-xs text-gray-500">${formatTanggal(riwayat.created_at)}</span>
                    </div>
                    <p class="text-sm text-gray-700 mb-1">${riwayat.umpan_balik}</p>
                    ${riwayat.keterangan ? `<p class="text-xs text-gray-500 italic">${riwayat.keterangan}</p>` : ''}
                    <p class="text-xs text-gray-400 mt-1">oleh ${riwayat.admin?.nama ?? 'Admin'}</p>
                </div>
              `).join('')
            : `<div class="text-center py-4 text-gray-500 text-sm">
                   <i data-lucide="clock" class="w-8 h-8 mx-auto mb-2 text-gray-400"></i>
                   <p>Belum ada riwayat update</p>
               </div>`;

        modalContent.innerHTML = `
            {{-- Info utama --}}
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="text-lg font-semibold">${aspirasi.judul}</h4>
                    <p class="text-sm text-gray-500">
                        Dikirim oleh ${aspirasi.siswa?.nama ?? '-'} • ${formatTanggal(aspirasi.tanggal_kirim)}
                    </p>
                </div>
                <span class="px-3 py-1 ${STATUS_BADGE[aspirasi.status] ?? ''} rounded-full text-sm font-medium capitalize">
                    ${aspirasi.status}
                </span>
            </div>

            {{-- Deskripsi --}}
            <div class="bg-[#EEEFE0] p-4 rounded-lg">
                <p class="text-gray-700 leading-relaxed">${aspirasi.deskripsi}</p>
            </div>

            {{-- Lokasi & Kategori --}}
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Lokasi</p>
                    <p class="font-semibold">${aspirasi.lokasi}</p>
                </div>
                <div>
                    <p class="text-gray-500">Kategori</p>
                    <p class="font-semibold">${aspirasi.kategori?.nama ?? '-'}</p>
                </div>
            </div>

            {{-- Foto Bukti --}}
            <div class="border-t border-[#D1D8BE]/30 pt-4">
                <h5 class="font-semibold mb-3">Foto Bukti</h5>
                <div class="flex gap-2 flex-wrap">${fotosHtml}</div>
            </div>

            {{-- Riwayat Status & Umpan Balik --}}
            <div class="border-t border-[#D1D8BE]/30 pt-4">
                <h5 class="font-semibold mb-3">Riwayat Status & Umpan Balik</h5>
                <div class="max-h-60 overflow-y-auto">
                    ${riwayatHtml}
                </div>
            </div>

            {{-- Update Status --}}
            <div class="border-t border-[#D1D8BE]/30 pt-4">
                <h5 class="font-semibold mb-3">Update Status</h5>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Status Baru</label>
                        <div class="flex gap-2 flex-wrap">
                            <button onclick="selectStatus('menunggu')" class="status-btn px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-all text-sm" data-status="menunggu">
                                Menunggu
                            </button>
                            <button onclick="selectStatus('diproses')" class="status-btn px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all text-sm" data-status="diproses">
                                Proses
                            </button>
                            <button onclick="selectStatus('selesai')" class="status-btn px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all text-sm" data-status="selesai">
                                Selesai
                            </button>
                            <button onclick="selectStatus('ditolak')" class="status-btn px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-all text-sm" data-status="ditolak">
                                Tolak
                            </button>
                        </div>
                        <input type="hidden" id="selectedStatus" value="${aspirasi.status}">
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

                    <button onclick="updateStatusWithFeedback()" class="w-full px-4 py-2 bg-[#819A91] text-white rounded-lg hover:bg-[#5C6B65] transition-all font-medium">
                        Update Status & Kirim Umpan Balik
                    </button>
                </div>
            </div>
        `;
    }
</script>
