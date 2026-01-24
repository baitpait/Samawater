<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>مياه سما</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* 🌊 إعدادات الصفحة العامة */
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            height: 100vh;
            overflow: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: linear-gradient(180deg, #b2ebf2 0%, #e0f7fa 50%, #ffffff 100%);
            position: relative;
        }

        /* 💧 خلفية مائية متحركة */
        .wave {
            position: absolute;
            width: 200%;
            height: 200%;
            top: -50%;
            left: -50%;
            background: radial-gradient(circle at 50% 50%, rgba(0, 119, 182, 0.1) 25%, transparent 60%),
                        radial-gradient(circle at 30% 70%, rgba(0, 119, 182, 0.15) 20%, transparent 60%),
                        radial-gradient(circle at 70% 30%, rgba(0, 119, 182, 0.12) 25%, transparent 60%);
            animation: moveWaves 10s infinite linear;
            z-index: 0;
        }

        @keyframes moveWaves {
            0% { transform: rotate(0deg) scale(1); }
            50% { transform: rotate(180deg) scale(1.05); }
            100% { transform: rotate(360deg) scale(1); }
        }

        /* 🌟 صندوق المحتوى */
        .container {
            position: relative;
            z-index: 2;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px;
            box-shadow: 0 8px 35px rgba(0, 0, 0, 0.1);
            padding: 40px 30px;
            max-width: 430px;
            animation: fadeIn 1.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        img {
            width: 180px;
            margin-bottom: 20px;
        }

        h1 {
            color: #0077b6;
            margin-bottom: 10px;
            font-size: 26px;
        }

        p {
            color: #333;
            font-size: 16px;
            margin-bottom: 25px;
        }

        a.button {
            display: inline-block;
            background-color: #0077b6;
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: 0.3s;
        }

        a.button:hover {
            background-color: #005f8e;
        }

        /* 💡 تأثير ضوء ناعم */
        .glow {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(0, 198, 255, 0.2) 0%, transparent 80%);
            animation: moveGlow 8s infinite alternate ease-in-out;
            filter: blur(70px);
            z-index: 1;
        }

        @keyframes moveGlow {
            from { top: 10%; left: 15%; }
            to { top: 60%; left: 70%; }
        }
    </style>
</head>
<body>
    <div class="wave"></div>
    <div class="glow"></div>

    <div class="container">
        <img src="{{ asset('logo/Logo-2.png') }}" alt="Eleyyaa Water Logo">
        <h1>مرحباً بكم في مصنع مياه سما</h1>
        <p>نقاء طبيعي، جودة عالية، واهتمام بصحتكم 💧</p>
    </div>
</body>
</html>