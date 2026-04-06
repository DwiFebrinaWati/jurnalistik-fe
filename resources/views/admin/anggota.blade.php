<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Anggota</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- RESET & BASE --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        :root {
            --primary-emerald: #1da077;
            --light-emerald: #95d5c3;
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

        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1a1c1b; }
        .page-header p { color: #9ca3af; font-size: 14px; }

        .btn-tambah {
            background-color: var(--primary-emerald); color: white; border: none;
            padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
        }

        /* --- TABLE --- */
        .table-card { background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: var(--light-emerald); }
        th { padding: 15px 20px; text-align: left; font-size: 14px; font-weight: 600; }
        td { padding: 18px 20px; border-bottom: 1px solid #f3f4f6; font-size: 14px; vertical-align: middle; }
        .avatar-img { width: 35px; height: 35px; border-radius: 50%; object-fit: cover; }

        .badge { padding: 4px 12px; border-radius: 6px; font-size: 12px; font-weight: 600; }
        .badge-mentor { background: #fff9db; color: #fab005; }
        .badge-anggota { background: #f8f9fa; color: #868e96; border: 1px solid #e9ecef; }

        .btn-action { padding: 6px 14px; border-radius: 6px; font-size: 12px; cursor: pointer; border: 1px solid transparent; }
        .btn-edit { background: #edf2ff; color: #4c6ef5; border-color: #dbe4ff; margin-right: 5px; }
        .btn-hapus { background: #fff5f5; color: #fa5252; border-color: #ffe3e3; }

        /* --- MODAL --- */
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); display: none; align-items: center;
            justify-content: center; z-index: 1000;
        }
        .modal-content { background: #fff; padding: 30px; border-radius: 20px; width: 100%; max-width: 500px; }
        .modal-content h2 { text-align: center; margin-bottom: 20px; font-size: 22px; }

        /* Photo Upload & Preview */
        .photo-upload { text-align: center; margin-bottom: 20px; }
        .photo-upload .circle {
            width: 80px; height: 80px; background: #f3f4f6; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; margin: 0 auto 10px;
            font-size: 30px; overflow: hidden; cursor: pointer; border: 2px dashed #ccc;
        }
        .photo-upload .circle img { width: 100%; height: 100%; object-fit: cover; }
        .photo-upload span { font-size: 12px; color: #666; cursor: pointer; }

        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; color: #444; margin-bottom: 5px; font-weight: 500; }
        .form-group input, .form-group select {
            width: 100%; padding: 12px; border: 1.5px solid #333; border-radius: 10px; outline: none;
        }

        .modal-footer { display: flex; gap: 10px; margin-top: 25px; }
        .btn-m { flex: 1; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; }
        .btn-cancel { background: #fff; color: var(--primary-emerald); border: 1.5px solid var(--primary-emerald); }
        .btn-save { background: var(--primary-emerald); color: #fff; }

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
            <a href="/admin/anggota" class="nav-link active">
                <i class="fa-solid fa-users"></i> Anggota
            </a>
            <a href="/admin/artikel" class="nav-link">
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

        <div class="page-header">
            <div>
                <h1>Anggota</h1>
                <p>Jurnalistik SMA Negeri 12 Depok</p>
            </div>
            <button class="btn-tambah" onclick="showModal('modalTambah')"><span>+</span> Tambah</button>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Foto</th>
                        <th>Nama Anggota</th>
                        <th>Tahun Masuk</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th>Peran</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><img src="https://ui-avatars.com/api/?name=Andi+Pratama" class="avatar-img"></td>
                        <td>Andi Pratama</td>
                        <td>2021</td>
                        <td>08123456789</td>
                        <td>Bogor</td>
                        <td><span class="badge badge-mentor">Mentor</span></td>
                        <td>
                            <button class="btn-action btn-edit" onclick="openEditModal('Andi Pratama', '2021', '08123456789', 'Bogor', 'Mentor', 'https://ui-avatars.com/api/?name=Andi+Pratama')">Edit</button>
                            <button class="btn-action btn-hapus" onclick="showModal('modalHapus')">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</div>

<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h2>Tambah Anggota</h2>
        <div class="photo-upload">
            <input type="file" id="inputFotoTambah" hidden accept="image/*" onchange="previewImage(this, 'previewTambah')">
            <div class="circle" id="previewTambah" onclick="document.getElementById('inputFotoTambah').click()">
                👤
            </div>
            <span onclick="document.getElementById('inputFotoTambah').click()">Pilih Foto</span>
        </div>
        <div class="form-group"><label>Nama</label><input type="text" placeholder="Nama lengkap"></div>
        <div class="form-group"><label>Tahun Masuk</label><input type="text" placeholder="Tahun"></div>
        <div class="form-group"><label>Nomor Telepon</label><input type="text" placeholder="Nomor"></div>
        <div class="form-group"><label>Alamat</label><input type="text" placeholder="Alamat"></div>
        <div class="form-group">
            <label>Peran</label>
            <select><option>Mentor</option><option>Anggota</option></select>
        </div>
        <div class="modal-footer">
            <button class="btn-m btn-cancel" onclick="hideModal('modalTambah')">Batal</button>
            <button class="btn-m btn-save">Simpan</button>
        </div>
    </div>
</div>

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h2>Edit Anggota</h2>
        <div class="photo-upload">
            <input type="file" id="inputFotoEdit" hidden accept="image/*" onchange="previewImage(this, 'previewEdit')">
            <div class="circle" id="previewEdit" onclick="document.getElementById('inputFotoEdit').click()">
                👤
            </div>
            <span onclick="document.getElementById('inputFotoEdit').click()">Ubah Foto</span>
        </div>
        <div class="form-group"><label>Nama</label><input type="text" id="edit-nama"></div>
        <div class="form-group"><label>Tahun Masuk</label><input type="text" id="edit-tahun"></div>
        <div class="form-group"><label>Nomor Telepon</label><input type="text" id="edit-telepon"></div>
        <div class="form-group"><label>Alamat</label><input type="text" id="edit-alamat"></div>
        <div class="form-group">
            <label>Peran</label>
            <select id="edit-peran"><option value="Mentor">Mentor</option><option value="Anggota">Anggota</option></select>
        </div>
        <div class="modal-footer">
            <button class="btn-m btn-cancel" onclick="hideModal('modalEdit')">Batal</button>
            <button class="btn-m btn-save">Simpan</button>
        </div>
    </div>
</div>

<div id="modalHapus" class="modal">
    <div class="modal-content" style="text-align:center;">
        <h2 style="font-size: 18px; margin-bottom: 30px;">Apakah Anda yakin ingin menghapus data ini?</h2>
        <div class="modal-footer">
            <button class="btn-m btn-cancel" onclick="hideModal('modalHapus')">Batal</button>
            <button class="btn-m btn-save" style="background: #fa5252;">Hapus</button>
        </div>
    </div>
</div>

<script>
    function showModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function hideModal(id) {
        document.getElementById(id).style.display = 'none';
        if(id === 'modalTambah') document.getElementById('previewTambah').innerHTML = '👤';
    }

    // Fungsi Preview Gambar
    function previewImage(input, targetId) {
        const preview = document.getElementById(targetId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function openEditModal(nama, tahun, telepon, alamat, peran, fotoUrl) {
        document.getElementById('edit-nama').value = nama;
        document.getElementById('edit-tahun').value = tahun;
        document.getElementById('edit-telepon').value = telepon;
        document.getElementById('edit-alamat').value = alamat;
        document.getElementById('edit-peran').value = peran;

        if(fotoUrl) {
            document.getElementById('previewEdit').innerHTML = `<img src="${fotoUrl}" alt="Preview">`;
        } else {
            document.getElementById('previewEdit').innerHTML = '👤';
        }

        showModal('modalEdit');
    }

    window.onclick = function(event) {
        if (event.target.className === 'modal') {
            event.target.style.display = 'none';
        }
    }
</script>

</body>
</html>
