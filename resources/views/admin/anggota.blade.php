<!DOCTYPE html>
<html lang="id">
<head>
    <!-- Head tetap sama (CSS tidak diubah sedikitpun) -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Anggota</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- SEMUA CSS TETAP SAMA --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        :root { --primary-emerald: #1da077; --light-emerald: #95d5c3; --soft-bg: #f8faf9; --sidebar-width: 260px; }
        body { background-color: var(--soft-bg); color: #333; }
        .wrapper { display: flex; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background: #fff; display: flex; flex-direction: column; border-right: 1px solid #edf2f0; position: fixed; height: 100vh; z-index: 100; }
        .logo-area { padding: 30px; text-align: center; }
        .logo-area img { width: 120px; }
        .nav-menu { flex-grow: 1; padding: 0 20px; }
        .nav-link { display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: #7d8581; border-radius: 10px; margin-bottom: 8px; transition: 0.3s; font-weight: 500; }
        .nav-link.active { background-color: var(--primary-emerald); color: #fff; }
        .nav-link:hover:not(.active) { background-color: #f0fdf9; color: var(--primary-emerald); }
        .logout-area { padding: 20px; }
        .btn-logout { width: 100%; padding: 12px; background: transparent; border: 1.5px solid #d1d9d6; border-radius: 12px; cursor: pointer; color: #666; font-weight: 600; }
        .main-content { margin-left: var(--sidebar-width); flex-grow: 1; padding: 40px; }
        .header-top { display: flex; justify-content: flex-end; margin-bottom: 30px; }
        .admin-profile { display: flex; align-items: center; gap: 10px; font-weight: 600; font-size: 14px; }
        .admin-profile img { width: 35px; height: 35px; border-radius: 50%; }
        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1a1c1b; }
        .page-header p { color: #9ca3af; font-size: 14px; }
        .btn-tambah { background-color: var(--primary-emerald); color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; }
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
        .modal { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4); display: none; align-items: center; justify-content: center; z-index: 1000; }
        .modal-content { background: #fff; padding: 30px; border-radius: 20px; width: 100%; max-width: 500px; }
        .modal-content h2 { text-align: center; margin-bottom: 20px; font-size: 22px; }
        .photo-upload { text-align: center; margin-bottom: 20px; }
        .photo-upload .circle { width: 80px; height: 80px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 30px; overflow: hidden; cursor: pointer; border: 2px dashed #ccc; }
        .photo-upload .circle img { width: 100%; height: 100%; object-fit: cover; }
        .photo-upload span { font-size: 12px; color: #666; cursor: pointer; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; color: #444; margin-bottom: 5px; font-weight: 500; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1.5px solid #333; border-radius: 10px; outline: none; }
        .modal-footer { display: flex; gap: 10px; margin-top: 25px; }
        .btn-m { flex: 1; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; }
        .btn-cancel { background: #fff; color: var(--primary-emerald); border: 1.5px solid var(--primary-emerald); }
        .btn-save { background: var(--primary-emerald); color: #fff; }
        .nav-link i { width: 20px; margin-right: 12px; font-size: 18px; text-align: center; }
        .btn-logout i { margin-right: 8px; }
    </style>
</head>

<body>
<div class="wrapper">
    <aside class="sidebar">
        <div class="logo-area"><img src="/images/logo-jurnalistik.jpg" alt="Logo"></div>
        <nav class="nav-menu">
            <a href="users.html" class="nav-link"><i class="fa-solid fa-user"></i> Pengguna</a>
            <a href="anggota.html" class="nav-link active"><i class="fa-solid fa-users"></i> Anggota</a>
            <a href="artikel.html" class="nav-link"><i class="fa-solid fa-newspaper"></i> Artikel</a>
            <a href="materi.html" class="nav-link"><i class="fa-solid fa-clipboard-list"></i> Materi</a>
            <a href="karya.html" class="nav-link"><i class="fa-solid fa-image"></i> Hasil karya</a>
        </nav>
        <div class="logout-area">
            <button class="btn-logout" onclick="handleLogout()">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
        </div>
    </aside>

    <main class="main-content">
        <div class="header-top">
            <div class="admin-profile">
                <span id="admin-name">Admin</span>
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
                <tbody id="anggota-table-body">
                    <!-- Data dari API akan muncul di sini -->
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h2>Tambah Anggota</h2>
        <form id="formTambah">
            <div class="photo-upload">
                <input type="file" id="inputFotoTambah" hidden accept="image/*" onchange="previewImage(this, 'previewTambah')">
                <div class="circle" id="previewTambah" onclick="document.getElementById('inputFotoTambah').click()">👤</div>
                <span onclick="document.getElementById('inputFotoTambah').click()">Pilih Foto</span>
            </div>
            <div class="form-group"><label>Nama</label><input type="text" id="add-nama" placeholder="Nama lengkap" required></div>
            <div class="form-group"><label>Tahun Masuk</label><input type="text" id="add-tahun" placeholder="Tahun" required></div>
            <div class="form-group"><label>Nomor Telepon</label><input type="text" id="add-telepon" placeholder="Nomor" required></div>
            <div class="form-group"><label>Alamat</label><input type="text" id="add-alamat" placeholder="Alamat" required></div>
            <div class="form-group">
                <label>Peran</label>
                <select id="add-peran"><option value="Mentor">Mentor</option><option value="Anggota">Anggota</option></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-m btn-cancel" onclick="hideModal('modalTambah')">Batal</button>
                <button type="submit" class="btn-m btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h2>Edit Anggota</h2>
        <form id="formEdit">
            <input type="hidden" id="edit-id">
            <div class="photo-upload">
                <input type="file" id="inputFotoEdit" hidden accept="image/*" onchange="previewImage(this, 'previewEdit')">
                <div class="circle" id="previewEdit" onclick="document.getElementById('inputFotoEdit').click()">👤</div>
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
                <button type="button" class="btn-m btn-cancel" onclick="hideModal('modalEdit')">Batal</button>
                <button type="submit" class="btn-m btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus -->
<div id="modalHapus" class="modal">
    <div class="modal-content" style="text-align:center;">
        <input type="hidden" id="hapus-id">
        <h2 style="font-size: 18px; margin-bottom: 30px;">Apakah Anda yakin ingin menghapus data ini?</h2>
        <div class="modal-footer">
            <button class="btn-m btn-cancel" onclick="hideModal('modalHapus')">Batal</button>
            <button class="btn-m btn-save" style="background: #fa5252;" onclick="confirmDelete()">Hapus</button>
        </div>
    </div>
</div>

<script>
    const API_URL = 'https://jurnalsmandas.web.id/api/anggota';
    const TOKEN = localStorage.getItem('access_token');

    // Cek Login: Kalau ga ada token, tendang ke login
    if (!TOKEN) {
        window.location.href = "login.html";
    }

    async function loadAnggota() {
        try {
            const response = await fetch(API_URL, {
                headers: { 'Authorization': `Bearer ${TOKEN}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            const tableBody = document.getElementById('anggota-table-body');
            tableBody.innerHTML = '';

            result.data.forEach((item, index) => {
                const badgeClass = item.peran === 'Mentor' ? 'badge-mentor' : 'badge-anggota';
                const foto = item.foto || `https://ui-avatars.com/api/?name=${item.nama}`;

                tableBody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td><img src="${foto}" class="avatar-img"></td>
                        <td>${item.nama}</td>
                        <td>${item.tahun_masuk}</td>
                        <td>${item.nomor_telepon}</td>
                        <td>${item.alamat}</td>
                        <td><span class="badge ${badgeClass}">${item.peran}</span></td>
                        <td>
                            <button class="btn-action btn-edit" onclick="prepareEdit(${JSON.stringify(item).replace(/"/g, '&quot;')})">Edit</button>
                            <button class="btn-action btn-hapus" onclick="prepareDelete(${item.id})">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        } catch (error) { console.error("Gagal load data", error); }
    }

    document.getElementById('formTambah').addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('nama', document.getElementById('add-nama').value);
        formData.append('tahun_masuk', document.getElementById('add-tahun').value);
        formData.append('nomor_telepon', document.getElementById('add-telepon').value);
        formData.append('alamat', document.getElementById('add-alamat').value);
        formData.append('peran', document.getElementById('add-peran').value);

        const fotoInput = document.getElementById('inputFotoTambah');
        if (fotoInput.files[0]) formData.append('foto', fotoInput.files[0]);

        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${TOKEN}`, 'Accept': 'application/json' },
                body: formData
            });
            if (res.ok) {
                alert("Anggota berhasil ditambah!");
                hideModal('modalTambah');
                loadAnggota();
            }
        } catch (error) { alert("Gagal menambah data"); }
    });

    function prepareEdit(item) {
        document.getElementById('edit-id').value = item.id;
        document.getElementById('edit-nama').value = item.nama;
        document.getElementById('edit-tahun').value = item.tahun_masuk;
        document.getElementById('edit-telepon').value = item.nomor_telepon;
        document.getElementById('edit-alamat').value = item.alamat;
        document.getElementById('edit-peran').value = item.peran;
        document.getElementById('previewEdit').innerHTML = `<img src="${item.foto || '👤'}" alt="Preview">`;
        showModal('modalEdit');
    }

    document.getElementById('formEdit').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('edit-id').value;
        const formData = new FormData();
        formData.append('_method', 'PUT'); // Syarat Laravel untuk update via FormData
        formData.append('nama', document.getElementById('edit-nama').value);
        formData.append('tahun_masuk', document.getElementById('edit-tahun').value);
        formData.append('nomor_telepon', document.getElementById('edit-telepon').value);
        formData.append('alamat', document.getElementById('edit-alamat').value);
        formData.append('peran', document.getElementById('edit-peran').value);

        const fotoInput = document.getElementById('inputFotoEdit');
        if (fotoInput.files[0]) formData.append('foto', fotoInput.files[0]);

        try {
            const res = await fetch(`${API_URL}/${id}`, {
                method: 'POST', // Gunakan POST + _method PUT
                headers: { 'Authorization': `Bearer ${TOKEN}`, 'Accept': 'application/json' },
                body: formData
            });
            if (res.ok) {
                alert("Data berhasil diupdate!");
                hideModal('modalEdit');
                loadAnggota();
            }
        } catch (error) { alert("Gagal update data"); }
    });

    function prepareDelete(id) {
        document.getElementById('hapus-id').value = id;
        showModal('modalHapus');
    }

    async function confirmDelete() {
        const id = document.getElementById('hapus-id').value;
        try {
            const res = await fetch(`${API_URL}/${id}`, {
                method: 'DELETE',
                headers: { 'Authorization': `Bearer ${TOKEN}`, 'Accept': 'application/json' }
            });
            if (res.ok) {
                hideModal('modalHapus');
                loadAnggota();
            }
        } catch (error) { alert("Gagal menghapus"); }
    }

    function handleLogout() {
        localStorage.removeItem('access_token');
        window.location.href = "login.html";
    }

    function showModal(id) { document.getElementById(id).style.display = 'flex'; }
    function hideModal(id) { document.getElementById(id).style.display = 'none'; }
    function previewImage(input, targetId) {
        const preview = document.getElementById(targetId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = (e) => preview.innerHTML = `<img src="${e.target.result}">`;
            reader.readAsDataURL(input.files[0]);
        }
    }

    loadAnggota();
</script>
</body>
</html>
