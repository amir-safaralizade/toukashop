@extends('layout.app')

@section('styles')
    <style>
        /* باکس جستجوی بزرگ */
        .search-hero {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            color: white;
            padding: 60px 0;
            margin-bottom: 40px;
            border-radius: 0 0 20px 20px;
        }

        .search-box {
            max-width: 700px;
            margin: 0 auto;
        }

        .search-title {
            font-weight: 900;
            margin-bottom: 20px;
            text-align: center;
        }

        .search-form {
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 18px 60px 18px 20px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        .search-btn {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: var(--primary-color);
            border: none;
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            background: #ff5252;
            transform: translateY(-50%) scale(1.05);
        }

        @media (max-width: 768px) {
            .search-hero {
                padding: 40px 0;
            }

            .search-title {
                font-size: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="mt-128"></div>
    <!-- Floating pet icons -->
    <i class="bi bi-egg-fried pet-icon floating" style="top: 15%; left: 5%; animation-delay: 0.2s;"></i>
    <i class="bi bi-bone pet-icon floating" style="top: 80%; right: 10%; animation-delay: 0.5s;"></i>
    <i class="bi bi-balloon-heart pet-icon floating" style="top: 40%; right: 5%; animation-delay: 0.7s;"></i>
    <i class="bi bi-gem pet-icon floating" style="bottom: 10%; left: 15%; animation-delay: 0.3s;"></i>

    <!-- بخش جستجوی بزرگ -->
    <section class="search-hero">
        <div class="container">
            <div class="search-box">
                <h1 class="search-title">آنچه که حیوان خانگی شما نیاز دارد را پیدا کنید</h1>
                <div class="search-form">
                    <input type="text" class="search-input"
                        placeholder="جستجوی محصولات... مانند غذای گربه، اسباب بازی سگ و ...">
                    <button class="search-btn">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>



    <section style="min-height: 80vh"></section>
@endsection
