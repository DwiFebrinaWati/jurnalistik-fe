<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Jurnalistik</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        /* Base Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            display: flex;
            min-height: 100vh;
            height: 100vh;
        }

        .left-side {
            flex: 1;
            background-image: url('/images/camera-bg.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
            display: none;
        }

        .logo-overlay {
            position: absolute;
            top: 40px;
            left: 40px;
            padding: 10px 20px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-overlay img {
            height: 80px;
            width: auto;
            display: block;
        }

        .right-side {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
            padding: 40px;
        }

        .form-box {
            width: 100%;
            max-width: 400px;
        }

        .form-box h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 8px;
            color: #555;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        .input-group input:focus {
            border-color: #1da077;
        }

        /* Tombol Register */
        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: #1da077;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn-submit:hover {
            background-color: #168a65;
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #777;
        }

        .footer-text a {
            color: #333;
            text-decoration: none;
            font-weight: 600;
        }

        @media (min-width: 1024px) {
            .left-side {
                display: block;
            }
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="left-side">
            <div class="logo-overlay">
                <img src="/images/logo.png" alt="Logo">
            </div>
        </div>

        <div class="right-side">
            <div class="form-box">
                <h2>Create an account</h2>

                <form action="#">
                    <div class="input-group">
                        <label>Nama Lengkap</label>
                        <input type="text" placeholder="Masukkan Nama Lengkap">
                    </div>

                    <div class="input-group">
                        <label>Email</label>
                        <input type="email" placeholder="Masukkan Email">
                    </div>

                    <div class="input-group">
                        <label>Password</label>
                        <div style="position: relative;">
                            <input type="password" id="password" placeholder="Masukkan Password">
                        </div>
                    </div>

                    <div class="input-group">
                        <label>Konfirmasi Password</label>
                        <div style="position: relative;">
                            <input type="password" id="confirm_password" placeholder="Konfirmasi Password">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">Create account</button>
                </form>

                <p class="footer-text">
                    Already Have An Account ? <a href="{{ route('login') }}">Log In</a>
                </p>
            </div>
        </div>
    </div>

<script>
    const REGISTER_URL = 'https://jurnalsmandas.web.id/api/register';

    async function handleRegister(event) {
        event.preventDefault();

        const name = document.querySelector('input[placeholder="Masukkan Nama Lengkap"]').value;
        const email = document.querySelector('input[placeholder="Masukkan Email"]').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        const submitBtn = document.querySelector('.btn-submit');

        if (password !== confirmPassword) {
            alert("Password dan Konfirmasi Password tidak cocok!");
            return;
        }

        if (password.length < 8) {
            alert("Password minimal harus 8 karakter.");
            return;
        }

        submitBtn.innerText = "Processing...";
        submitBtn.disabled = true;

        try {
            const response = await fetch(REGISTER_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    password: password,
                    password_confirmation: confirmPassword
                })
            });

            const result = await response.json();

            if (response.ok) {
                alert("Registrasi Berhasil! Silakan login untuk melanjutkan.");
                window.location.href = "login.html";
            } else {
                alert(result.message || "Registrasi gagal. Periksa kembali data Anda.");
            }
        } catch (error) {
            console.error("Error:", error);
            alert("Terjadi kesalahan jaringan.");
        } finally {
            submitBtn.innerText = "Create account";
            submitBtn.disabled = false;
        }
    }

    document.querySelector('form').onsubmit = handleRegister;
</script>

</body>
</html>
