<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحه مورد نظر یافت نشد | 404</title>
    <style>
        :root {
            --pink: #ff9eb7;
            --light-pink: #ffd6de;
            --dark-pink: #ff7ba3;
            --purple: #b399d4;
            --light-purple: #d9c5f4;
            --cream: #fff4f6;
            --white: #ffffff;
            --text-dark: #5a3d5c;
            --text-light: #ffffff;
            --black: #1a1a1a;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, var(--light-purple) 0%, var(--light-pink) 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            color: var(--text-dark);
        }

        .container {
            background-color: var(--white);
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(90, 61, 92, 0.2);
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .container::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--light-pink), var(--light-purple));
            z-index: 0;
            opacity: 0.5;
        }

        .container::after {
            content: '';
            position: absolute;
            bottom: -60px;
            left: -60px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--light-purple), var(--light-pink));
            z-index: 0;
            opacity: 0.5;
        }

        .content {
            position: relative;
            z-index: 1;
        }

        .error-code {
            font-size: 120px;
            font-weight: 800;
            background: linear-gradient(to right, var(--dark-pink), var(--purple));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 10px;
            line-height: 1;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 20px;
            color: var(--text-dark);
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .home-btn {
            display: inline-block;
            background: linear-gradient(to right, var(--dark-pink), var(--purple));
            color: var(--text-light);
            padding: 12px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(255, 123, 163, 0.4);
        }

        .home-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 123, 163, 0.6);
        }

        .illustration {
            margin: 30px 0;
            position: relative;
        }

        .circle {
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, var(--light-pink), var(--light-purple));
            border-radius: 50%;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
        }

        .circle::after {
            content: '404';
            position: absolute;
            font-size: 40px;
            font-weight: 800;
            color: var(--dark-pink);
        }

        @media (max-width: 576px) {
            .container {
                padding: 30px 20px;
            }
            
            .error-code {
                font-size: 100px;
            }
            
            h1 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="illustration">
                <div class="circle"></div>
            </div>
            <div class="error-code">404</div>
            <h1>صفحه مورد نظر پیدا نشد!</h1>
            <p>متأسفیم، اما صفحه‌ای که به دنبال آن هستید وجود ندارد، حذف شده یا نام آن تغییر کرده است.</p>
            <a href="/" class="home-btn">بازگشت به صفحه اصلی</a>
        </div>
    </div>
</body>
</html>