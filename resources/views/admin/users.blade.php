<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Pengguna</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        :root {
            --primary-emerald: #1da077;
            --light-emerald: #95d5c3;
            --soft-bg: #f8faf9;
            --sidebar-width: 260px;
        }

        body {
            background-color: var(--soft-bg);
            color: #333;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: var(--sidebar-width);
            background: #fff;
            display: flex;
            flex-direction: column;
            border-right: 1px solid #edf2f0;
            position: fixed;
            height: 100vh;
        }

        .logo-area {
            padding: 30px;
            text-align: center;
        }

        .logo-area img {
            width: 120px;
        }

        .nav-menu {
            flex-grow: 1;
            padding: 0 20px;
        }

        .nav-link i {
            width: 20px;
            margin-right: 12px;
            font-size: 18px;
            text-align: center;
        }

        .btn-logout i {
            margin-right: 8px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            text-decoration: none;
            color: #7d8581;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: 0.3s;
            font-weight: 500;
        }

        .nav-link.active {
            background-color: var(--primary-emerald);
            color: #fff;
        }

        .nav-link:hover:not(.active) {
            background-color: #f0fdf9;
            color: var(--primary-emerald);
        }

        .logout-area {
            padding: 20px;
        }

        .btn-logout {
            width: 100%;
            padding: 12px;
            background: transparent;
            border: 1.5px solid #d1d9d6;
            border-radius: 12px;
            cursor: pointer;
            color: #666;
            font-weight: 600;
        }

        .main-content {
            margin-left: var(--sidebar-width);
            flex-grow: 1;
            padding: 40px;
        }

        .header-top {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 30px;
        }

        .admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .admin-profile img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #eee;
        }

        .page-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: #1a1c1b;
        }

        .page-title p {
            color: #9ca3af;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .table-card {
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead {
            background-color: var(--light-emerald);
        }

        th {
            padding: 15px 20px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
        }

        td {
            padding: 18px 20px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }
        .badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-admin { background: #fff5f5; color: #fa5252; border-color: #ffe3e3; }
        .badge-editor { background: #fff9db; color: #fab005; }
        .badge-author { background: #f8f9fa; color: #868e96; border: 1px solid #e9ecef; }
        .actions { display: flex; gap: 8px; }

        .btn-action {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-edit { background: #edf2ff; color: #4c6ef5; border-color: #dbe4ff; }
        .btn-hapus { background: #fff5f5; color: #fa5252; border-color: #ffe3e3; }

        .modal {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.4); display: none;
            align-items: center; justify-content: center; z-index: 9999;
        }

        .modal-content {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            width: 100%;
            max-width: 450px;
            text-align: center;
        }

        .modal-content h2 { margin-bottom: 25px; font-size: 22px; }

        .form-group { text-align: left; margin-bottom: 15px; }
        .form-group label { display: block; font-size: 13px; color: #666; margin-bottom: 5px; }
        .form-group input, .form-group select {
            width: 100%; padding: 12px; border: 1px solid #333; border-radius: 10px; outline: none;
        }

        .modal-footer {
            display: flex; gap: 10px; margin-top: 25px;
        }

        .btn-modal { flex: 1; padding: 12px; border-radius: 10px; font-weight: 600; cursor: pointer; border: none; }
        .btn-batal { background: #fff; color: var(--primary-emerald); border: 1.5px solid var(--primary-emerald); }
        .btn-simpan { background: var(--primary-emerald); color: #fff; }

        /* Pagination Footer */
        .table-footer {
            display: flex; justify-content: space-between; align-items: center; margin-top: 20px;
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
        <div class="logo-area">
            <img src="/images/logo-jurnalistik.jpg" alt="Logo">
        </div>
        <nav class="nav-menu">
            <a href="#" class="nav-link active">
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
            <a href="/admin/hasilkarya" class="nav-link">
                <i class="fa-solid fa-image"></i> Hasil karya
            </a>
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
                <span>Admin</span>
                <img src="https://ui-avatars.com/api/?name=Admin&background=1da077&color=fff" alt="Avatar">
            </div>
        </div>

        <div class="page-title">
            <h1>Pengguna</h1>
            <p>Website Jurnalistik SMA Negeri 12 Depok</p>
        </div>

        <div class="table-card">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="user-table-body">
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <div style="font-size: 14px; color: #666;">
                Show <select style="padding: 5px; border-radius: 5px;"><option>10</option></select> Row
            </div>
            <div style="display: flex; gap: 5px;">
                <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #ddd; background: #fff;"> < </button>
                <button style="padding: 5px 10px; border-radius: 5px; background: var(--primary-emerald); color: white; border: none;">1</button>
                <button style="padding: 5px 10px; border-radius: 5px; border: 1px solid #ddd; background: #fff;"> > </button>
            </div>
        </div>
    </main>
</div>

<div id="modalEdit" class="modal">
    <div class="modal-content">
        <h2>Ubah Role</h2>
        <div class="form-group">
            <label>Nama</label>
            <input type="text" placeholder="Wildan Nugroho">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" placeholder="wildannugroho@gmail.com">
        </div>
        <div class="form-group">
            <label>Peran</label>
            <select id="edit-role-id">
                <option value="1">Admin</option>
                <option value="2">Editor</option>
                <option value="3">Author</option>
            </select>
        </div>
        <div class="modal-footer">
            <button class="btn-modal btn-batal" onclick="hideModal('modalEdit')">Batal</button>
            <button class="btn-modal btn-simpan">Simpan</button>
        </div>
    </div>
</div>

<div id="modalHapus" class="modal">
    <div class="modal-content">
        <h2 style="font-size: 20px;">Apakah Anda yakin ingin menghapus data ini?</h2>
        <div class="modal-footer">
            <button class="btn-modal btn-batal" onclick="hideModal('modalHapus')">Batal</button>
            <button class="btn-modal btn-simpan">Simpan</button>
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
const BASE_URL = 'http://127.0.0.1:8000/api'; // Sesuaikan port kamu
const API_URL = `${BASE_URL}/users`;
const TOKEN = localStorage.getItem('access_token');
const ROLE_ID = localStorage.getItem('role_id');


if (!TOKEN || ROLE_ID !== "1") {
    alert("Akses ditolak! Anda bukan Admin.");
    window.location.href = "/login";
}

document.addEventListener('DOMContentLoaded', () => {
    const adminName = localStorage.getItem('user_name') || 'Admin';
    document.querySelector('.admin-profile span').innerText = adminName;
    loadUsers();
});

async function loadUsers() {
    try {
        const response = await fetch(API_URL, {
            headers: {
                'Authorization': `Bearer ${TOKEN}`,
                'Accept': 'application/json'
            }
        });

        if (response.status === 401) return handleUnauthorized();

        const result = await response.json();
        const tableBody = document.querySelector('tbody');
        tableBody.innerHTML = '';

        const users = result.data || result;

        if (Array.isArray(users)) {
            users.forEach((user, index) => {
                let roleName = '';
                let badgeClass = '';

                if (user.role_id == 1) {
                    roleName = 'Admin';
                    badgeClass = 'badge-admin';
                } else if (user.role_id == 2) {
                    roleName = 'Editor';
                    badgeClass = 'badge-editor';
                } else {
                    roleName = 'Author';
                    badgeClass = 'badge-author';
                }

                tableBody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td><span class="badge ${badgeClass}">${roleName}</span></td>
                        <td class="actions">
                            <button class="btn-action btn-edit"
                                onclick="handleEditClick(${user.id}, '${user.name}', '${user.email}', ${user.role_id})">
                                <i class="fa-solid fa-pen"></i> Edit
                            </button>
                            <button class="btn-action btn-hapus" onclick="prepareDelete(${user.id})">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
    } catch (error) {
        console.error("Gagal memuat data pengguna:", error);
    }
}

function handleEditClick(id, name, email, role_id) {
    console.log("Klik Edit untuk ID:", id);
    const userObj = {
        id: id,
        name: name,
        email: email,
        role_id: role_id
    };
    prepareEdit(userObj);
}

let selectedUserId = null;

function prepareEdit(user) {
    selectedUserId = user.id;

    console.log("User yang dipilih ID-nya adalah:", selectedUserId);

    const modal = document.getElementById('modalEdit');

    modal.querySelector('input[type="text"]').value = user.name;
    modal.querySelector('input[type="email"]').value = user.email;

    modal.querySelector('#edit-role-id').value = user.role_id;

    showModal('modalEdit');
}

async function handleUpdateRole() {
    if (!selectedUserId) {
        alert("ID User tidak ditemukan! Silakan tutup modal dan klik edit lagi.");
        return;
    }

    const newName = document.querySelector('#modalEdit input[type="text"]').value;
    const newEmail = document.querySelector('#modalEdit input[type="email"]').value;
    const newRoleId = document.querySelector('#edit-role-id').value;

    const btn = document.querySelector('#modalEdit .btn-simpan');
    btn.innerText = "Processing...";
    btn.disabled = true;

    try {
        const res = await fetch(`${API_URL}/${selectedUserId}`, {
            method: 'PUT',
            headers: {
                'Authorization': `Bearer ${TOKEN}`,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                name: newName,
                email: newEmail,
                role_id: newRoleId
            })
        });

        if (res.ok) {
            alert("Data pengguna berhasil diperbarui!");
            hideModal('modalEdit');
            loadUsers();
        } else {
            const err = await res.json();
            alert("Gagal: " + (err.message || "Terjadi kesalahan"));
        }
    } catch (error) {
        alert("Gagal menghubungi server");
    } finally {
        btn.innerText = "Simpan";
        btn.disabled = false;
    }
}

document.querySelector('#modalEdit .btn-simpan').onclick = handleUpdateRole;

let deleteUserId = null;

function prepareDelete(id) {
    deleteUserId = id;
    showModal('modalHapus');
}

async function confirmDelete() {
    try {
        const res = await fetch(`${API_URL}/${deleteUserId}`, {
            method: 'DELETE',
            headers: {
                'Authorization': `Bearer ${TOKEN}`,
                'Accept': 'application/json'
            }
        });

        if (res.ok) {
            hideModal('modalHapus');
            loadUsers();
        } else {
            alert("Gagal menghapus pengguna.");
        }
    } catch (error) {
        alert("Gagal menghapus pengguna");
    }
}
document.querySelector('#modalHapus .btn-simpan').onclick = confirmDelete;

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
</script>

</body>
</html>
