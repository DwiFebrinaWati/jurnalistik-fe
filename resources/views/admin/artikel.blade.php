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
            width: 100%; padding: 12px; background: #fff;
            border: 1.5px solid #d1d9d6; border-radius: 12px;
            cursor: pointer; color: #666; font-weight: 600; display: flex; align-items: center; justify-content: center; gap: 10px;
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
            <button class="btn-logout">
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
            <img src="{{ asset('images/artikel.jpg') }}" id="img-artikel-1" alt="Artikel">
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

<script>
    const API_URL = 'https://jurnalsmandas.web.id/api/artikel';
    const TOKEN = localStorage.getItem('access_token');
    let currentTab = 'diterima'; // Default tab

    if (!TOKEN) {
        window.location.href = "login.html";
    }

    async function loadArtikel() {
        try {
            const response = await fetch(`${API_URL}?status=${currentTab}`, {
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();

            const container = document.getElementById('artikel-container');
            container.innerHTML = ''; // Kosongkan dummy data

            if (result.data.length === 0) {
                container.innerHTML = `<p style="grid-column: 1/-1; text-align: center; color: #9ca3af; padding: 20px;">Tidak ada artikel dengan status ${currentTab}.</p>`;
                return;
            }

            result.data.forEach(artikel => {
                // Gunakan gambar default jika artikel.gambar kosong
                const gambar = artikel.gambar || '{{ asset("images/artikel.jpg") }}';

                container.innerHTML += `
                    <div class="artikel-card" onclick='prepareDetail(${JSON.stringify(artikel).replace(/'/g, "&apos;")})'>
                        <img src="${gambar}" class="artikel-img" alt="Artikel">
                        <div class="artikel-body">
                            <h3>${artikel.judul}</h3>
                            <div class="artikel-date">🕒 ${artikel.tanggal_dibuat || 'Baru saja'}</div>
                        </div>
                    </div>
                `;
            });
        } catch (error) {
            console.error("Gagal mengambil data artikel:", error);
        }
    }

    function switchTab(tab) {
        currentTab = tab;
        // Update UI tombol tab
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
            if(btn.innerText.toLowerCase() === tab) btn.classList.add('active');
        });
        loadArtikel(); // Reload data sesuai status
    }

    let selectedArtikelId = null;

    function prepareDetail(artikel) {
        selectedArtikelId = artikel.id;
        document.getElementById('main-list-view').style.display = 'none';
        document.getElementById('detail-view').style.display = 'block';

        document.getElementById('det-judul').innerText = artikel.judul;
        document.getElementById('det-penulis').innerText = artikel.penulis || 'Anonim';
        document.getElementById('det-tanggal').innerText = artikel.tanggal_dibuat;

        document.querySelector('.detail-content').innerHTML = artikel.konten;

        const actionBtn = document.getElementById('btn-main-action');
        if(currentTab === 'dipublish') {
            actionBtn.innerText = 'Unpublish';
            actionBtn.className = 'btn btn-unpublish';
            actionBtn.onclick = () => updateStatus('diterima');
        } else {
            actionBtn.innerText = 'Publish';
            actionBtn.className = 'btn btn-action';
            actionBtn.onclick = () => updateStatus('dipublish');
        }
    }

    async function updateStatus(newStatus) {
        if (!selectedArtikelId) return;

        try {
            const res = await fetch(`${API_URL}/${selectedArtikelId}/status`, {
                method: 'PATCH', // Atau 'PUT' sesuai dokumentasi API temanmu
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            });

            if (res.ok) {
                alert(`Artikel berhasil di-${newStatus}!`);
                hideDetail();
                loadArtikel();
            } else {
                alert("Gagal memperbarui status artikel.");
            }
        } catch (error) {
            console.error("Error update status:", error);
        }
    }

    function hideDetail() {
        document.getElementById('main-list-view').style.display = 'block';
        document.getElementById('detail-view').style.display = 'none';
        selectedArtikelId = null;
    }

    document.querySelector('.btn-logout').addEventListener('click', () => {
        localStorage.removeItem('access_token');
        window.location.href = "login.html";
    });

    // Jalankan saat pertama kali buka halaman
    loadArtikel();
</script>

</body>
</html>
