<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Materi Jurnalistik</title>
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

        .page-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 20px; }
        .page-header h1 { font-size: 28px; font-weight: 700; color: #1a1c1b; }
        .page-header p { color: #9ca3af; font-size: 14px; }

        .btn-tambah {
            background-color: var(--primary-emerald); color: white; border: none;
            padding: 10px 20px; border-radius: 8px; font-weight: 600; cursor: pointer;
            display: flex; align-items: center; gap: 8px;
        }

        /* --- TAB SYSTEM --- */
        .tabs { display: flex; gap: 15px; margin-bottom: 25px; }
        .tab-item {
            padding: 8px 25px; border-radius: 8px; border: 1px solid #e0e0e0;
            background: #fff; cursor: pointer; color: #666; font-size: 14px;
            transition: all 0.3s ease;
        }
        /* Hover */
        .tab-item:hover {
            border-color: var(--primary-emerald);
            color: var(--primary-emerald);
            background-color: #f0fdf9;
        }
        /* Active */
        .tab-item.active {
            background-color: var(--primary-emerald);
            border-color: var(--primary-emerald);
            color: #fff;
        }

        /* --- TABLE --- */
        .table-card { background: #fff; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; }
        thead { background-color: var(--light-emerald); }
        th { padding: 15px 20px; text-align: left; font-size: 14px; font-weight: 600; }
        td { padding: 18px 20px; border-bottom: 1px solid #f3f4f6; font-size: 13px; vertical-align: middle; }
        .link-text { color: #4c6ef5; text-decoration: none; }

        .btn-action { padding: 6px 14px; border-radius: 6px; font-size: 12px; cursor: pointer; border: 1px solid transparent; }
        .btn-edit { background: #edf2ff; color: #4c6ef5; border-color: #dbe4ff; margin-right: 5px; }
        .btn-hapus { background: #fff5f5; color: #fa5252; border-color: #ffe3e3; }

        /* --- MODAL --- */
        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); display: none; align-items: center;
            justify-content: center; z-index: 1000;
        }
        .modal-content { background: #fff; padding: 40px; border-radius: 25px; width: 100%; max-width: 550px; }
        .modal-content h2 { text-align: center; margin-bottom: 30px; font-size: 24px; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; color: #333; margin-bottom: 8px; font-weight: 600; }
        .form-group input, .form-group textarea {
            width: 100%; padding: 14px; border: 1.5px solid #333; border-radius: 12px; outline: none;
        }
        .form-group textarea { height: 100px; resize: none; }

        .modal-footer { display: flex; gap: 15px; margin-top: 10px; justify-content: center; }
        .btn-m { min-width: 120px; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; }
        .btn-cancel { background: #fff; color: var(--primary-emerald); border: 1.5px solid var(--primary-emerald); }
        .btn-save { background: var(--primary-emerald); color: #fff; }

        /* Pagination */
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
            <a href="/admin/materi" class="nav-link active">
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
                <h1>Materi</h1>
                <p>Jurnalistik SMA Negeri 12 Depok</p>
            </div>
            <button class="btn-tambah" onclick="showModal('modalTambah')"><span>+</span> Tambah</button>
        </div>

        <div class="tabs">
            <div class="tab-item active" onclick="switchTab(this)">Fotografi</div>
            <div class="tab-item" onclick="switchTab(this)">Videografi</div>
            <div class="tab-item" onclick="switchTab(this)">Penulisan</div>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Judul</th>
                        <th>Deskripsi Singkat</th>
                        <th>Link</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>12 Januari 2026</td>
                        <td>Pengenalan Dasar Fotografi</td>
                        <td>Membahas jenis kamera dan fungsi dasar kamera</td>
                        <td><a href="#" class="link-text">https://drive.google.com/file...</a></td>
                        <td>
                            <button class="btn-action btn-edit" onclick="openEditModal('Pengenalan Dasar Fotografi', 'Membahas jenis kamera', 'https://link.com')">Edit</button>
                            <button class="btn-action btn-hapus" onclick="showModal('modalHapus')">Hapus</button>
                        </td>
                    </tr>
                </tbody>
            </table>
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
        <h2>Tambah Materi</h2>
        <div class="form-group"><label>Judul</label><input type="text" placeholder="Judul Materi"></div>
        <div class="form-group"><label>Deskripsi Singkat</label><textarea placeholder="Deskripsi Singkat"></textarea></div>
        <div class="form-group"><label>Link</label><input type="text" placeholder="Link Materi"></div>
        <div class="modal-footer">
            <button class="btn-m btn-cancel" onclick="hideModal('modalTambah')">Batal</button>
            <button class="btn-m btn-save">Simpan</button>
        </div>
    </div>
</div>

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h2>Edit Materi</h2>
        <div class="form-group"><label>Judul</label><input type="text" id="edit-judul"></div>
        <div class="form-group"><label>Deskripsi Singkat</label><textarea id="edit-deskripsi"></textarea></div>
        <div class="form-group"><label>Link</label><input type="text" id="edit-link"></div>
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
            <button class="btn-m btn-save">Simpan</button>
        </div>
    </div>
</div>

<script>
    const API_URL = 'https://jurnalsmandas.web.id/api/materi';
    const TOKEN = localStorage.getItem('access_token');
    let currentCategory = 'Fotografi';

    if (!TOKEN) {
        window.location.href = "login.html";
    }

    function switchTab(element) {
        document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
        element.classList.add('active');

        currentCategory = element.innerText;
        loadMateri();
    }

    async function loadMateri() {
        try {
            const response = await fetch(`${API_URL}?kategori=${currentCategory}`, {
                headers: { 'Authorization': `Bearer ${TOKEN}`, 'Accept': 'application/json' }
            });
            const result = await response.json();
            const tableBody = document.querySelector('tbody');
            tableBody.innerHTML = ''; 

            const filteredData = result.data.filter(item => item.kategori === currentCategory);

            filteredData.forEach((item, index) => {
                tableBody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${new Date(item.created_at).toLocaleDateString('id-ID')}</td>
                        <td>${item.judul}</td>
                        <td>${item.deskripsi}</td>
                        <td><a href="${item.link}" target="_blank" class="link-text">${item.link}</a></td>
                        <td>
                            <button class="btn-action btn-edit" onclick='prepareEdit(${JSON.stringify(item).replace(/'/g, "&apos;")})'>Edit</button>
                            <button class="btn-action btn-hapus" onclick="prepareDelete(${item.id})">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error("Gagal memuat materi:", error);
        }
    }

    async function handleTambah() {
        const payload = {
            judul: document.querySelector('#modalTambah input[placeholder="Judul Materi"]').value,
            deskripsi: document.querySelector('#modalTambah textarea').value,
            link: document.querySelector('#modalTambah input[placeholder="Link Materi"]').value,
            kategori: currentCategory // Otomatis masuk ke kategori yang sedang aktif
        };

        try {
            const res = await fetch(API_URL, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            if (res.ok) {
                alert("Materi berhasil ditambah ke kategori " + currentCategory);
                hideModal('modalTambah');
                loadMateri();
            }
        } catch (error) { alert("Gagal menambah data"); }
    }
    document.querySelector('#modalTambah .btn-save').onclick = handleTambah;

    let selectedId = null;
    function prepareEdit(item) {
        selectedId = item.id;
        document.getElementById('edit-judul').value = item.judul;
        document.getElementById('edit-deskripsi').value = item.deskripsi;
        document.getElementById('edit-link').value = item.link;
        showModal('modalEdit');
    }

    async function handleEdit() {
        const payload = {
            judul: document.getElementById('edit-judul').value,
            deskripsi: document.getElementById('edit-deskripsi').value,
            link: document.getElementById('edit-link').value,
            kategori: currentCategory
        };

        try {
            const res = await fetch(`${API_URL}/${selectedId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            if (res.ok) {
                alert("Materi berhasil diupdate");
                hideModal('modalEdit');
                loadMateri();
            }
        } catch (error) { alert("Gagal update data"); }
    }
    document.querySelector('#modalEdit .btn-save').onclick = handleEdit;

    let deleteId = null;
    function prepareDelete(id) {
        deleteId = id;
        showModal('modalHapus');
    }

    async function confirmDelete() {
        try {
            const res = await fetch(`${API_URL}/${deleteId}`, {
                method: 'DELETE',
                headers: { 'Authorization': `Bearer ${TOKEN}` }
            });
            if (res.ok) {
                hideModal('modalHapus');
                loadMateri();
            }
        } catch (error) { alert("Gagal menghapus data"); }
    }
    document.querySelector('#modalHapus .btn-save').onclick = confirmDelete;

    function showModal(id) { document.getElementById(id).style.display = 'flex'; }
    function hideModal(id) { document.getElementById(id).style.display = 'none'; }

    document.querySelector('.btn-logout').onclick = () => {
        localStorage.removeItem('access_token');
        window.location.href = "login.html";
    };

    loadMateri();
</script>

</body>
</html>
