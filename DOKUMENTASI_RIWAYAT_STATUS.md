# Sistem Riwayat Status dan Umpan Balik

## Deskripsi
Sistem ini memungkinkan admin untuk memberikan update status dan umpan balik berkali-kali untuk setiap aspirasi atau pengaduan dari siswa. Setiap kali admin memberikan umpan balik, akan tersimpan dalam riwayat dengan timestamp dan informasi admin yang memberikan feedback.

## Fitur Utama
1. ✅ Admin bisa update status berkali-kali
2. ✅ Admin bisa memberikan umpan balik berkali-kali
3. ✅ Setiap umpan balik tersimpan dengan timestamp
4. ✅ Setiap umpan balik mencatat admin yang memberi feedback
5. ✅ Riwayat lengkap semua status dan umpan balik tersimpan
6. ✅ Mendukung Aspirasi dan Pengaduan

## Database Schema

### Tabel: riwayat_status
```
- id (bigint, primary key)
- laporan_id (bigint) - ID dari aspirasi atau pengaduan
- laporan_type (string) - Model class (Aspirasi atau Pengaduan)
- admin_id (bigint) - ID admin yang memberikan update
- status (enum) - Status baru: menunggu, diproses, selesai, ditolak
- umpan_balik (text) - Umpan balik dari admin
- keterangan (text, nullable) - Keterangan tambahan
- created_at, updated_at (timestamp)
```

## API Endpoints

### Aspirasi

#### 1. Update Status Aspirasi
**POST** `/admin/aspirasi/{id}/update-status`

Request Body:
```json
{
    "status": "diproses",
    "umpan_balik": "Aspirasi anda sudah kami terima dan sedang ditindaklanjuti",
    "keterangan": "Tim akan melakukan survey lokasi besok"
}
```

Response:
```json
{
    "success": true,
    "message": "Status berhasil diperbarui dan umpan balik ditambahkan",
    "aspirasi": { ... },
    "riwayat": {
        "id": 1,
        "status": "diproses",
        "umpan_balik": "Aspirasi anda sudah kami terima...",
        "admin": {
            "id": 1,
            "nama": "Super Admin"
        },
        "created_at": "2026-02-21 15:30:00"
    }
}
```

#### 2. Tambah Umpan Balik (tanpa ubah status)
**POST** `/admin/aspirasi/{id}/feedback`

Request Body:
```json
{
    "umpan_balik": "Update: Survey lokasi sudah selesai dilakukan",
    "keterangan": "Proses perbaikan akan dimulai minggu depan"
}
```

Response:
```json
{
    "success": true,
    "message": "Umpan balik berhasil ditambahkan",
    "riwayat": { ... }
}
```

#### 3. Lihat Semua Riwayat Status
**GET** `/admin/aspirasi/{id}/riwayat`

Response:
```json
{
    "success": true,
    "riwayat": [
        {
            "id": 3,
            "status": "diproses",
            "umpan_balik": "Update: Survey lokasi sudah selesai",
            "admin": {
                "id": 1,
                "nama": "Super Admin"
            },
            "created_at": "2026-02-21 16:00:00"
        },
        {
            "id": 2,
            "status": "diproses",
            "umpan_balik": "Progress update kedua",
            "admin": {
                "id": 1,
                "nama": "Super Admin"
            },
            "created_at": "2026-02-21 15:45:00"
        },
        {
            "id": 1,
            "status": "diproses",
            "umpan_balik": "Aspirasi sedang ditindaklanjuti",
            "admin": {
                "id": 1,
                "nama": "Super Admin"
            },
            "created_at": "2026-02-21 15:30:00"
        }
    ]
}
```

### Pengaduan
Endpoint untuk pengaduan sama seperti aspirasi, tinggal ganti `/aspirasi/` dengan `/pengaduan/`:

- **POST** `/admin/pengaduan/{id}/update-status`
- **POST** `/admin/pengaduan/{id}/feedback`
- **GET** `/admin/pengaduan/{id}/riwayat`

## Cara Penggunaan

### 1. Jalankan Migration
```bash
php artisan migrate
```

### 2. Contoh Flow Admin

**Scenario**: Admin menerima aspirasi baru dan akan memberikan update berkala

**Step 1**: Update status menjadi "diproses"
```javascript
// Request pertama
fetch('/admin/aspirasi/1/update-status', {
    method: 'POST',
    body: JSON.stringify({
        status: 'diproses',
        umpan_balik: 'Terima kasih atas aspirasi Anda. Tim kami sedang meninjau masalah ini.'
    })
})
```

**Step 2**: Berikan update progress (status tetap "diproses")
```javascript
// Request kedua - beberapa hari kemudian
fetch('/admin/aspirasi/1/feedback', {
    method: 'POST',
    body: JSON.stringify({
        umpan_balik: 'Update: Tim sudah melakukan survey lokasi. Perbaikan dijadwalkan minggu depan.',
        keterangan: 'Survey dilakukan pada tanggal 20 Feb 2026'
    })
})
```

**Step 3**: Update lagi progress
```javascript
// Request ketiga - beberapa hari kemudian lagi
fetch('/admin/aspirasi/1/feedback', {
    method: 'POST',
    body: JSON.stringify({
        umpan_balik: 'Perbaikan sudah dimulai. Estimasi selesai dalam 3 hari.',
    })
})
```

**Step 4**: Ubah status menjadi "selesai"
```javascript
// Request keempat - setelah perbaikan selesai
fetch('/admin/aspirasi/1/update-status', {
    method: 'POST',
    body: JSON.stringify({
        status: 'selesai',
        umpan_balik: 'Perbaikan sudah selesai dilakukan. Terima kasih atas partisipasi Anda!',
        keterangan: 'Perbaikan selesai pada 25 Feb 2026'
    })
})
```

### 3. Menampilkan Riwayat di Frontend

#### Untuk Admin
```php
// Di controller
$aspirasi = Aspirasi::with('riwayatStatus.admin')->find($id);

// Di view
@foreach($aspirasi->riwayatStatus as $riwayat)
    <div class="riwayat-item">
        <div class="status-badge {{ $riwayat->status }}">{{ $riwayat->status_label }}</div>
        <p>{{ $riwayat->umpan_balik }}</p>
        <small>Oleh {{ $riwayat->admin->nama }} - {{ $riwayat->tanggal_umpan_balik }}</small>
    </div>
@endforeach
```

#### Untuk Siswa
```php
// Di controller
$aspirasi = Aspirasi::with('riwayatStatus.admin')->where('siswa_id', auth()->id())->find($id);

// Di view - siswa bisa melihat semua update dari admin
@foreach($aspirasi->riwayatStatus as $riwayat)
    <div class="timeline-item">
        <div class="timeline-badge status-{{ $riwayat->status }}">
            {{ $riwayat->status_label }}
        </div>
        <div class="timeline-content">
            <p class="feedback">{{ $riwayat->umpan_balik }}</p>
            @if($riwayat->keterangan)
                <p class="keterangan">{{ $riwayat->keterangan }}</p>
            @endif
            <small class="text-muted">
                {{ $riwayat->tanggal_umpan_balik }}
            </small>
        </div>
    </div>
@endforeach
```

## Model Relationships

### Aspirasi / Pengaduan Model
```php
public function riwayatStatus()
{
    return $this->morphMany(RiwayatStatus::class, 'laporan')->orderBy('created_at', 'desc');
}
```

### RiwayatStatus Model
```php
public function laporan()
{
    return $this->morphTo(); // Bisa Aspirasi atau Pengaduan
}

public function admin()
{
    return $this->belongsTo(Admin::class);
}
```

## Keuntungan Sistem Ini

1. **Transparansi**: Siswa bisa melihat semua update yang diberikan admin
2. **Akuntabilitas**: Setiap feedback tercatat siapa admin yang memberikan
3. **History Lengkap**: Semua perubahan status dan feedback tersimpan
4. **Fleksibel**: Admin bisa memberikan update sebanyak yang diperlukan
5. **Timeline Jelas**: Setiap feedback punya timestamp yang jelas

## Catatan Penting

- Field `respon_admin` di tabel `aspirasis` masih ada untuk backward compatibility, tapi sistem baru menggunakan tabel `riwayat_status`
- Admin harus login dengan guard `admin` agar `Auth::guard('admin')->id()` berfungsi
- Setiap kali update status atau feedback, otomatis tercatat waktu dan admin yang melakukan
- Riwayat ditampilkan dari yang terbaru (desc order by created_at)
