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

        <div class="tabs-container" id="tabs-container">
            <button class="tab-btn" data-status="disimpan">Disimpan</button>
            <button class="tab-btn" data-status="dikirim">Dikirim</button>
            <button class="tab-btn" data-status="ditolak">Ditolak</button>
            <button class="tab-btn active" data-status="diterima">Diterima</button>
            <button class="tab-btn" data-status="dipublish">Dipublish</button>
        </div>

        <div class="artikel-grid" id="artikel-grid">
            </div>
    </div>

    <div id="detail-view">
        <button class="btn-back" onclick="closeDetail()"><span>←</span> Kembali ke Daftar</button>

        <div class="detail-container">
            <div class="detail-actions" id="detail-actions-container">
                <button class="btn-tolak" id="btn-tolak" onclick="toggleModal(true)">Tolak</button>
                <button class="btn-terima" id="btn-action-primary" onclick="handleMainAction()">Terima</button>
            </div>

            <input type="text" id="edit-judul" class="detail-judul" style="width: 100%; border: none; background: transparent; font-size: 32px; font-weight: 700; margin-bottom: 10px; outline: none;">

            <p class="detail-meta" id="edit-meta"></p>

            <img src="" class="detail-img" id="edit-img">

            <div class="detail-isi">
                <textarea id="edit-isi" style="width: 100%; min-height: 400px; border: 1px solid #ddd; padding: 20px; border-radius: 10px; line-height: 1.8; font-family: inherit; font-size: 15px; resize: vertical;"></textarea>
            </div>
        </div>
    </div>
    </main>
</div>

<div id="modalRevisi" class="modal">
    <div class="modal-box">
        <h2>Berikan Alasan Penolakan</h2>
        <textarea id="rejection-note" placeholder="Berikan komentar untuk memudahkan revisi"></textarea>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button class="btn-tolak" style="background:#fff;" onclick="toggleModal(false)">Batal</button>
            <!-- PERBAIKAN: Tambahkan onclick="handleReject()" -->
            <button class="btn-terima" onclick="handleReject()">Simpan</button>
        </div>
    </div>
</div>

<script>
    const BASE_URL = 'http://127.0.0.1:8000/api';
    const API_URL = `${BASE_URL}/articles`;
    const TOKEN = localStorage.getItem('access_token');
    const ROOT_URL = "http://127.0.0.1:8000";

    let currentArticleId = null;
    // Set default status agar "Diajukan" aktif di awal
    let activeStatus = 'submitted';

    if (!TOKEN) { window.location.href = "/login"; }

    function renderTabs(mode = 'dashboard') {
        const tabsContainer = document.getElementById('tabs-container');

        // Mapping label dan status sesuai permintaanmu
        const allTabs = [
            { label: 'Diajukan', status: 'submitted' },
            { label: 'Diterima', status: 'accepted' },
            { label: 'Ditolak', status: 'rejected' },
            { label: 'Dipublish', status: 'published' }
        ];

        tabsContainer.innerHTML = '';

        // Tampilkan semua 4 tab di dashboard
        const filteredTabs = allTabs;

        filteredTabs.forEach(tab => {
            const btn = document.createElement('button');
            btn.className = `tab-btn ${activeStatus === tab.status ? 'active' : ''}`;
            btn.innerText = tab.label;
            btn.onclick = () => {
                activeStatus = tab.status;
                renderTabs(mode);
                loadArticles(tab.status);
            };
            tabsContainer.appendChild(btn);
        });
    }

    async function loadArticles(status = 'submitted') {
        try {
            const response = await fetch(`${API_URL}?status=${status}`, {
                headers: { 'Authorization': `Bearer ${TOKEN}` }
            });
            const result = await response.json();
            const grid = document.getElementById('artikel-grid');
            grid.innerHTML = '';

            const articles = result.data || [];

            articles.forEach(art => {
                const fileGambar = art.photo || art.image || art.thumbnail || art.gambar;
                let gambar = 'https://via.placeholder.com/400x225?text=No+Image';

                if (fileGambar) {
                    gambar = fileGambar.startsWith('http') ? fileGambar : `${ROOT_URL}/storage/${fileGambar}`;
                }

                grid.innerHTML += `
                    <div class="artikel-card" onclick="openDetail(${art.id})">
                        <img src="${gambar}" class="card-img">
                        <div class="card-body">
                            <h3>${art.title || 'Tanpa Judul'}</h3>
                            <div class="card-meta">🕒 ${art.timestamps?.created_at || ''}</div>
                        </div>
                    </div>
                `;
            });
        } catch (error) {
            console.error("Gagal memuat artikel:", error);
        }
    }

    async function openDetail(id) {
        currentArticleId = id;
        try {
            const response = await fetch(`${API_URL}/${id}`, {
                headers: { 'Authorization': `Bearer ${TOKEN}` }
            });

            if (!response.ok) throw new Error("Gagal mengambil data");

            const resData = await response.json();
            const art = resData.data || resData;

            const isReadOnly = activeStatus !== 'submitted';

            // KONSEP: BISA EDIT (readOnly = false)
            const judulInput = document.getElementById('edit-judul');
            const isiInput = document.getElementById('edit-isi');

            judulInput.value = art.title || '';
            judulInput.readOnly = isReadOnly;

            isiInput.value = art.full_content || art.content || '';
            isiInput.readOnly = isReadOnly;

            // Preview Gambar
            const fileGambar = art.photo || art.thumbnail || art.image;
            let gambarUrl = 'https://via.placeholder.com/400x225?text=No+Image';
            if (fileGambar) {
                gambarUrl = fileGambar.startsWith('http') ? fileGambar : `${ROOT_URL}/storage/${fileGambar}`;
            }
            document.getElementById('edit-img').src = gambarUrl;

            // Meta Info
            const authorName = art.author ? art.author.name : 'Anonim';
            const tanggal = art.timestamps?.created_at || '-';
            document.getElementById('edit-meta').innerText = `${authorName} | ${tanggal}`;

            // Sembunyikan Tabs saat fokus edit detail
            document.getElementById('tabs-container').innerHTML = '';

            // Update Label Tombol Aksi Utama
            const btnPrimary = document.getElementById('btn-action-primary');
            const btnReject = document.getElementById('btn-tolak');

            if (btnPrimary) {
            if (activeStatus === 'submitted') {
                btnPrimary.innerText = "Terima";
                btnPrimary.style.display = 'inline-block';
            } else if (activeStatus === 'accepted') {
                btnPrimary.innerText = "Publish & Simpan";
                btnPrimary.style.display = 'none';
                btnReject.style.display = 'none';
            } else {
                btnPrimary.style.display = 'none';
            }
        }

            document.getElementById('dashboard-view').style.display = 'none';
            document.getElementById('detail-view').style.display = 'block';

        } catch (error) {
            alert("Gagal mengambil detail artikel");
        }
    }

    async function handleMainAction() {
        let nextStatus = activeStatus;
        if (activeStatus === 'submitted') nextStatus = 'accepted';
        else if (activeStatus === 'accepted') nextStatus = 'published';

        if (!confirm(`Simpan perubahan dan ubah status ke ${nextStatus}?`)) return;

        const updatedData = {
            status: nextStatus,
            title: document.getElementById('edit-judul').value,
            content: document.getElementById('edit-isi').value
        };

        try {
            const response = await fetch(`${API_URL}/${currentArticleId}/status`, {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(updatedData)
            });

            if (response.ok) {
                alert(`Berhasil memperbarui artikel!`);
                closeDetail();
            }
        } catch (error) {
            alert("Gagal memproses artikel");
        }
    }

    async function handleReject() {
        const note = document.querySelector('#modalRevisi textarea').value;
        if (!note) return alert("Alasan penolakan harus diisi!");

        try {
            const response = await fetch(`${API_URL}/${currentArticleId}/status`, {
                method: 'PATCH',
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    status: 'rejected',
                    revision_note: note
                })
            });

            if (response.ok) {
                alert("Artikel ditolak!");
                toggleModal(false);
                closeDetail();
            }
        } catch (error) {
            alert("Gagal menolak artikel");
        }
    }

    function closeDetail() {
        document.getElementById('dashboard-view').style.display = 'block';
        document.getElementById('detail-view').style.display = 'none';
        renderTabs('dashboard');
        loadArticles(activeStatus);
    }

    function toggleModal(show) {
        document.getElementById('modalRevisi').style.display = show ? 'flex' : 'none';
    }

    function openRejectModal() {
        toggleModal(true);
    }

    document.addEventListener('DOMContentLoaded', () => {
        renderTabs('dashboard');
        loadArticles('submitted'); // Otomatis muat status submitted saat pertama buka
    });

    // Menghubungkan tombol konfirmasi di dalam modal
    const confirmRejectBtn = document.querySelector('#modalRevisi .btn-terima');
    if (confirmRejectBtn) {
        confirmRejectBtn.onclick = handleReject;
    }
</script>

</body>
</html>
