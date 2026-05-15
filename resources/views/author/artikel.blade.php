<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author - Artikel Jurnalistik</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        :root {
            --primary-emerald: #1da077;
            --primary-hover: #168563;
            --soft-bg: #f8faf9;
            --sidebar-width: 260px;
        }
        body { background-color: var(--soft-bg); color: #333; }
        .wrapper { display: flex; min-height: 100vh; }
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
        .main-content { margin-left: var(--sidebar-width); flex-grow: 1; padding: 40px; }
        .header-top { display: flex; justify-content: flex-end; margin-bottom: 30px; }
        .user-profile { display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 14px; }
        .user-profile img { width: 35px; height: 35px; border-radius: 50%; }
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1a1c1b; }
        .page-header p { color: #9ca3af; font-size: 14px; }
        .btn-tambah {
            background-color: var(--primary-emerald); color: white; border: none;
            padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
        }
        .tabs-container { display: flex; gap: 10px; margin-bottom: 25px; }
        .tab-btn {
            padding: 8px 20px; border-radius: 6px; border: 1.5px solid #eee;
            background: #fff; cursor: pointer; color: #7d8581; font-weight: 500; transition: 0.3s;
        }
        .tab-btn.active { border-color: var(--primary-emerald); color: var(--primary-emerald); font-weight: 600; }
        .artikel-grid {
            display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px; margin-bottom: 30px;
        }
        .artikel-card { background: #fff; border-radius: 12px; border: 1px solid #eee; overflow: hidden; }
        .artikel-img-box { width: 100%; aspect-ratio: 16/9; display: flex; align-items: center; justify-content: center; overflow: hidden; background: #f0f0f0; }
        .artikel-img-box img { width: 100%; height: 100%; object-fit: cover; }
        .artikel-body { padding: 15px; }
        .artikel-body h3 { font-size: 13px; font-weight: 700; color: #1a1c1b; margin-bottom: 8px; height: 38px; overflow: hidden; }
        .artikel-meta-data { font-size: 11px; color: #9ca3af; margin-bottom: 12px; }
        .card-actions { display: flex; gap: 8px; }
        .btn-card { flex: 1; padding: 7px; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; border: 1.5px solid transparent; }
        .btn-edit { background: #f0f4ff; color: #4c6ef5; border-color: #dbe4ff; }
        .btn-hapus { background: #fff5f5; color: #fa5252; border-color: #ffe3e3; }
        #editor-view { display: none; background: #ececec; border-radius: 20px; padding: 40px; min-height: 80vh; position: relative; }
        .editor-header-btns { position: absolute; top: 25px; right: 25px; display: flex; gap: 10px; }
        .btn-save { background: #fff; color: var(--primary-emerald); border: 1.5px solid var(--primary-emerald); padding: 8px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .btn-submit { background: var(--primary-emerald); color: #fff; border: none; padding: 8px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; }
        .input-judul { width: 100%; background: transparent; border: none; font-size: 32px; font-weight: 700; outline: none; color: #1a1c1b; margin-bottom: 5px; }
        .meta-display { display: flex; gap: 10px; margin-bottom: 20px; }
        .meta-display input { background: transparent; border: none; color: #888; font-size: 16px; outline: none; width: fit-content; }
        .upload-area {
            width: 200px; aspect-ratio: 4/3; background: #fff; border: 2px dashed #ddd;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            cursor: pointer; border-radius: 10px; margin-bottom: 25px; color: #999; overflow: hidden;
        }
        .upload-area img { width: 100%; height: 100%; object-fit: cover; }
        .input-isi { width: 100%; min-height: 300px; background: transparent; border: none; outline: none; font-size: 16px; line-height: 1.7; resize: none; color: #444; }
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); display: none; align-items: center;
            justify-content: center; z-index: 1000;
        }
        .modal-content { background: #fff; padding: 30px; border-radius: 20px; width: 100%; max-width: 400px; text-align: center; }
        .modal-content h2 { font-size: 18px; margin-bottom: 20px; }
        .modal-footer { display: flex; gap: 10px; justify-content: center; }
        .btn-m { padding: 10px 25px; border-radius: 8px; font-weight: 600; cursor: pointer; border: none; min-width: 100px; }
        .btn-no { background: #eee; color: #666; }
        .btn-yes { background: #fa5252; color: #fff; }
        .nav-link i { width: 20px; margin-right: 12px; font-size: 18px; text-align: center; }
        .btn-logout i { margin-right: 8px; }
        .disabled-btn {
            background: #e5e7eb !important;
            color: #9ca3af !important;
            cursor: not-allowed !important;
            border: none !important;
        }
        .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.4);
        z-index: 9999;
        justify-content: center;
        align-items: center;
    }

    .modal-content {
        background: white;
        padding: 40px 60px;
        border-radius: 25px;
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

    .modal-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .modal-buttons button {
        padding: 10px 30px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        font-size: 16px;
        transition: 0.3s;
        min-width: 120px;
    }

    .btn-kembali {
        background: white;
        color: #10b981;
        border: 2px solid #10b981;
    }

    .btn-kembali:hover {
        background: #f0fdf4;
    }

    .btn-ya {
        background: #10b981;
        color: white;
        border: none;
    }

    .btn-ya:hover {
        background: #059669;
    }

    .menu-toggle {
        display: none;
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1001;
        background: var(--primary-emerald);
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
        font-size: 20px;
    }

    .nav-link .lock-icon {
                        margin-left: auto;
                        font-size: 12px;
                        opacity: 0.6;
                    }

            #locked-view {
                flex-grow: 1;
                display: none;
                align-items: center;
                justify-content: center;
                border-radius: 20px;
                min-height: 70vh;
                margin-top: 10px;
            }
            .locked-icon-big {
                font-size: 120px;
                color: #4b5563;
            }

@media (max-width: 768px) {
    .menu-toggle { display: block; }

    .sidebar {
        left: -100%;
        transition: 0.3s;
    }

    .sidebar.active {
        left: 0;
    }

    .main-content {
        margin-left: 0;
        padding: 20px;
        padding-top: 80px;
    }

    .page-header {
        flex-direction: column;
        gap: 15px;
    }
}
    </style>
</head>
<body>
<button class="menu-toggle" onclick="toggleSidebar()">
    <i class="fa-solid fa-bars"></i>
</button>
<div class="wrapper">
    <aside class="sidebar">
        <div class="logo-area"><img src="/images/logo-jurnalistik.jpg" alt="Logo"></div>
        <nav class="nav-menu">
            <a href="#" class="nav-link"><i class="fa-solid fa-user"></i> Pengguna <i class="fa-solid fa-lock lock-icon"></i></a>
            <a href="#" class="nav-link"><i class="fa-solid fa-users"></i> Anggota <i class="fa-solid fa-lock lock-icon"></i></a>
            <a href="#" class="nav-link active"><i class="fa-solid fa-newspaper"></i> Artikel</a>
            <a href="#" class="nav-link"><i class="fa-solid fa-clipboard-list"></i> Materi <i class="fa-solid fa-lock lock-icon"></i></a>
            <a href="#" class="nav-link"><i class="fa-solid fa-image"></i> Hasil karya <i class="fa-solid fa-lock lock-icon"></i></a>
        </nav>
        <div class="logout-area">
            <button class="btn-logout" onclick="logout()">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </div>
    </aside>

    <main class="main-content">
        <div class="header-top">
            <div class="user-profile">
                <span id="display-username">Author</span>
                <img src="https://ui-avatars.com/api/?name=Author&background=1da077&color=fff" alt="Profile">
            </div>
        </div>

        <div id="list-view">
            <div class="page-header">
                <div>
                    <h1>Artikel</h1>
                    <p>Jurnalistik SMA Negeri 12 Depok</p>
                </div>
                <button class="btn-tambah" onclick="openTambahEditor()"><span>+</span> Tambah</button>
            </div>

            <div class="tabs-container">
                <button class="tab-btn active" onclick="switchTab(this, 'disimpan')">Disimpan</button>
                <button class="tab-btn" onclick="switchTab(this, 'dikirim')">Dikirim</button>
                <button class="tab-btn" onclick="switchTab(this, 'ditolak')">Ditolak</button>
                <button class="tab-btn" onclick="switchTab(this, 'diterima')">Diterima</button>
                <button class="tab-btn" onclick="switchTab(this, 'dipublish')">Dipublish</button>
            </div>

            <div class="artikel-grid" id="article-container">
            </div>
        </div>

        <div id="editor-view">
            <div class="editor-header-btns">
                <button class="btn-save" onclick="handleSave(false)">Simpan Draf</button>
                <button class="btn-submit" onclick="handleSave(true)">Submit</button>
                <button class="btn-save" onclick="hideEditor()" style="border-color: #999; color: #666;">Batal</button>
            </div>

            <input type="text" class="input-judul" id="edit-judul" placeholder="Judul Artikel">

            <div class="meta-display">
                <input type="text" id="edit-author" readonly placeholder="Author">
                <span style="color:#888">|</span>
                <input type="text" id="edit-tanggal" readonly placeholder="Tanggal">
            </div>

            <div class="upload-area" onclick="document.getElementById('file-input').click()" id="preview-box">
                <span>+ Upload Photo</span>
            </div>
            <input type="file" id="file-input" hidden onchange="previewFile(this)">

            <textarea class="input-isi" id="edit-isi" placeholder="Tuliskan isi artikel di sini..."></textarea>
        </div>

            <div id="locked-view">
            <div style="text-align: center;">
                <i class="fa-solid fa-lock locked-icon-big"></i>
                <h2 style="margin-top: 20px; color: #4b5563;">Akses Terbatas</h2>
                <p style="color: #6b7280;">Hanya Administrator yang dapat mengakses halaman ini.</p>
            </div>
    </div>
    </main>
</div>

<div id="modalHapus" class="modal">
    <div class="modal-content">
        <h2>Apakah Anda yakin ingin menghapus artikel ini?</h2>
        <div class="modal-footer">
            <button class="btn-m btn-no" onclick="closeDelete()">Batal</button>
            <button class="btn-m btn-yes" onclick="executeDelete()">Hapus</button>
        </div>
    </div>
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
    const BASE_URL = "http://127.0.0.1:8000/api";
    const API_URL = `${BASE_URL}/articles`;
    const TOKEN = localStorage.getItem('access_token');
    const userData = JSON.parse(localStorage.getItem('user_data'));
    const ROOT_URL = "http://127.0.0.1:8000";

    let currentArticleId = null;
    let currentStatusTab = 'disimpan';
    let deleteId = null;

    if (!TOKEN) window.location.href = "/login";
    if (userData) document.getElementById('display-username').innerText = userData.name;

    function getHeader() {
        return {
            'Authorization': `Bearer ${TOKEN}`,
            'Accept': 'application/json'
        };
    }

    async function loadArticles(status = 'disimpan') {
    currentStatusTab = status;
    const grid = document.getElementById('article-container');
    grid.innerHTML = '<p>Memuat...</p>';

    const statusMap = {
        'disimpan': 'draft',
        'dikirim': 'submitted',
        'diterima': 'accepted',
        'ditolak': 'rejected',
        'dipublish': 'published'
    };

    try {
        const response = await fetch(`${API_URL}?status=${statusMap[status]}`, {
            headers: getHeader()
        });
        const result = await response.json();

        console.log("Data Artikel dari API:", result);

        const articles = result.data || result;
        grid.innerHTML = '';

        if (!articles || articles.length === 0) {
            grid.innerHTML = `<p style="color:#999">Tidak ada artikel dalam kategori ini.</p>`;
            return;
        }

        articles.forEach(art => {
            const fileGambar = art.photo || art.image || art.thumbnail || art.gambar;
            let gambar = 'https://via.placeholder.com/400x225?text=No+Image';

            if (fileGambar) {
                gambar = fileGambar.startsWith('http') ? fileGambar : `${ROOT_URL}/storage/${fileGambar}`;
            }

            const tglRaw = art.created_at || art.published_at || art.date;
            let tglDibuat = '-';

            if (tglRaw) {
                const dateObj = new Date(tglRaw);
                if (!isNaN(dateObj)) {
                    tglDibuat = dateObj.toLocaleDateString('id-ID', {
                        day: 'numeric', month: 'long', year: 'numeric'
                    });
                }
            }

            const rawStatus = typeof art.status === 'object' ? art.status.value : art.status;
            const isEditable = (rawStatus === 'draft');

            grid.innerHTML += `
                <div class="artikel-card">
                    <div class="artikel-img-box">
                        <img src="${gambar}" onerror="this.src='https://via.placeholder.com/400x225?text=Error+Loading'">
                    </div>
                    <div class="artikel-body">
                        <h3>${art.title || 'Tanpa Judul'}</h3>
                        <div class="artikel-meta-data">
                            🕒 <span>${tglDibuat}</span>
                        </div>
                        <div class="card-actions">
                            ${isEditable ?
                                `<button class="btn-card btn-edit" onclick='openEditEditor(${JSON.stringify(art).replace(/'/g, "&apos;")})'>Edit</button>` :
                                `<button class="btn-card disabled-btn" disabled>🔒 Terkunci</button>`
                            }
                            <button class="btn-card btn-hapus" onclick="confirmDelete(${art.id || art.article_id})">Hapus</button>
                        </div>
                    </div>
                </div>`;
        });
    } catch (e) {
        console.error("Error loadArticles:", e);
        grid.innerHTML = 'Gagal memuat data.';
    }
}

    function openTambahEditor() {
        currentArticleId = null;
        document.getElementById('edit-judul').value = '';
        document.getElementById('edit-isi').value = '';
        document.getElementById('edit-author').value = userData ? userData.name : 'Author';
        document.getElementById('edit-tanggal').value = new Date().toLocaleDateString('id-ID');
        document.getElementById('preview-box').innerHTML = '<span>+ Upload Photo</span>';
        document.getElementById('file-input').value = '';

        showEditor();
    }

    function openEditEditor(art) {
    const data = art.data ? art.data : art;

    currentArticleId = data.id;

    document.getElementById('edit-judul').value = data.title || "";
    document.getElementById('edit-isi').value = data.full_content || "";
    document.getElementById('edit-author').value = data.author?.name || data.user?.name || 'Author';

    const tglRaw = data.created_at;
    if (tglRaw) {
        const dateObj = new Date(tglRaw);
        if (!isNaN(dateObj)) {
            document.getElementById('edit-tanggal').value = dateObj.toLocaleDateString('id-ID', {
                day: 'numeric', month: 'long', year: 'numeric'
            });
        }
    }

    const photo = data.photo || data.thumbnail;
    if (photo) {
        const imgPath = photo.startsWith('http') ? photo : `${ROOT_URL}/storage/${photo}`;
        document.getElementById('preview-box').innerHTML = `<img src="${imgPath}" style="width:100%; height:100%; object-fit:cover;">`;
    } else {
        document.getElementById('preview-box').innerHTML = '<span>+ Upload Photo</span>';
    }

    showEditor();
}

    async function handleSave(isSubmit = false) {
        const btnSave = document.querySelector(isSubmit ? '.btn-submit' : '.btn-save');
        const originalText = btnSave.innerText;

        btnSave.innerText = "Proses...";
        btnSave.disabled = true;

        const formData = new FormData();
        formData.append('title', document.getElementById('edit-judul').value);
        formData.append('content', document.getElementById('edit-isi').value);
        formData.append('status', isSubmit ? 'submitted' : 'draft');

        const fileInput = document.getElementById('file-input');
        if (fileInput.files[0]) {
            formData.append('photo', fileInput.files[0]);
        }

        let url = API_URL;
        if (currentArticleId) {
            url = `${API_URL}/${currentArticleId}`;
        }

        try {
            const response = await fetch(url, {
                method: 'POST',
                headers: getHeader(),
                body: formData
            });

            const result = await response.json();

            if (response.ok) {
                alert(currentArticleId ? "Artikel diperbarui!" : "Artikel berhasil dibuat!");
                hideEditor();
                loadArticles('disimpan');
            } else {
                alert("Gagal: " + (result.message || "Periksa kembali inputan Anda"));
            }
        } catch (e) {
            alert("Kesalahan koneksi ke server.");
        } finally {
            btnSave.innerText = originalText;
            btnSave.disabled = false;
        }
    }

    function confirmDelete(id) {
        deleteId = id;
        document.getElementById('modalHapus').style.display = 'flex';
    }

    function closeDelete() {
        document.getElementById('modalHapus').style.display = 'none';
        deleteId = null;
    }

    async function executeDelete() {
        if(!deleteId) return;
        try {
            const response = await fetch(`${API_URL}/${deleteId}`, {
                method: 'DELETE',
                headers: getHeader()
            });

            if (response.ok) {
                closeDelete();
                loadArticles(currentStatusTab);
            } else {
                alert("Gagal menghapus artikel.");
            }
        } catch (e) { alert("Error koneksi."); }
    }

    function showEditor() {
        document.getElementById('list-view').style.display = 'none';
        document.getElementById('editor-view').style.display = 'block';
    }

    function hideEditor() {
        document.getElementById('list-view').style.display = 'block';
        document.getElementById('editor-view').style.display = 'none';
        currentArticleId = null;
    }

    function previewFile(input) {
        const preview = document.getElementById('preview-box');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function switchTab(el, status) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
        loadArticles(status);
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

    document.addEventListener('DOMContentLoaded', () => loadArticles('disimpan'));

    function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.querySelector('.menu-toggle i');

    sidebar.classList.toggle('active');

    if (sidebar.classList.contains('active')) {
        toggleBtn.classList.replace('fa-bars', 'fa-xmark');
    } else {
        toggleBtn.classList.replace('fa-xmark', 'fa-bars');
    }
}

document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        if (window.innerWidth <= 768) {
            toggleSidebar();
        }
    });
});

function switchView(viewId) {
    const views = ['list-view', 'editor-view', 'locked-view'];

    views.forEach(id => {
        const element = document.getElementById(id);
        if (element) {
            if (id === viewId) {
                element.style.display = (id === 'locked-view' ? 'flex' : 'block');
            } else {
                element.style.display = 'none';
            }
        }
    });

    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
}

document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', (e) => {
        const text = link.innerText.trim().toLowerCase();

        if (text.includes('artikel')) {
            switchView('list-view');
            link.classList.add('active');
            loadArticles(currentStatusTab);
        } else {
            switchView('locked-view');
            link.classList.add('active');
        }
    });
});
</script>
</body>
</html>
