<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Pengguna</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        /* --- RESET & BASE --- */
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

        /* --- LAYOUT --- */
        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* --- SIDEBAR --- */
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

        /* --- MAIN CONTENT --- */
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

        /* --- TABLE STYLE --- */
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

        /* Badge Role */
        .badge {
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-editor { background: #fff9db; color: #fab005; }
        .badge-author { background: #f8f9fa; color: #868e96; border: 1px solid #e9ecef; }

        /* Action Buttons */
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

        /* --- MODAL --- */
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
    </style>
</head>
<body>

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
            <button class="btn-logout">
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
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Ilya Saruni</td>
                        <td>saruniya@gmail.com</td>
                        <td><span class="badge badge-editor">Editor</span></td>
                        <td class="actions">
                            <button class="btn-action btn-edit" onclick="showModal('modalEdit')">Edit</button>
                            <button class="btn-action btn-hapus" onclick="showModal('modalHapus')">Hapus</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Wildan Nugroho</td>
                        <td>wildannugroho@gmail.com</td>
                        <td><span class="badge badge-author">Author</span></td>
                        <td class="actions">
                            <button class="btn-action btn-edit" onclick="showModal('modalEdit')">Edit</button>
                            <button class="btn-action btn-hapus" onclick="showModal('modalHapus')">Hapus</button>
                        </td>
                    </tr>
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
            <select>
                <option>Author</option>
                <option>Editor</option>
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

<script>
    const API_URL = 'https://jurnalsmandas.web.id/api/users';
    const TOKEN = localStorage.getItem('access_token');

    if (!TOKEN) {
        window.location.href = "login.html";
    }

    async function loadUsers() {
        try {
            const response = await fetch(API_URL, {
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Accept': 'application/json'
                }
            });
            const result = await response.json();
            const tableBody = document.querySelector('tbody');
            tableBody.innerHTML = ''; // Bersihkan data dummy

            result.data.forEach((user, index) => {
                const badgeClass = user.role.toLowerCase() === 'editor' ? 'badge-editor' : 'badge-author';

                tableBody.innerHTML += `
                    <tr>
                        <td>${index + 1}</td>
                        <td>${user.name}</td>
                        <td>${user.email}</td>
                        <td><span class="badge ${badgeClass}">${user.role}</span></td>
                        <td class="actions">
                            <button class="btn-action btn-edit" onclick='prepareEdit(${JSON.stringify(user)})'>Edit</button>
                            <button class="btn-action btn-hapus" onclick="prepareDelete(${user.id})">Hapus</button>
                        </td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error("Gagal memuat data pengguna:", error);
        }
    }

    let selectedUserId = null;

    function prepareEdit(user) {
        selectedUserId = user.id;
        const modal = document.getElementById('modalEdit');
        modal.querySelector('input[type="text"]').value = user.name;
        modal.querySelector('input[type="email"]').value = user.email;
        modal.querySelector('select').value = user.role;

        modal.querySelector('input[type="text"]').readOnly = true;
        modal.querySelector('input[type="email"]').readOnly = true;

        showModal('modalEdit');
    }

    async function handleUpdateRole() {
        const newRole = document.querySelector('#modalEdit select').value;

        try {
            const res = await fetch(`${API_URL}/${selectedUserId}`, {
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${TOKEN}`,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ role: newRole })
            });

            if (res.ok) {
                alert("Role pengguna berhasil diperbarui!");
                hideModal('modalEdit');
                loadUsers();
            }
        } catch (error) {
            alert("Gagal memperbarui role");
        }
    }
    // Pasang fungsi ke tombol simpan di modal edit
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
                headers: { 'Authorization': `Bearer ${TOKEN}` }
            });

            if (res.ok) {
                hideModal('modalHapus');
                loadUsers();
            }
        } catch (error) {
            alert("Gagal menghapus pengguna");
        }
    }
    document.querySelector('#modalHapus .btn-simpan').onclick = confirmDelete;

    document.querySelector('.btn-logout').onclick = () => {
        localStorage.removeItem('access_token');
        window.location.href = "login.html";
    };

    function showModal(id) { document.getElementById(id).style.display = 'flex'; }
    function hideModal(id) { document.getElementById(id).style.display = 'none'; }

    loadUsers();
</script>

</body>
</html>
