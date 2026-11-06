<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SpeakUp — Sistem Aspirasi Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Serif+Display:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --c1: #819A91;
            --c2: #A7C1A8;
            --c3: #D1D8BE;
            --c4: #EEEFE0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--c4);
            color: #2d3b35;
            height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .serif {
            font-family: 'DM Serif Display', serif;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
        }

        .blob {
            position: fixed;
            border-radius: 9999px;
            filter: blur(80px);
            opacity: 0.45;
            z-index: 0;
        }

        @keyframes fade-up {
            from {
                opacity: 0;
                transform: translateY(18px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .au {
            animation: fade-up 0.7s ease both;
        }

        .au-1 {
            animation-delay: 0.05s;
        }

        .au-2 {
            animation-delay: 0.15s;
        }

        .au-3 {
            animation-delay: 0.25s;
        }

        .au-4 {
            animation-delay: 0.38s;
        }

        .card {
            background: rgba(255, 255, 255, 0.45);
            border: 1px solid rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-radius: 20px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(129, 154, 145, 0.2);
        }

        .badge {
            background: var(--c1);
            color: #fff;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 4px 12px;
            border-radius: 9999px;
        }

        .btn-primary {
            background: var(--c1);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 14px;
            padding: 12px 28px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            transition: background 0.2s ease, transform 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: #6b8880;
            transform: scale(1.03);
        }

        .btn-outline {
            background: transparent;
            color: var(--c1);
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 14px;
            padding: 11px 24px;
            border-radius: 50px;
            border: 1.5px solid var(--c1);
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn-outline:hover {
            background: rgba(129, 154, 145, 0.1);
        }

        .icon-wrap {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .icon-wrap svg {
            width: 22px;
            height: 22px;
            stroke-width: 2;
        }

        .divider {
            width: 1px;
            background: rgba(129, 154, 145, 0.25);
            align-self: stretch;
        }

        .step-num {
            font-family: 'DM Serif Display', serif;
            font-size: 13px;
            color: var(--c1);
            opacity: 0.7;
        }

        .step-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--c3);
        }

        .step-icon svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
            color: #2d3b35;
        }
    </style>
</head>

<body>

    <!-- decorative blobs -->
    <div class="blob" style="width:380px;height:380px;background:#A7C1A8;top:-100px;right:-80px;"></div>
    <div class="blob" style="width:300px;height:300px;background:#D1D8BE;bottom:-60px;left:-60px;"></div>

    <!-- NAVBAR -->
    <nav class="relative z-10 flex items-center justify-between px-10 py-5 au au-1">
        <div class="flex items-center gap-2.5">
            <img id="logo-img" src="{{ asset('assets/image/konyol.png') }}" alt="SpeakUp Logo"
                style="width:34px; height:34px; border-radius:10px; object-fit:cover;" />
            <span class="serif font-bold text-xl" style="color:#2d3b35;">SpeakUp</span>
        </div>
        <div class="flex items-center gap-3">
            <a href="/login" class="btn-primary" style="font-size:13px;padding:8px 20px;text-decoration:none;">
                Mulai Sekarang
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <main class="relative z-10 flex-1 flex items-center px-10 gap-10" style="min-height:0;">

        <!-- LEFT: Hero -->
        <div class="flex-1 flex flex-col justify-center" style="max-width:520px;">
            <div class="au au-2 mb-4">
                <span class="badge">Sistem Aspirasi Siswa Digital</span>
            </div>
            <h1 class="serif au au-2"
                style="font-size:clamp(2rem,3.5vw,3rem);line-height:1.15;color:#1e2e28;margin-bottom:14px;">
                Suaramu <em>penting.</em><br />Kami siap mendengar.
            </h1>
            <p class="au au-3" style="font-size:15px;line-height:1.7;color:#4a6059;max-width:420px;margin-bottom:24px;">
                SpeakUp adalah platform aspirasi siswa yang memudahkan kamu menyampaikan saran, keluhan, dan ide kepada
                pihak sekolah — secara transparan, aman, dan terstruktur.
            </p>

            <!-- stat strip -->
            <div class="flex items-center gap-6 mt-8 au au-4">
                <div>
                    <p class="serif" style="font-size:1.5rem;color:var(--c1);">120+</p>
                    <p style="font-size:12px;color:#7a9488;">Aspirasi masuk</p>
                </div>
                <div class="divider"></div>
                <div>
                    <p class="serif" style="font-size:1.5rem;color:var(--c1);">94%</p>
                    <p style="font-size:12px;color:#7a9488;">Ditindaklanjuti</p>
                </div>
                <div class="divider"></div>
                <div>
                    <p class="serif" style="font-size:1.5rem;color:var(--c1);">3 Hari</p>
                    <p style="font-size:12px;color:#7a9488;">Rata-rata respons</p>
                </div>
            </div>
        </div>

        <!-- RIGHT: Feature cards + How it works -->
        <div class="flex-1 flex flex-col gap-4" style="max-width:520px;">

            <!-- Feature row -->
            <div class="flex gap-4 au au-3">
                <div class="card flex-1 p-5">
                    <div class="icon-wrap mb-3" style="background:rgba(167,193,168,0.3);">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#2d3b35">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-sm mb-1" style="color:#2d3b35;">Kirim Aspirasi</p>
                    <p style="font-size:12.5px;color:#617d74;line-height:1.6;">Sampaikan saran atau keluhan kapan saja,
                        bisa anonim maupun atas nama.</p>
                </div>
                <div class="card flex-1 p-5">
                    <div class="icon-wrap mb-3" style="background:rgba(209,216,190,0.5);">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#2d3b35">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <p class="font-semibold text-sm mb-1" style="color:#2d3b35;">Pantau Status</p>
                    <p style="font-size:12.5px;color:#617d74;line-height:1.6;">Lacak perkembangan aspirasimu secara
                        real-time dengan kode unik.</p>
                </div>
                <div class="card flex-1 p-5">
                    <div class="icon-wrap mb-3" style="background:rgba(129,154,145,0.25);">
                        <svg fill="none" viewBox="0 0 24 24" stroke="#2d3b35">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                        </svg>
                    </div>
                    <p class="font-semibold text-sm mb-1" style="color:#2d3b35;">Respons Resmi</p>
                    <p style="font-size:12.5px;color:#617d74;line-height:1.6;">Pihak sekolah merespons langsung lewat
                        sistem, tercatat dan transparan.</p>
                </div>
            </div>

            <!-- How it works -->
            <div class="card p-6 au au-4">
                <p class="font-semibold text-sm mb-4" style="color:#2d3b35;">Cara Kerja</p>
                <div class="flex items-start gap-4">
                    <div class="flex flex-col items-center gap-2">
                        <div class="step-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </div>
                        <div style="width:1px;height:24px;background:rgba(129,154,145,0.3);"></div>
                        <div class="step-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293h3.172a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293H20" />
                            </svg>
                        </div>
                        <div style="width:1px;height:24px;background:rgba(129,154,145,0.3);"></div>
                        <div class="step-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex flex-col justify-between" style="gap:18px;">
                        <div>
                            <p class="step-num">01</p>
                            <p class="font-medium text-sm" style="color:#2d3b35;">Isi formulir aspirasi</p>
                            <p style="font-size:12px;color:#7a9488;">Pilih kategori & tulis aspirasimu</p>
                        </div>
                        <div>
                            <p class="step-num">02</p>
                            <p class="font-medium text-sm" style="color:#2d3b35;">Admin menerima & memproses</p>
                            <p style="font-size:12px;color:#7a9488;">Aspirasi diteruskan ke pihak terkait</p>
                        </div>
                        <div>
                            <p class="step-num">03</p>
                            <p class="font-medium text-sm" style="color:#2d3b35;">Kamu mendapat respons</p>
                            <p style="font-size:12px;color:#7a9488;">Notifikasi & balasan resmi dikirimkan</p>
                        </div>
                    </div>

                    <!-- right side: quote card -->
                    <div class="flex-1 flex items-center justify-end">
                        <div
                            style="background:rgba(167,193,168,0.25);border:1px solid rgba(167,193,168,0.5);border-radius:16px;padding:16px 18px;max-width:180px;">
                            <p style="font-size:12.5px;color:#4a6059;line-height:1.65;font-style:italic;">"Akhirnya ada
                                tempat yang beneran dengerin suara siswa."</p>
                            <p class="font-semibold mt-2" style="font-size:11px;color:var(--c1);">— Siswa Kelas XI RPL
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="relative z-10 flex items-center justify-between px-10 py-4"
        style="border-top:1px solid rgba(129,154,145,0.15);">
        <p style="font-size:12px;color:#9aafa9;">UKK SMK Kelas 12 — Rekayasa Perangkat Lunak</p>
        <p style="font-size:12px;color:#9aafa9;">© 2025 SpeakUp. All rights reserved.</p>
    </footer>

</body>

</html>
