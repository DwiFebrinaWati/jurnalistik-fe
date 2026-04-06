<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Jurnalistik</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        /* Background Full Screen */
        .bg-overlay {
            background-image: url('/images/camera-bg.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Kartu Putih */
        .card {
            background: white;
            width: 90%;
            max-width: 500px;
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            text-align: center;
        }

        .card h2 {
            font-size: 24px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 40px;
        }

        /* Form Styling */
        .form-group {
            text-align: left;
            margin-bottom: 25px;
        }

        label {
            display: block;
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid #333;
            border-radius: 10px;
            font-size: 14px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #1da077;
            box-shadow: 0 0 0 2px rgba(29, 160, 119, 0.1);
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: #1da077;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .btn-submit:hover {
            background-color: #168a65;
        }

        .back-to-login {
            margin-top: 20px;
            display: inline-block;
            font-size: 13px;
            color: #888;
            text-decoration: none;
        }

        .back-to-login:hover {
            color: #333;
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="bg-overlay">
        <div class="card">
            <h2>Lupa Password?</h2>

            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Masukkan email anda" required>
                </div>

                <button type="submit" class="btn-submit">
                    Kirim Link Konfirmasi
                </button>
            </form>

            <a href="{{ route('login') }}" class="back-to-login">
                Kembali ke halaman Login
            </a>
        </div>
    </div>

</body>
</html>
