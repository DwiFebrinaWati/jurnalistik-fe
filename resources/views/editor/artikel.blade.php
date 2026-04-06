<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor - Artikel Jurnalistik</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- RESET & BASE --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        :root {
            --primary-emerald: #1da077;
            --primary-hover: #168563;
            --soft-bg: #f8faf9;
            --sidebar-width: 260px;
        }
        body { background-color: var(--soft-bg); color: #333; }

        /* --- LAYOUT --- */
        .wrapper { display: flex; min-height: 100vh; }

        /* --- SIDEBAR --- */
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
        .user-profile { display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 14px; }
        .user-profile img { width: 35px; height: 35px; border-radius: 50%; }

        /* --- DASHBOARD VIEW --- */
        .page-header { margin-bottom: 25px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1a1c1b; }
        .page-header p { color: #9ca3af; font-size: 14px; }

        .tabs-container { display: flex; gap: 10px; margin-bottom: 25px; }
        .tab-btn {
            padding: 8px 20px; border-radius: 6px; border: 1.5px solid #eee;
            background: #fff; cursor: pointer; color: #7d8581; font-weight: 500; transition: 0.3s;
        }
        .tab-btn.active { border-color: var(--primary-emerald); color: var(--primary-emerald); font-weight: 600; }

        .artikel-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        .artikel-card {
            background: #fff; border-radius: 12px; border: 1px solid #eee;
            overflow: hidden; cursor: pointer; transition: 0.3s;
        }
        .artikel-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .card-img { width: 100%; aspect-ratio: 16/9; object-fit: cover; }
        .card-body { padding: 15px; }
        .card-body h3 { font-size: 13px; font-weight: 700; color: #1a1c1b; margin-bottom: 8px; line-height: 1.4; }
        .card-meta { font-size: 11px; color: #9ca3af; }

        /* --- DETAIL VIEW  --- */
        #detail-view { display: none; }
        .btn-back { background: transparent; border: none; color: var(--primary-emerald); cursor: pointer; font-weight: 600; margin-bottom: 15px; font-size: 14px; display: flex; align-items: center; gap: 5px; }

        .detail-container { background: #ececec; border-radius: 20px; padding: 40px; min-height: 80vh; position: relative; }
        .detail-actions { position: absolute; top: 25px; right: 25px; display: flex; gap: 12px; }

        .btn-tolak { background: #fff; color: #fa5252; border: 1px solid #fa5252; padding: 8px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-terima { background: var(--primary-emerald); color: #fff; border: none; padding: 8px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; }

        .detail-judul { font-size: 32px; font-weight: 700; color: #1a1c1b; margin-bottom: 10px; }
        .detail-meta { font-size: 16px; color: #666; margin-bottom: 25px; }
        .detail-img { width: 250px; border-radius: 10px; margin-bottom: 25px; }
        .detail-isi { font-size: 15px; line-height: 1.8; color: #444; text-align: justify; }

        /* --- MODAL --- */
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); display: none; align-items: center; justify-content: center; z-index: 1000;
        }
        .modal-box { background: #fff; padding: 40px; border-radius: 24px; width: 450px; text-align: center; }
        .modal-box textarea { width: 100%; height: 120px; border-radius: 12px; border: 1px solid #ddd; padding: 15px; margin: 20px 0; outline: none; resize: none; }

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
            <a href="#" class="nav-link">
                <i class="fa-solid fa-user"></i> Pengguna
            </a>
            <a href="#" class="nav-link">
                <i class="fa-solid fa-users"></i> Anggota
            </a>
            <a href="#" class="nav-link active">
                <i class="fa-solid fa-newspaper"></i> Artikel
            </a>
            <a href="#" class="nav-link">
                <i class="fa-solid fa-clipboard-list"></i> Materi
            </a>
            <a href="#" class="nav-link">
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
            <div class="user-profile">
                <span>Editor</span>
                <img src="https://ui-avatars.com/api/?name=Editor&background=1da077&color=fff" alt="Profile">
            </div>
        </div>

        <div id="dashboard-view">
            <div class="page-header">
                <h1>Artikel</h1>
                <p>Jurnalistik SMA Negeri 12 Depok</p>
            </div>

            <div class="tabs-container">
                <button class="tab-btn" onclick="switchTab(this)">Disimpan</button>
                <button class="tab-btn" onclick="switchTab(this)">Dikirim</button>
                <button class="tab-btn" onclick="switchTab(this)">Ditolak</button>
                <button class="tab-btn active" onclick="switchTab(this)">Diterima</button>
                <button class="tab-btn" onclick="switchTab(this)">Dipublish</button>
            </div>

            <div class="artikel-grid">
                <div class="artikel-card" onclick="openDetail()">
                    <img src="/images/artikel.jpg" class="data-img">
                    <div class="card-body">
                        <h3>Daftar Nama Siswa yang Berhasil Lolos SNBP 2026</h3>
                        <div class="card-meta">🕒 Sabtu, 6 Desember 2025</div>
                    </div>
                </div>
            </div>
        </div>

        <div id="detail-view">
            <button class="btn-back" onclick="closeDetail()"><span>←</span> Kembali ke Daftar</button>

            <div class="detail-container">
                <div class="detail-actions">
                    <button class="btn-tolak" onclick="toggleModal(true)">Tolak</button>
                    <button class="btn-terima">Terima</button>
                </div>

                <h1 class="detail-judul">Daftar Nama Siswa yang Berhasil Lolos SNBP 2026</h1>
                <p class="detail-meta">Ilya Saruni | 18 Maret 2026</p>

                <img src="https://via.placeholder.com/400x225?text=SNBP" class="detail-img">

                <div class="detail-isi">
                    <p>Kabar membanggakan datang dari SMAN 1 Contoh. Sejumlah siswa berhasil lolos dalam Seleksi Nasional Berdasarkan Prestasi (SNBP) tahun 2026 dan diterima di berbagai perguruan tinggi negeri di Indonesia.</p>
                </div>
            </div>
        </div>
    </main>
</div>

<div id="modalRevisi" class="modal">
    <div class="modal-box">
        <h2>Berikan Alasan Penolakan</h2>
        <textarea placeholder="Berikan komentar untuk memudahkan revisi"></textarea>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button class="btn-tolak" style="background:#fff;" onclick="toggleModal(false)">Batal</button>
            <button class="btn-terima" onclick="toggleModal(false)">Simpan</button>
        </div>
    </div>
</div>

<script>
    function openDetail() {
        document.getElementById('dashboard-view').style.display = 'none';
        document.getElementById('detail-view').style.display = 'block';
    }

    function closeDetail() {
        document.getElementById('dashboard-view').style.display = 'block';
        document.getElementById('detail-view').style.display = 'none';
    }

    function switchTab(el) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
    }

    function toggleModal(show) {
        document.getElementById('modalRevisi').style.display = show ? 'flex' : 'none';
    }
</script>

</body>
</html>
