<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Jurnalistik</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body, html {
            height: 100%;
        }

        /* Background Full Screen */
        .bg-container {
            background-image: url('/images/camera-bg.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .bg-container::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(0, 0, 0, 0.2);
        }

        /* Kartu Login */
        .login-card {
            background: white;
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            position: relative;
            z-index: 1;
        }

        .login-card h2 {
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .label-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        label {
            font-size: 14px;
            color: #666;
        }

        .forgot-link {
            font-size: 13px;
            color: #777;
            text-decoration: none;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border: 2px solid #333;
        }

        /* Tombol Login */
        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #1da077;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            transition: 0.3s;
        }

        .btn-login:hover {
            background-color: #168a65;
        }

        .btn-login:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }

        .footer-text {
            text-align: center;
            margin-top: 25px;
            font-size: 14px;
            color: #aaa;
        }

        .footer-text a {
            color: #666;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="bg-container">
        <div class="login-card">
            <h2>Login to your account</h2>

            <form id="login-form">
                <div class="input-group">
                    <label>Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" placeholder="Masukkan email anda" required>
                    </div>
                </div>

                <div class="input-group">
                    <div class="label-flex">
                        <label>Password</label>
                        <a href="#" class="forgot-link">Forgot</a>
                    </div>
                    <div class="input-wrapper">
                        <input type="password" id="login-pass" placeholder="Masukkan password anda" required>
                    </div>
                </div>

                <button type="submit" id="btn-submit" class="btn-login">Login</button>
            </form>

            <p class="footer-text">
                Don't Have An Account ? <a href="#">Sign Up</a>
            </p>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('login-form');
        const btnSubmit = document.getElementById('btn-submit');

        loginForm.addEventListener('submit', async (e) => {
            e.preventDefault(); 

            const email = document.getElementById('email').value;
            const password = document.getElementById('login-pass').value;

            // Loading State
            btnSubmit.innerText = "Processing...";
            btnSubmit.disabled = true;

            try {
                const response = await fetch('https://jurnalsmandas.web.id/api/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json' // Memberitahu Laravel ini request API
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                });

                const result = await response.json();
                console.log("Raw Response:", result);

                if (response.ok && result.data && result.data.token) {
                    localStorage.setItem('access_token', result.data.token);

                    alert("Berhasil Login!");

                    window.location.href = "articles.html";
                } else {
                    const errorMsg = result.message || "Email atau password salah.";
                    alert("Gagal Login: " + errorMsg);
                }

            } catch (error) {
                console.error("Fetch Error:", error);
                alert("Koneksi gagal! Pastikan server aktif dan internet lancar.");
            } finally {
                btnSubmit.innerText = "Login";
                btnSubmit.disabled = false;
            }
        });
    </script>
</body>
</html>
