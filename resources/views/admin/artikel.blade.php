<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Artikel Jurnalistik</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- RESET & BASE --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        :root {
            --primary-emerald: #1da077;
            --soft-bg: #f8faf9;
            --sidebar-width: 260px;
        }
        body { background-color: var(--soft-bg); color: #333; }

        /* --- LAYOUT --- */
        .wrapper { display: flex; min-height: 100vh; }

        /* --- SIDEBAR (Konsisten) --- */
        .sidebar {
            width: var(--sidebar-width); background: #fff; display: flex;
            flex-direction: column; border-right: 1px solid #edf2f0;
            position: fixed; height: 100vh; z-index: 100;
        }
        .logo-area { padding: 30px; text-align: center; }
        .logo-area img { width: 120px; }
        .nav-menu { flex-grow: 1; padding: 0 20px; }
        .nav-link {
            display: flex; align-items: center; padding: 12px 15px;
            text-decoration: none; color: #7d8581; border-radius: 10px;
            margin-bottom: 8px; transition: 0.3s; font-weight: 500;
        }
        .nav-link.active { background-color: var(--primary-emerald); color: #fff; }
        .nav-link:hover:not(.active) { background-color: #f0fdf9; color: var(--primary-emerald); }

        .logout-area { padding: 20px; }
        .btn-logout {
            width: 100%; padding: 12px; background: transparent;
            border: 1.5px solid #d1d9d6; border-radius: 12px;
            cursor: pointer; color: #666; font-weight: 600;
        }

        /* --- MAIN CONTENT --- */
        .main-content { margin-left: var(--sidebar-width); flex-grow: 1; padding: 40px; }
        .header-top { display: flex; justify-content: flex-end; margin-bottom: 30px; }
        .admin-profile { display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 14px; }
        .admin-profile img { width: 35px; height: 35px; border-radius: 50%; }

        .page-header { margin-bottom: 25px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1a1c1b; }
        .page-header p { color: #9ca3af; font-size: 14px; }

        /* --- TABS --- */
        .tabs-container { display: flex; gap: 10px; margin-bottom: 25px; }
        .tab-btn {
            padding: 8px 25px; border-radius: 5px; border: 1px solid #ddd;
            background: #fff; cursor: pointer; color: #666; font-weight: 500; transition: 0.3s;
        }
        .tab-btn.active { border-color: var(--primary-emerald); color: var(--primary-emerald); }

        /* --- ARTIKEL GRID --- */
        .artikel-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px; margin-bottom: 30px;
        }

        .artikel-card {
            background: #fff; border-radius: 12px; overflow: hidden;
            border: 1px solid #eee; cursor: pointer; transition: transform 0.2s;
        }
        .artikel-card:hover { transform: translateY(-5px); }
        .artikel-img { width: 100%; height: 160px; object-fit: cover; }
        .artikel-body { padding: 15px; }
        .artikel-body h3 { font-size: 14px; font-weight: 700; margin-bottom: 8px; line-height: 1.4; color: #1a1c1b; }
        .artikel-date { font-size: 11px; color: #9ca3af; display: flex; align-items: center; gap: 5px; }

        /* --- DETAIL VIEW (Hidden by default) --- */
        #detail-view { display: none; background: #fff; border-radius: 20px; padding: 40px; margin-top: 20px; }
        .detail-header h2 { font-size: 24px; color: #1a1c1b; margin-bottom: 10px; }
        .detail-meta { color: #888; font-size: 14px; margin-bottom: 20px; }
        .detail-img { width: 300px; border-radius: 10px; margin-bottom: 25px; }
        .detail-content { line-height: 1.8; color: #444; font-size: 15px; margin-bottom: 30px; }
        .detail-footer { display: flex; justify-content: flex-end; gap: 15px; }

        /* --- FOOTER UI --- */
        .pagination-area { display: flex; justify-content: space-between; align-items: center; margin-top: 25px; font-size: 14px; }
        .btn-page { width: 35px; height: 35px; border-radius: 8px; border: 1px solid #ddd; background: #fff; cursor: pointer; }
        .btn-page.active { background: var(--primary-emerald); color: #fff; border-color: var(--primary-emerald); }

        /* --- BUTTONS --- */
        .btn { padding: 10px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; }
        .btn-batal { background: #fff; color: var(--primary-emerald); border: 1px solid var(--primary-emerald); }
        .btn-action { background: var(--primary-emerald); color: #fff; }
        .btn-unpublish { background: #1da077; color: #fff; }

        .nav-link i {
        width: 20px;
        margin-right: 12px;
        font-size: 18px;
        text-align: center;
        }

        .btn-logout i {
        margin-right: 8px;
        }

        .modal-overlay {
        display: none; /* Sembunyi secara default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4); /* Efek gelap transparan */
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    /* Kotak Modal */
    .modal-content {
        background: white;
        padding: 40px 60px;
        border-radius: 25px; /* Sudut melengkung besar sesuai gambar */
        text-align: center;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        max-width: 500px;
        width: 90%;
    }

    .modal-content h2 {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #0d1b2a;
        margin-bottom: 30px;
        font-size: 24px;
        line-height: 1.3;
    }

    /* Container Tombol */
    .modal-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    /* Gaya Tombol Umum */
    .modal-buttons button {
        padding: 10px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
        min-width: 120px;
    }

    /* Tombol Kembali (Putih dengan Border Hijau) */
    .btn-kembali {
        background: white;
        color: #10b981;
        border: 2px solid #10b981;
    }

    .btn-kembali:hover {
        background: #f0fdf4;
    }

    /* Tombol Ya (Hijau Solid) */
    .btn-ya {
        background: #10b981; /* Warna Hijau Emerald */
        color: white;
        border: none;
    }

    .btn-ya:hover {
        background: #059669;
    }

    /* Container untuk gambar di detail agar ukurannya terkontrol */
.detail-img-box {
    width: 300px;           /* Lebar tetap 300px sesuai keinginan Anda */
    aspect-ratio: 16/9;     /* Menjaga rasio panjang x lebar tetap sama */
    border-radius: 10px;
    overflow: hidden;       /* Memotong bagian gambar yang keluar box */
    margin-bottom: 25px;
    background: #f0f0f0;
}

.detail-img-box img {
    width: 100%;
    height: 100%;
    object-fit: cover;      /* Ini kuncinya: gambar akan memenuhi box tanpa gepeng */
}
    </style>
</head>
<body>

<div class="wrapper">
    <aside class="sidebar">
        <div class="logo-area"><img src="/images/logo-jurnalistik.jpg" alt="Logo"></div>
        <nav class="nav-menu">
            <a href="/admin/users" class="nav-link">
                <i class="fa-solid fa-user"></i> Pengguna
            </a>
            <a href="/admin/anggota" class="nav-link">
                <i class="fa-solid fa-users"></i> Anggota
            </a>
            <a href="/admin/artikel" class="nav-link active">
                <i class="fa-solid fa-newspaper"></i> Artikel
            </a>
            <a href="/admin/materi" class="nav-link">
                <i class="fa-solid fa-clipboard-list"></i> Materi
            </a>
            <a href="/admin/hasilkarya" class="nav-link">
                <i class="fa-solid fa-image"></i> Hasil karya
            </a>
        </nav>
        <div class="logout-area">
            <button class="btn-logout" onclick="logout()">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </div>
    </aside>

    <main class="main-content">
        <div class="header-top">
            <div class="admin-profile">
                <span>Admin</span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=1da077&color=fff" alt="Admin">
            </div>
        </div>

        <div id="main-list-view">
            <div class="page-header">
                <h1>Artikel</h1>
                <p>Jurnalistik SMA Negeri 12 Depok</p>
            </div>

            <div class="tabs-container">
                <button class="tab-btn active" onclick="switchTab('diterima')">Diterima</button>
                <button class="tab-btn" onclick="switchTab('dipublish')">Dipublish</button>
            </div>

            <div class="artikel-grid" id="artikel-container">
                <div class="artikel-card" onclick="showDetail('Daftar Nama Siswa yang Berhasil Lolos SNBP 2026', 'Ilya Saruni', '18 Maret 2026', 'diterima')">
                    <img src="{{ asset('images/artikel.jpg') }}" id="img-artikel-1" alt="Artikel">
                    <div class="artikel-body">
                        <h3>Daftar Nama Siswa yang Berhasil Lolos SNBP 2026</h3>
                        <div class="artikel-date">🕒 Sabtu, 6 Desember 2025</div>
                    </div>
                </div>
                <div class="artikel-card" onclick="showDetail('Daftar Nama Siswa yang Berhasil Lolos SNBP 2026', 'Ilya Saruni', '18 Maret 2026', 'diterima')">
                    <img src="{{ asset('images/artikel.jpg') }}" id="img-artikel-1" alt="Artikel">
                    <div class="artikel-body">
                        <h3>Daftar Nama Siswa yang Berhasil Lolos SNBP 2026</h3>
                        <div class="artikel-date">🕒 Sabtu, 6 Desember 2025</div>
                    </div>
                </div>
            </div>

            <div class="pagination-area">
                <div>Show 2 Row</div>
                <div style="display:flex; gap:8px;">
                    <button class="btn-page">&lt;</button>
                    <button class="btn-page active">1</button>
                    <button class="btn-page">&gt;</button>
                </div>
            </div>
        </div>

        <div id="detail-view">
            <div class="detail-header">
                <h2 id="det-judul">Daftar Nama Siswa yang Berhasil Lolos SNBP 2026</h2>
                <p class="detail-meta"><span id="det-penulis">Ilya Saruni</span> | <span id="det-tanggal">18 Maret 2026</span></p>
            </div>
            <div class="detail-img-box">
            <img src="{{ asset('images/artikel.jpg') }}" id="img-artikel-1" alt="Artikel">
            </div>
            <div class="detail-content">
                <p>Kabar membanggakan datang dari SMAN 1 Contoh. Sejumlah siswa berhasil lolos dalam Seleksi Nasional Berdasarkan Prestasi (SNBP) tahun 2026...</p>
                <br>
                <p>Berikut beberapa siswa yang berhasil lolos SNBP tahun 2026:</p>
                <ol style="margin-left: 20px;">
                    <li>Ilya Saruni – Universitas Indonesia – Ilmu Komunikasi</li>
                    <li>Merita Windya – Institut Pertanian Bogor – Teknologi Pangan</li>
                    <li>Wildan Nugroho – Universitas Gadjah Mada – Teknik Informatika</li>
                    <li>Putri Tatami – Universitas Padjadjaran – Manajemen</li>
                </ol>
            </div>
            <div class="detail-footer">
                <button class="btn btn-batal" onclick="hideDetail()">Batal</button>
                <button id="btn-main-action" class="btn btn-action">Publish</button>
            </div>
        </div>
    </main>
</div>

<div id="modalLogout" class="modal-overlay">
    <div class="modal-content">
        <h2>Apakah Anda yakin ingin keluar akun?</h2>
        <div class="modal-buttons">
            <button class="btn-kembali" onclick="closeLogoutModal()">Kembali</button>
            <button class="btn-ya" onclick="executeLogout()">Ya</button>
        </div>
    </div>
</div>

<script>
    const BASE_URL = 'http://127.0.0.1:8000';
    const API_URL = `${BASE_URL}/api/articles`;
    const TOKEN = localStorage.getItem('access_token');
    let currentTab = 'diterima';
    let selectedArtikelId = null;

    // Proteksi Halaman
    if (!TOKEN) {
        window.location.href = "login.html";
    }

    // 1. Fungsi Load Data dari API
    async function loadArtikel() {
        const container = document.getElementById('artikel-container');
        container.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: #9ca3af;">Memuat data...</p>';

        try {
            // Kita kirim parameter status ke Controller
            const response = await fetch(`${API_URL}?status=${currentTab}`, {
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            const articles = result.data;

            container.innerHTML = '';

            if (!articles || articles.length === 0) {
                container.innerHTML = `<p style="grid-column: 1/-1; text-align: center; color: #9ca3af; padding: 20px;">Tidak ada artikel dengan status ${currentTab}.</p>`;
                return;
            }

            articles.forEach(artikel => {
                // Handle path gambar dari storage Laravel
                const gambar = artikel.photo ? `${BASE_URL}/storage/${artikel.photo}` : '/images/artikel.jpg';

                container.innerHTML += `
                    <div class="artikel-card" onclick='prepareDetail(${JSON.stringify(artikel).replace(/'/g, "&apos;")})'>
                        <img src="${gambar}" class="artikel-img" alt="${artikel.title}">
                        <div class="artikel-body">
                            <h3>${artikel.title}</h3>
                            <div class="artikel-date">🕒 ${artikel.created_at || 'Baru saja'}</div>
                        </div>
                    </div>
                `;
            });
        } catch (error) {
            console.error("Gagal mengambil data artikel:", error);
            container.innerHTML = '<p style="grid-column: 1/-1; text-align: center; color: red;">Gagal terhubung ke server.</p>';
        }
    }

    // 2. Fungsi Pindah Tab
    function switchTab(tab) {
        currentTab = tab;
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
            // Menyamakan teks tombol dengan variabel tab
            if(btn.innerText.toLowerCase() === tab.toLowerCase()) {
            btn.classList.add('active');
        }
        });
        loadArtikel();
    }

    // 3. Menampilkan Detail Artikel
    function prepareDetail(artikel) {
        selectedArtikelId = artikel.article_id; // Menggunakan primary key dari model
        document.getElementById('main-list-view').style.display = 'none';
        document.getElementById('detail-view').style.display = 'block';

        document.getElementById('det-judul').innerText = artikel.title;
        document.getElementById('det-penulis').innerText = artikel.author ? artikel.author.name : 'Anonim';
        document.getElementById('det-tanggal').innerText = artikel.timestamps.created_at;
        document.querySelector('.detail-content').innerHTML = artikel.full_content;

        // Update gambar di detail
        const detailImg = document.querySelector('#detail-view .detail-img') || document.querySelector('#detail-view img');
        if(detailImg) {
            detailImg.src = artikel.photo ? `${BASE_URL}/storage/${artikel.photo}` : '/images/artikel.jpg';
        }

        const actionBtn = document.getElementById('btn-main-action');

        // Logika tombol aksi berdasarkan tab aktif
        if(currentTab === 'dipublish') {
            actionBtn.innerText = 'Takedown (Arsip)';
            actionBtn.className = 'btn btn-unpublish';
            actionBtn.onclick = () => updateStatus('takedown');
        } else {
            actionBtn.innerText = 'Publish Sekarang';
            actionBtn.className = 'btn btn-action';
            actionBtn.onclick = () => updateStatus('approve');
        }
    }

    // 4. Update Status (Approve/Takedown)
    async function updateStatus(action) {
    if (!selectedArtikelId) return;

    let targetStatus = (action === 'approve') ? 'published' : 'archived';

    // Pilih method (beberapa API butuh POST/PATCH untuk update)
    const method = 'PATCH';
    const endpoint = `${API_URL}/${selectedArtikelId}/status`; // Sesuaikan route di api.php

    try {
        const res = await fetch(endpoint, {
            method: method,
            headers: {
                'Authorization': `Bearer ${TOKEN}`,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                status: targetStatus
                // Jika rejected, tambahkan message: "..."
            })
        });

        if (res.ok) {
            alert(`Berhasil update ke ${targetStatus}`);
            hideDetail();
            loadArtikel();
        }
    } catch (error) {
        alert("Terjadi kesalahan koneksi.");
    }
}

    function hideDetail() {
        document.getElementById('main-list-view').style.display = 'block';
        document.getElementById('detail-view').style.display = 'none';
        selectedArtikelId = null;
    }

function logout() {
        document.getElementById('modalLogout').style.display = 'flex';
    }

    function closeLogoutModal() {
        document.getElementById('modalLogout').style.display = 'none';
    }

    function executeLogout() {
        localStorage.clear();
        window.location.href = "/login";
    }

    window.onclick = function(event) {
        const modal = document.getElementById('modalLogout');
        if (event.target == modal) {
            closeLogoutModal();
        }
    }

    // Init load
    loadArtikel();
</script>

</body>
</html>
