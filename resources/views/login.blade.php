<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threat Intelligence Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }
        .floating-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,0.8) 10%, transparent 70%);
            animation: moveBackground 10s infinite alternate;
        }
        @keyframes moveBackground {
            from {
                transform: translateX(-10px) translateY(-10px);
            }
            to {
                transform: translateX(10px) translateY(10px);
            }
        }
        .container {
            display: flex;
            width: 800px;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            position: relative;
            z-index: 2;
        }
        .left-panel {
            width: 50%;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            animation: fadeInLeft 1.5s ease-in-out;
        }
        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .left-panel img {
            max-width: 100%;
            height: auto;
        }
        .right-panel {
            width: 50%;
            padding: 40px;
            text-align: center;
            animation: fadeInRight 1.5s ease-in-out;
        }
        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        .right-panel h2 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .form-control {
            background: rgba(0, 0, 0, 0.05);
            border: none;
            padding: 12px;
            border-radius: 8px;
            transition: 0.3s;
        }
        .form-control:focus {
            box-shadow: 0px 0px 8px rgba(255, 65, 108, 0.5);
        }
        .btn-login {
            background: linear-gradient(135deg, #ff416c, #ff4b2b);
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            color: white;
            transition: 0.3s ease-in-out;
            box-shadow: 0px 4px 10px rgba(255, 65, 108, 0.3);
        }
        .btn-login:hover {
            background: linear-gradient(135deg, #ff4b2b, #ff416c);
            transform: scale(1.1);
            box-shadow: 0px 6px 15px rgba(255, 65, 108, 0.5);
        }
        .particles {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: 1;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <canvas class="particles"></canvas>
    <div class="floating-bg"></div>
    <div class="container">
        <div class="left-panel">
            <img src="logo.png" alt="Company Logo">
        </div>
        <div class="right-panel">
            <h2>Secure Login</h2>

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
                    <input type="text" class="form-control" id="floatingInput" placeholder="Username or Email" name="email">
                    <label for="floatingInput">Email</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password" name="password">
                    <label for="floatingPassword">Password</label>
                </div>

                <button type="submit" class="btn btn-login w-100">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const canvas = document.querySelector(".particles");
        const ctx = canvas.getContext("2d");
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
        const particles = Array.from({ length: 100 }, () => ({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            radius: Math.random() * 2,
            speed: Math.random() * 1.5,
        }));
        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            particles.forEach(p => {
                ctx.beginPath();
                ctx.arc(p.x, p.y, p.radius, 0, Math.PI * 2);
                ctx.fillStyle = "rgba(255, 65, 108, 0.5)";
                ctx.fill();
                p.y += p.speed;
                if (p.y > canvas.height) p.y = 0;
            });
            requestAnimationFrame(animate);
        }
        animate();
    </script>
</body>
</html>
