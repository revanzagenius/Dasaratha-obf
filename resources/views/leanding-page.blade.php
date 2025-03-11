<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dasaratha Landing Page</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html, body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        .fullscreen-image {
            width: 100%;
            height: 100%;
            background: url('desktop22.png') no-repeat center center;
            background-size: 100% 100%;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="fullscreen-image" onclick="window.location.href='{{ route('login.index') }}'"></div>
</body>
</html>
