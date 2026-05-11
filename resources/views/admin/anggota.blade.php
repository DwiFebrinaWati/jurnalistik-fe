<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Anggota</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- CSS TETAP SAMA --- */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        :root { --primary-emerald: #1da077; --light-emerald: #95d5c3; --soft-bg: #f8faf9; --sidebar-width: 260px; }
        body { background-color: var(--soft-bg); color: #333; }
        .wrapper { display: flex; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width);
            background: #fff;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #edf2f0;
            position: fixed;
            height: 100vh; }
        .logo-area { padding: 30px; text-align: center; }
        .logo-area img { width: 120px; }
        .nav-menu { flex-grow: 1; padding: 0 20px; }
        .nav-link i {
        width: 20px;
        margin-right: 12px;
        font-size: 18px;
        text-align: center;
        }
        .nav-link { display: flex; align-items: center; padding: 12px 15px; text-decoration: none; color: #7d8581; border-radius: 10px; margin-bottom: 8px; transition: 0.3s; font-weight: 500; }
        .nav-link.active { background-color: var(--primary-emerald); color: #fff; }
        .nav-link:hover:not(.active) { background-color: #f0fdf9; color: var(--primary-emerald); }
        .logout-area { padding: 20px; }
        .btn-logout {
            width: 100%; padding: 12px; background: transparent;
            border: 1.5px solid #d1d9d6; border-radius: 12px;
            cursor: pointer; color: #666; font-weight: 600;
        }
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
        .photo-upload { text-align: center; margin-bottom: 20px; }
        .photo-upload .circle { width: 80px; height: 80px; background: #f3f4f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 30px; overflow: hidden; cursor: pointer; border: 2px dashed #ccc; }
        .photo-upload .circle img { width: 100%; height: 100%; object-fit: cover; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; color: #444; margin-bottom: 5px; font-weight: 500; }
        .form-group input, .form-group select { width: 100%; padding: 12px; border: 1.5px solid #d1d9d6; border-radius: 10px; outline: none; }
        .modal-footer { display: flex; gap: 10px; margin-top: 25px; }
        .btn-m { flex: 1; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; }
        .btn-cancel { background: #fff; color: var(--primary-emerald); border: 1.5px solid var(--primary-emerald); }
        .btn-save { background: var(--primary-emerald); color: #fff; }
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
    </style>
</head>

<body>
<div class="wrapper">
    <aside class="sidebar">
        <div class="logo-area"><img src="/images/logo-jurnalistik.jpg" alt="Logo"></div>
        <nav class="nav-menu">
            <a href="/admin/users" class="nav-link"><i class="fa-solid fa-user"></i> Pengguna</a>
            <a href="/admin/anggota" class="nav-link active"><i class="fa-solid fa-users"></i> Anggota</a>
            <a href="/admin/artikel" class="nav-link"><i class="fa-solid fa-newspaper"></i> Artikel</a>
            <a href="/admin/materi" class="nav-link"><i class="fa-solid fa-clipboard-list"></i> Materi</a>
            <a href="/admin/hasilkarya" class="nav-link"><i class="fa-solid fa-image"></i> Hasil karya</a>
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
                        <th>Nama Lengkap</th>
                        <th>Nomor Telepon</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="anggota-table-body">
                    <!-- Data dari API -->
                </tbody>
            </table>
        </div>
    </main>
</div>

<!-- Modal Tambah -->
<div id="modalTambah" class="modal">
    <div class="modal-content">
        <h2 style="text-align: center; margin-bottom: 20px;">Tambah Anggota</h2>
        <form id="formTambah">
            <div class="photo-upload">
                <input type="file" id="inputFotoTambah" hidden accept="image/*" onchange="previewImage(this, 'previewTambah')">
                <div class="circle" id="previewTambah" onclick="document.getElementById('inputFotoTambah').click()">👤</div>
                <span onclick="document.getElementById('inputFotoTambah').click()" style="font-size: 12px; color: #666; cursor: pointer;">Pilih Foto</span>
            </div>
            <div class="form-group"><label>Nama Lengkap</label><input type="text" id="add-fullName" placeholder="Nama lengkap" required></div>
            <div class="form-group"><label>Nomor Telepon</label><input type="text" id="add-phoneNumber" placeholder="Nomor" required></div>
            <div class="form-group">
                <label>Status</label>
                <select id="add-status"><option value="Mentor">Mentor</option><option value="Anggota">Anggota</option></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-m btn-cancel" onclick="hideModal('modalTambah')">Batal</button>
                <button type="submit" id="btn-save-tambah" class="btn-m btn-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit -->
<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h2 style="text-align: center; margin-bottom: 20px;">Edit Anggota</h2>
        <form id="formEdit">
            <input type="hidden" id="edit-id">
            <div class="photo-upload">
                <input type="file" id="inputFotoEdit" hidden accept="image/*" onchange="previewImage(this, 'previewEdit')">
                <div class="circle" id="previewEdit" onclick="document.getElementById('inputFotoEdit').click()">👤</div>
                <span onclick="document.getElementById('inputFotoEdit').click()" style="font-size: 12px; color: #666; cursor: pointer;">Ubah Foto</span>
            </div>
            <div class="form-group"><label>Nama Lengkap</label><input type="text" id="edit-fullName" required></div>
            <div class="form-group"><label>Nomor Telepon</label><input type="text" id="edit-phoneNumber" required></div>
            <div class="form-group">
                <label>Status</label>
                <select id="edit-status"><option value="Mentor">Mentor</option><option value="Anggota">Anggota</option></select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-m btn-cancel" onclick="hideModal('modalEdit')">Batal</button>
                <button type="submit" id="btn-save-edit" class="btn-m btn-save">Simpan</button>
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
    // --- KONFIGURASI API ---
// Sesuaikan port (8000/8001) dengan hasil 'php artisan serve' kamu
const BASE_URL = 'http://127.0.0.1:8000/api';
const API_URL = `${BASE_URL}/members`;

// Fungsi untuk mendapatkan Header Autentikasi
const getHeader = () => {
    const token = localStorage.getItem('access_token');
    return {
        'Authorization': `Bearer ${token}`,
        'Accept': 'application/json'
    };
};

// --- PROTEKSI HALAMAN ---
if (!localStorage.getItem('access_token')) {
    window.location.href = "/login";
}

// --- 1. LOAD DATA ANGGOTA ---
async function loadAnggota() {
    try {
        const response = await fetch(API_URL, {
            method: 'GET',
            headers: getHeader()
        });

        if (response.status === 401) return handleUnauthorized();

        const result = await response.json();
        const tableBody = document.getElementById('anggota-table-body');
        tableBody.innerHTML = '';

        // Laravel biasanya membungkus data dalam 'data'
        const members = result.data || result;

        if (Array.isArray(members)) {
            members.forEach((item, index) => {
                const badgeClass = item.status === 'Mentor' ? 'badge-mentor' : 'badge-anggota';

                // Logika Foto: Cek apakah path dari storage atau URL luar
                let foto = `https://ui-avatars.com/api/?name=${item.fullName}&background=random`;
                if (item.photo) {
                    foto = item.photo.startsWith('http') ? item.photo : `http://127.0.0.1:8000/storage/${item.photo}`;
                }

                tableBody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td><img src="${foto}" class="avatar-img" onerror="this.src='https://ui-avatars.com/api/?name=User'"></td>
                        <td>${item.fullName}</td>
                        <td>${item.phoneNumber}</td>
                        <td><span class="badge ${badgeClass}">${item.status}</span></td>
                        <td>
                            <button class="btn-action btn-edit" onclick='prepareEdit(${JSON.stringify(item)})'>Edit</button>
                            <button class="btn-action btn-hapus" onclick="prepareDelete(${item.id || item.members_id})">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        }
    } catch (error) {
        console.error("Gagal load data:", error);
    }
}

// --- 2. TAMBAH DATA ---
document.getElementById('formTambah').addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = document.getElementById('btn-save-tambah');
    btn.innerText = "Menyimpan...";
    btn.disabled = true;

    const formData = new FormData();
    formData.append('fullName', document.getElementById('add-fullName').value);
    formData.append('phoneNumber', document.getElementById('add-phoneNumber').value);
    formData.append('status', document.getElementById('add-status').value);

    const fotoInput = document.getElementById('inputFotoTambah');
    if (fotoInput.files[0]) {
        formData.append('photo', fotoInput.files[0]);
    }

    try {
        const res = await fetch(API_URL, {
            method: 'POST',
            headers: getHeader(), // Tanpa Content-Type karena FormData
            body: formData
        });

        const result = await res.json();
        if (res.ok) {
            alert("Anggota berhasil ditambahkan!");
            hideModal('modalTambah');
            document.getElementById('formTambah').reset();
            document.getElementById('previewTambah').innerHTML = '👤';
            loadAnggota();
        } else {
            alert("Gagal: " + (result.message || "Terjadi kesalahan"));
        }
    } catch (error) {
        alert("Kesalahan koneksi server.");
    } finally {
        btn.innerText = "Simpan";
        btn.disabled = false;
    }
});

// --- 3. EDIT & UPDATE DATA ---
function prepareEdit(item) {
    document.getElementById('edit-id').value = item.id || item.members_id;
    document.getElementById('edit-fullName').value = item.fullName;
    document.getElementById('edit-phoneNumber').value = item.phoneNumber;
    document.getElementById('edit-status').value = item.status;

    let fotoUrl = item.photo
        ? (item.photo.startsWith('http') ? item.photo : `http://127.0.0.1:8000/storage/${item.photo}`)
        : `https://ui-avatars.com/api/?name=${item.fullName}`;

    document.getElementById('previewEdit').innerHTML = `<img src="${fotoUrl}">`;
    showModal('modalEdit');
}

document.getElementById('formEdit').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('edit-id').value;
    const btn = document.getElementById('btn-save-edit');
    btn.innerText = "Mengupdate...";
    btn.disabled = true;

    const formData = new FormData();
    formData.append('_method', 'PUT'); // WAJIB untuk Laravel saat update via FormData
    formData.append('fullName', document.getElementById('edit-fullName').value);
    formData.append('phoneNumber', document.getElementById('edit-phoneNumber').value);
    formData.append('status', document.getElementById('edit-status').value);

    const fotoInput = document.getElementById('inputFotoEdit');
    if (fotoInput.files[0]) {
        formData.append('photo', fotoInput.files[0]);
    }

    try {
        const res = await fetch(`${API_URL}/${id}`, {
            method: 'POST', // Gunakan POST + _method PUT
            headers: getHeader(),
            body: formData
        });

        if (res.ok) {
            alert("Data berhasil diperbarui!");
            hideModal('modalEdit');
            loadAnggota();
        } else {
            const err = await res.json();
            alert("Gagal: " + (err.message || "Cek kembali data"));
        }
    } catch (error) {
        alert("Gagal menghubungi server.");
    } finally {
        btn.innerText = "Simpan";
        btn.disabled = false;
    }
});

// --- 4. HAPUS DATA ---
function prepareDelete(id) {
    document.getElementById('hapus-id').value = id;
    showModal('modalHapus');
}

async function confirmDelete() {
    const id = document.getElementById('hapus-id').value;
    try {
        const res = await fetch(`${API_URL}/${id}`, {
            method: 'DELETE',
            headers: getHeader()
        });

        if (res.ok) {
            hideModal('modalHapus');
            loadAnggota();
        } else {
            alert("Gagal menghapus data.");
        }
    } catch (error) {
        alert("Kesalahan server.");
    }
}

// --- UTILS & UI ---
function handleUnauthorized() {
    localStorage.clear();
    window.location.href = "/login";
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

function showModal(id) { document.getElementById(id).style.display = 'flex'; }
function hideModal(id) { document.getElementById(id).style.display = 'none'; }

function previewImage(input, targetId) {
    const preview = document.getElementById(targetId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            preview.innerHTML = `<img src="${e.target.result}" style="width:100%; height:100%; object-fit:cover;">`;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Jalankan saat halaman dibuka
window.onload = loadAnggota;
</script>
</body>
</html>
