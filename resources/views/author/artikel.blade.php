<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Author - Artikel Jurnalistik</title>
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

        /* --- HEADER PAGE --- */
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 25px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1a1c1b; }
        .page-header p { color: #9ca3af; font-size: 14px; }

        .btn-tambah {
            background-color: var(--primary-emerald); color: white; border: none;
            padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
        }

        /* --- TABS --- */
        .tabs-container { display: flex; gap: 10px; margin-bottom: 25px; }
        .tab-btn {
            padding: 8px 20px; border-radius: 6px; border: 1.5px solid #eee;
            background: #fff; cursor: pointer; color: #7d8581; font-weight: 500; transition: 0.3s;
        }
        .tab-btn.active { border-color: var(--primary-emerald); color: var(--primary-emerald); font-weight: 600; }

        /* --- ARTIKEL GRID --- */
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

        /* --- EDITOR VIEW --- */
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

        /* --- MODAL KONFIRMASI --- */
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
                <span>Author</span>
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
                <button class="tab-btn active" onclick="switchTab(this)">Disimpan</button>
                <button class="tab-btn" onclick="switchTab(this)">Dikirim</button>
                <button class="tab-btn" onclick="switchTab(this)">Ditolak</button>
                <button class="tab-btn" onclick="switchTab(this)">Diterima</button>
                <button class="tab-btn" onclick="switchTab(this)">Dipublish</button>
            </div>

            <div class="artikel-grid">
                <div class="artikel-card">
                    <div class="artikel-img-box">
                        <img src="/images/artikel.jpg" class="data-img">
                    </div>
                    <div class="artikel-body">
                        <h3 class="data-judul">Daftar Nama Siswa yang Berhasil Lolos SNBP 2026</h3>
                        <div class="artikel-meta-data">
                            🕒 <span class="data-tgl">Sabtu, 6 Desember 2025</span> | ✍️ <span class="data-penulis">Ilya Saruni</span>
                        </div>
                        <div class="card-actions">
                            <button class="btn-card btn-edit" onclick="openEditEditor(this)">Edit</button>
                            <button class="btn-card btn-hapus" onclick="confirmDelete()">Hapus</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="editor-view">
            <div class="editor-header-btns">
                <button class="btn-save" onclick="hideEditor()">Batal</button>
                <button class="btn-submit">Submit</button>
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

<script>
    function switchTab(el) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
    }

    function hideEditor() {
        document.getElementById('list-view').style.display = 'block';
        document.getElementById('editor-view').style.display = 'none';
    }

    function openTambahEditor() {
        document.getElementById('list-view').style.display = 'none';
        document.getElementById('editor-view').style.display = 'block';

        document.getElementById('edit-judul').value = "";
        document.getElementById('edit-isi').value = "";
        document.getElementById('preview-box').innerHTML = "<span>+ Upload Photo</span>";

        document.getElementById('edit-author').value = "Ilya Saruni"; // Ambil dari session admin nantinya
        document.getElementById('edit-tanggal').value = new Date().toLocaleDateString('id-ID', { day:'numeric', month:'long', year:'numeric' });
    }

    function openEditEditor(btn) {
        const card = btn.closest('.artikel-card');

        const judul = card.querySelector('.data-judul').innerText;
        const penulis = card.querySelector('.data-penulis').innerText;
        const tanggal = card.querySelector('.data-tgl').innerText;
        const imgSrc = card.querySelector('.data-img').src;

        document.getElementById('edit-judul').value = judul;
        document.getElementById('edit-author').value = penulis;
        document.getElementById('edit-tanggal').value = tanggal;
        document.getElementById('preview-box').innerHTML = `<img src="${imgSrc}">`;
        document.getElementById('edit-isi').value = "Ambil dari database";

        document.getElementById('list-view').style.display = 'none';
        document.getElementById('editor-view').style.display = 'block';
    }

    function previewFile(input) {
        const box = document.getElementById('preview-box');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                box.innerHTML = `<img src="${e.target.result}">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function confirmDelete() {
        document.getElementById('modalHapus').style.display = 'flex';
    }
    function closeDelete() {
        document.getElementById('modalHapus').style.display = 'none';
    }
    function executeDelete() {
        alert("Artikel berhasil dihapus!"); // Logika hapus backend di sini
        closeDelete();
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal') closeDelete();
    }
</script>

</body>
</html>
