<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dasaratha</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #ffffff; /* Background abu-abu */
      color: white;
      height: 100vh;
      margin: 0;
    }
    .container-fluid {
      height: 100%;
    }
    .logo-section {
      background-color: #ffffff;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      padding: 0 20px;
    }
    .logo-section img {
      width: 400px; /* Ukuran logo lebih besar */
      max-width: 90%; /* Agar responsif pada layar kecil */
      margin-bottom: 20px;
    }
    .logo-section h1 {
      font-size: 3rem;
      font-weight: bold;
      text-align: center;
    }
    .login-section {
      background-color: #a80000; /* Background putih */
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 40px;
    }
    .login-section h2 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }
    .login-section .form-label {
      font-weight: bold;
    }
    .login-section .btn-primary {
      background-color: #d14103;
      border: none;
    }
    .login-section .btn-primary:hover {
      background-color: #ff5005;
    }
    .login-section .text-muted {
      text-align: center;
      font-size: 0.9rem;
    }
    @media (min-width: 768px) {
      .logo-section {
        flex: 3; /* Memperbesar bagian logo */
      }
      .login-section {
        flex: 1; /* Memperkecil bagian login */
      }
    }
    body {
    background-color: #000; /* Warna latar belakang gelap agar efek listrik terlihat jelas */
    position: relative;
    overflow: hidden;
  }

  .electricity {
    position: absolute;
    width: 2px;
    height: 100px;
    background: linear-gradient(to bottom, rgba(0, 255, 255, 1), rgba(0, 255, 255, 0.5), rgba(0, 255, 255, 0));
    animation: flicker 0.1s infinite ease-in-out;
    transform: rotate(0deg);
  }

  @keyframes flicker {
    0%, 100% {
      transform: rotate(calc(360deg * var(--random-angle)));
      opacity: 1;
    }
    50% {
      transform: rotate(calc(360deg * var(--random-angle) - 10deg));
      opacity: 0.7;
    }
  }
  </style>
</head>
<body>
  <div class="container-fluid">
    <div class="row h-100">
      <!-- Bagian Logo -->
      <div class="col-md-8 logo-section">
        <img src="logo.png" alt="Dasaratha">
      </div>
      <!-- Bagian Login -->
      <div class="col-md-4 login-section">
        <h2>Sign In</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="floatingInput" placeholder="Usermane or Email" name="email">
                <label for="floatingInput">Email</label>
            </div>

            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="floatingPassword" placeholder="password" name="password">
                <label for="floatingPassword">Password</label>
            </div>

            <button class="btn btn-primary w-100 login-btn mb-3">
                Login
            </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function createBubble() {
      const body = document.body;
      const bubble = document.createElement('div');
      bubble.classList.add('bubble');

      // Tentukan posisi horizontal acak
      const size = Math.random() * 50 + 10; // Ukuran acak
      bubble.style.width = `${size}px`;
      bubble.style.height = `${size}px`;
      bubble.style.left = `${Math.random() * 100}vw`;
      bubble.style.animationDuration = `${Math.random() * 5 + 5}s`; // Durasi animasi acak
      bubble.style.animationDelay = `${Math.random() * 3}s`;

      body.appendChild(bubble);

      // Hapus elemen bubble setelah animasi selesai
      bubble.addEventListener('animationend', () => {
        bubble.remove();
      });
    }

    // Tambahkan bubble secara berkala
    setInterval(createBubble, 500);
  </script>
</body>
</html>
