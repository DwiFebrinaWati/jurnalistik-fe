<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Hasil Karya Jurnalistik</title>
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
            width: 100%; padding: 12px; background: transparent;
            border: 1.5px solid #d1d9d6; border-radius: 12px;
            cursor: pointer; color: #666; font-weight: 600;
        }

        /* --- MAIN CONTENT --- */
        .main-content { margin-left: var(--sidebar-width); flex-grow: 1; padding: 40px; }
        .header-top { display: flex; justify-content: flex-end; margin-bottom: 30px; }
        .admin-profile { display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 14px; }
        .admin-profile img { width: 35px; height: 35px; border-radius: 50%; }

        /* Judul & Tombol */
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1a1c1b; }
        .page-header p { color: #9ca3af; font-size: 14px; }

        .btn-tambah {
            background-color: var(--primary-emerald); color: white; border: none;
            padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
        }

        /* --- GRID HASIL KARYA --- */
        .karya-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 20px; margin-bottom: 30px;
        }

        .karya-card {
            background: #fff; border-radius: 15px; padding: 15px;
            border: 1px solid #eee; display: flex; gap: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }

        .karya-img-box { width: 100px; height: 100px; border-radius: 10px; overflow: hidden; flex-shrink: 0; }
        .karya-img-box img { width: 100%; height: 100%; object-fit: cover; }

        .karya-info { flex-grow: 1; display: flex; flex-direction: column; justify-content: space-between; }
        .karya-info h3 { font-size: 14px; font-weight: 700; color: #1a1c1b; line-height: 1.4; }
        .karya-meta { font-size: 11px; color: #888; margin-top: 5px; }
        .karya-link { color: #4c6ef5; text-decoration: none; display: block; margin: 3px 0; font-size: 11px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 180px; }

        .card-actions { display: flex; gap: 8px; margin-top: 10px; }
        .btn-action { flex: 1; padding: 6px; border-radius: 6px; font-size: 11px; font-weight: 600; cursor: pointer; border: 1px solid transparent; }
        .btn-edit { background: #edf2ff; color: #4c6ef5; border-color: #dbe4ff; }
        .btn-hapus { background: #fff5f5; color: #fa5252; border-color: #ffe3e3; }

        /* --- MODAL --- */
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); display: none; align-items: center;
            justify-content: center; z-index: 1000;
        }
        .modal-content { background: #fff; padding: 40px; border-radius: 25px; width: 100%; max-width: 550px; }
        .modal-content h2 { text-align: center; margin-bottom: 30px; font-size: 24px; font-weight: 600; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; color: #333; margin-bottom: 8px; font-weight: 600; }
        .form-group input { width: 100%; padding: 14px; border: 1.5px solid #333; border-radius: 12px; outline: none; }

        .upload-area {
            border: 1.5px solid #333; border-radius: 12px; padding: 20px;
            text-align: center; cursor: pointer; background: #fafafa;
        }
        .upload-area img { max-height: 80px; margin-bottom: 10px; border-radius: 5px; }
        .upload-area span { display: block; font-size: 12px; color: #666; }

        .modal-footer { display: flex; gap: 15px; margin-top: 10px; justify-content: center; }
        .btn-m { min-width: 120px; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; }
        .btn-cancel { background: #fff; color: var(--primary-emerald); border: 1.5px solid var(--primary-emerald); }
        .btn-save { background: var(--primary-emerald); color: #fff; }

        /* PAGINATION */
        .pagination-area { display: flex; justify-content: space-between; align-items: center; margin-top: 25px; font-size: 14px; }
        .page-nav { display: flex; gap: 8px; }
        .btn-page { width: 35px; height: 35px; display: flex; align-items: center; justify-content: center; border-radius: 8px; border: 1px solid #ddd; background: #fff; cursor: pointer; }
        .btn-page.active { background: var(--primary-emerald); color: #fff; border-color: var(--primary-emerald); }

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
            <a href="/admin/artikel" class="nav-link">
                <i class="fa-solid fa-newspaper"></i> Artikel
            </a>
            <a href="/admin/materi" class="nav-link">
                <i class="fa-solid fa-clipboard-list"></i> Materi
            </a>
            <a href="/admin/hasilkarya" class="nav-link active">
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

        <div class="page-header">
            <div>
                <h1>Hasil karya</h1>
                <p>Anggota Jurnalistik SMA Negeri 12 Depok</p>
            </div>
            <button class="btn-tambah" onclick="showModal('modalTambah')"><span>+</span> Tambah</button>
        </div>

        <div class="karya-grid">
            <div class="karya-card">
                <div class="karya-img-box">
                    <img src="{{ asset('images/hasilkarya.jpg') }}" id="img-karya-1" alt="Karya">
                </div>
                <div class="karya-info">
                    <div>
                        <h3 class="data-judul">Hunting Foto Taman Ismail Marzuki</h3>
                        <div class="karya-meta">
                            <span>📅 Sabtu, 6 Desember 2025</span>
                            <a href="https://drive.google.com/sample-link" class="karya-link data-link">🔗 https://drive.google.com/file...</a>
                            <span>✍️ Cover by: <span class="data-coverby">Ilya Saruni</span></span>
                        </div>
                    </div>
                    <div class="card-actions">
                        <button class="btn-action btn-edit" onclick="openEditModal(this)">Edit</button>
                        <button class="btn-action btn-hapus" onclick="showModal('modalHapus')">Hapus</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="pagination-area">
            <div>Show 10 Row</div>
            <div class="page-nav">
                <button class="btn-page">&lt;</button>
                <button class="btn-page active">1</button>
                <button class="btn-page">&gt;</button>
            </div>
        </div>
    </main>
</div>

<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h2>Tambah Hasil Karya</h2>
        <div class="form-group"><label>Judul</label><input type="text" placeholder="Masukkan judul"></div>
        <div class="form-group"><label>Link</label><input type="text" placeholder="Masukkan link drive"></div>
        <div class="form-group"><label>Cover By</label><input type="text" placeholder="Nama pembuat cover"></div>
        <div class="form-group">
            <label>Cover</label>
            <input type="file" id="fileTambah" hidden accept="image/*" onchange="previewImg(this, 'previewTambah')">
            <div class="upload-area" onclick="document.getElementById('fileTambah').click()" id="previewTambah">
                <span>+ Upload Photo</span>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-m btn-cancel" onclick="hideModal('modalTambah')">Batal</button>
            <button class="btn-m btn-save">Simpan</button>
        </div>
    </div>
</div>

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h2>Edit Hasil Karya</h2>
        <div class="form-group"><label>Judul</label><input type="text" id="edit-judul"></div>
        <div class="form-group"><label>Link</label><input type="text" id="edit-link"></div>
        <div class="form-group"><label>Cover By</label><input type="text" id="edit-coverby"></div>
        <div class="form-group">
            <label>Cover</label>
            <input type="file" id="fileEdit" hidden accept="image/*" onchange="previewImg(this, 'previewEdit')">
            <div class="upload-area" onclick="document.getElementById('fileEdit').click()" id="previewEdit">
                <span>Klik untuk ubah foto</span>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn-m btn-cancel" onclick="hideModal('modalEdit')">Batal</button>
            <button class="btn-m btn-save">Simpan</button>
        </div>
    </div>
</div>

<div id="modalHapus" class="modal">
    <div class="modal-content" style="max-width: 450px; text-align:center;">
        <h2 style="font-size: 18px; margin-bottom: 30px;">Apakah Anda yakin ingin menghapus data ini?</h2>
        <div class="modal-footer">
            <button class="btn-m btn-cancel" onclick="hideModal('modalHapus')">Batal</button>
            <button class="btn-m btn-save" style="background: #fa5252; color: white;">Hapus</button>
        </div>
    </div>
</div>

<script>
    function showModal(id) { document.getElementById(id).style.display = 'flex'; }
    function hideModal(id) { document.getElementById(id).style.display = 'none'; }

    function openEditModal(button) {
        const card = button.closest('.karya-card');
        const judul = card.querySelector('.data-judul').innerText;
        const link = card.querySelector('.data-link').getAttribute('href');
        const coverBy = card.querySelector('.data-coverby').innerText;

        document.getElementById('edit-judul').value = judul;
        document.getElementById('edit-link').value = link;
        document.getElementById('edit-coverby').value = coverBy;

        showModal('modalEdit');
    }

    function previewImg(input, targetId) {
        const preview = document.getElementById(targetId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" style="max-height:80px; margin-bottom:10px; border-radius:5px;"><span>Ubah Foto</span>`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal') event.target.style.display = 'none';
    }
</script>

</body>
</html>
