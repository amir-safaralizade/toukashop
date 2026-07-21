@extends('layout.app')

@section('seo')
    <x-seo::seo-meta-display :model="$data->page" />
@endsection

@section('styles')
    <style>
        /* استایل جدید برای کارت محصولات با افکت کلیک */


        .featured-section {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.05) 0%, rgba(78, 205, 196, 0.05) 100%);
            border-radius: 25px;
            padding: 50px;
            margin: 60px 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.06);
        }

        .featured-section::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 200px;
            height: 200px;
            background: rgba(78, 205, 196, 0.1);
            border-radius: 50%;
            z-index: 0;
        }

        .featured-section::after {
            content: '';
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 150px;
            height: 150px;
            background: rgba(255, 107, 107, 0.1);
            border-radius: 50%;
            z-index: 0;
        }

        .featured-content {
            position: relative;
            z-index: 2;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            right: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-list li {
            margin-bottom: 15px;
            padding-right: 30px;
            position: relative;
            font-size: 1.1rem;
        }

        .feature-list li::before {
            content: '✓';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 24px;
            height: 24px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: bold;
        }

        .product-showcase {
            position: relative;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .main-product {
            width: 100%;
            max-width: 400px;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            transition: all 0.4s ease;
        }

        .main-product:hover {
            transform: translateY(-10px) rotate(2deg);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
        }

        .floating-products {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
        }

        .floating-item {
            position: absolute;
            width: 100px;
            height: 100px;
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: all 0.5s ease;
        }

        .floating-item:nth-child(1) {
            top: 10%;
            left: 10%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-item:nth-child(2) {
            top: 60%;
            left: 5%;
            animation: float 7s ease-in-out infinite 1s;
        }

        .floating-item:nth-child(3) {
            top: 30%;
            right: 5%;
            animation: float 5s ease-in-out infinite 0.5s;
        }

        .floating-item:nth-child(4) {
            top: 70%;
            right: 15%;
            animation: float 8s ease-in-out infinite 1.5s;
        }

        .floating-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-15px) rotate(5deg);
            }

            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.9rem;
            margin-bottom: 15px;
            display: inline-block;
        }

        /* رسپانسیو برای موبایل */
        @media (max-width: 992px) {
            .featured-section {
                padding: 30px;
            }

            .section-title {
                font-size: 2rem;
            }

            .product-showcase {
                margin-top: 40px;
            }

            .floating-item {
                width: 80px;
                height: 80px;
            }
        }


        .habitat-section {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.03) 0%, rgba(78, 205, 196, 0.03) 100%);
            border-radius: 30px;
            padding: 80px 0;
            margin: 80px 0;
            position: relative;
            overflow: hidden;
        }

        .habitat-section::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: rgba(78, 205, 196, 0.08);
            border-radius: 50%;
            z-index: 0;
        }

        .habitat-section::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 250px;
            height: 250px;
            background: rgba(255, 107, 107, 0.08);
            border-radius: 50%;
            z-index: 0;
        }

        .habitat-header {
            text-align: center;
            margin-bottom: 70px;
            position: relative;
            z-index: 2;
        }

        .section-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            margin-bottom: 25px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }

        .section-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            right: 50%;
            transform: translateX(50%);
            width: 100px;
            height: 6px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 3px;
        }

        .section-subtitle {
            font-size: 1.4rem;
            color: #666;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.8;
        }

        .habitat-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .habitat-info {
            padding-left: 20px;
        }

        .habitat-features {
            list-style: none;
            padding: 0;
            margin: 0 0 40px 0;
        }

        .habitat-features li {
            margin-bottom: 20px;
            padding-right: 40px;
            position: relative;
            font-size: 1.2rem;
            line-height: 1.6;
        }

        .habitat-features li::before {
            content: '✓';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 30px;
            height: 30px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            font-weight: bold;
        }

        .habitat-image {
            position: relative;
            height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            transition: all 0.5s ease;
        }

        .habitat-image:hover {
            transform: translateY(-10px) rotate(2deg);
            box-shadow: 0 35px 60px rgba(0, 0, 0, 0.2);
        }

        .habitat-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.8s ease;
        }

        .habitat-image:hover img {
            transform: scale(1.05);
        }

        .habitat-types {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-top: 60px;
            position: relative;
            z-index: 2;
        }

        .habitat-type {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .habitat-type::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .habitat-type:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.12);
        }

        .type-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            color: white;
            font-size: 2rem;
            transition: all 0.3s ease;
        }

        .habitat-type:hover .type-icon {
            transform: scale(1.1) rotate(10deg);
        }

        .type-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--dark-color);
        }

        .type-description {
            color: #666;
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        .floating-animal {
            position: absolute;
            font-size: 3.5rem;
            opacity: 0.1;
            z-index: 1;
        }

        .floating-animal:nth-child(1) {
            top: 15%;
            left: 8%;
            animation: float 9s ease-in-out infinite;
        }

        .floating-animal:nth-child(2) {
            top: 65%;
            right: 7%;
            animation: float 8s ease-in-out infinite 1s;
        }

        .floating-animal:nth-child(3) {
            top: 35%;
            right: 12%;
            animation: float 10s ease-in-out infinite 0.5s;
        }

        .floating-animal:nth-child(4) {
            bottom: 10%;
            left: 15%;
            animation: float 7s ease-in-out infinite 1.5s;
        }

        @keyframes float {
            0% {
                transform: translateY(0) rotate(0deg);
            }

            50% {
                transform: translateY(-25px) rotate(5deg);
            }

            100% {
                transform: translateY(0) rotate(0deg);
            }
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* رسپانسیو برای موبایل */
        @media (max-width: 992px) {
            .habitat-content {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .habitat-types {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 40px auto 0;
            }

            .section-title {
                font-size: 2.3rem;
            }

            .habitat-image {
                height: 350px;
            }

            .floating-animal {
                display: none;
            }
        }


        .articles-section {
            padding: 80px 0;
            background: linear-gradient(to bottom, #ffffff, #f8f9fa);
        }

        .section-header {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-badge {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1rem;
            display: inline-block;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 800;
            color: var(--dark-color);
            margin-bottom: 20px;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            right: 50%;
            transform: translateX(50%);
            width: 80px;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            border-radius: 3px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .articles-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .article-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .article-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .article-image {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .article-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .article-card:hover .article-image img {
            transform: scale(1.1);
        }

        .article-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 6px 15px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            z-index: 2;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .article-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .article-title {
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--dark-color);
            line-height: 1.4;
        }

        .article-excerpt {
            color: #666;
            font-size: 1rem;
            margin-bottom: 20px;
            line-height: 1.7;
            flex-grow: 1;
        }

        .article-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .article-date {
            color: #888;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .article-date i {
            margin-left: 5px;
        }

        .article-read-more {
            color: var(--primary-color);
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .article-read-more:hover {
            color: var(--secondary-color);
        }

        .article-read-more i {
            margin-right: 5px;
            transition: transform 0.3s ease;
        }

        .article-read-more:hover i {
            transform: translateX(-5px);
        }

        .view-all-btn {
            text-align: center;
            margin-top: 50px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        /* رسپانسیو برای موبایل */
        @media (max-width: 992px) {
            .articles-container {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }

            .section-title {
                font-size: 2.2rem;
            }
        }

        .hero-slider {
            height: 60vh;
            position: relative;
            overflow: hidden;
        }

        .slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transition: opacity 1s ease;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide.active {
            opacity: 1;
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgb(0 0 0 / 10%);
        }

        .slide-content {
            position: relative;
            z-index: 10;
            color: white;
            text-align: center;
            padding: 0 20px;
            max-width: 800px;
            margin-top: 10%;
        }

        .slide-subtitle {
            font-size: 1.2rem;
            margin-bottom: 15px;
            display: block;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards;
            animation-delay: 0.5s;
        }

        .slide-title {
            font-size: 3.5rem;
            font-weight: 900;
            margin-bottom: 20px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards;
            animation-delay: 0.8s;
        }

        .slide-description {
            font-size: 1.2rem;
            margin-bottom: 30px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards;
            animation-delay: 1.1s;
        }

        .slide-btn {
            background: var(--primary-color);
            color: white;
            border: none;
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 1s ease forwards;
            animation-delay: 1.4s;
        }

        .slide-btn:hover {
            background: #e05a5a;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .slider-controls {
            position: absolute;
            bottom: 50px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 20;
        }

        .slider-dots {
            display: flex;
            gap: 12px;
        }

        .slider-dot {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .slider-dot.active {
            background: white;
            transform: scale(1.3);
        }

        .slider-arrows {
            position: absolute;
            bottom: 40px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 50px;
            z-index: 20;
        }

        .slider-arrow {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.5rem;
        }

        .slider-arrow:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .slide-counter {
            position: absolute;
            bottom: 60px;
            right: 60px;
            color: white;
            font-size: 1.2rem;
            font-weight: 700;
            z-index: 20;
        }

        .pet-icon {
            position: absolute;
            font-size: 2rem;
            color: rgba(255, 255, 255, 0.2);
            z-index: 5;
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-15px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .slide-title {
                font-size: 2.8rem;
            }

            .slide-description {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 768px) {
            .slide-title {
                font-size: 2.2rem;
            }

            .slide-description {
                font-size: 1rem;
            }

            .slide-btn {
                padding: 12px 25px;
                font-size: 1rem;
            }

            .slider-arrows {
                padding: 0 20px;
            }

            .slider-arrow {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
            }

            .slide-counter {
                bottom: 40px;
                right: 40px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .slide-title {
                font-size: 1.8rem;
            }

            .slide-subtitle {
                font-size: 1rem;
            }

            .slide-content {
                padding: 0 15px;
            }

            .slider-arrows {
                padding: 0 15px;
            }

            .slide-counter {
                bottom: 30px;
                right: 30px;
            }
        }


        .creative-banner-section {
            padding: 80px 0;
            margin: 60px 0;
        }

        .banner-container {
            display: flex;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            gap: 20px;
            height: 500px;
        }

        .main-banner {
            flex: 2;

            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.4s ease;
        }

        .main-banner:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .main-banner-content {
            text-align: center;
            padding: 30px;
            z-index: 2;
        }

        .main-banner h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.2);
        }

        .main-banner p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            max-width: 80%;
            margin-left: auto;
            margin-right: auto;
        }

        .side-banners {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .small-banner {
            flex: 1;
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.4s ease;
        }

        .small-banner:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .small-banner:first-child {
            background: linear-gradient(rgba(142, 68, 173, 0.5),
                    rgba(255, 230, 109, 0.5)),
                url("https://toukashop.ir/site/images/image_tqvGenghp7vLzedr54DMgZgIemTRBn0TpE3S.webp") no-repeat center center / cover;
        }

        .small-banner:last-child {
            background: linear-gradient(rgba(78, 205, 196, 0.5),
                    rgba(255, 158, 183, 0.5)),
                url("https://toukashop.ir/site/images/categoryBackgroud.jpg") no-repeat center center / cover;
        }

        .small-banner-content {
            text-align: center;
            padding: 20px;
            z-index: 2;
        }

        .small-banner h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .banner-btn {
            background-color: white;
            color: var(--dark-color);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .banner-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .main-banner .banner-btn {
            background-color: var(--primary-color);
            color: white;
        }

        /* تزئینات خلاقانه */
        .banner-decoration {
            position: absolute;
            z-index: 1;
            opacity: 0.1;
        }

        .decoration-1 {
            top: 20px;
            right: 20px;
            font-size: 5rem;
        }

        .decoration-2 {
            bottom: 30px;
            left: 30px;
            font-size: 4rem;
        }

        .decoration-3 {
            top: 15px;
            left: 15px;
            font-size: 3rem;
        }

        .decoration-4 {
            bottom: 20px;
            right: 20px;
            font-size: 3.5rem;
        }

        /* واکنش‌گرایی */
        @media (max-width: 992px) {
            .banner-container {
                flex-direction: column;
                height: auto;
            }

            .main-banner,
            .small-banner {
                min-height: 300px;
            }

            .side-banners {
                flex-direction: row;
            }
        }

        @media (max-width: 576px) {
            .side-banners {
                flex-direction: column;
            }

            .main-banner h2 {
                font-size: 2rem;
            }

            .small-banner h3 {
                font-size: 1.3rem;
            }
        }
    </style>

    <style>
        .animal-container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* استایل بخش دسته‌بندی حیوانات */
        .animal-categories-section {
            padding: 80px 0;
        }

        .animal-section-header {
            text-align: center;
            margin-bottom: 70px;
        }

        .animal-section-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--animal-dark-color);
            margin-bottom: 20px;
            position: relative;
            display: inline-block;
        }

        .animal-section-title::after {
            content: '';
            position: absolute;
            bottom: -15px;
            right: 50%;
            transform: translateX(50%);
            width: 120px;
            height: 6px;
            background: linear-gradient(90deg, var(--animal-primary-color), var(--animal-secondary-color));
            border-radius: 3px;
        }

        .animal-section-subtitle {
            font-size: 1.3rem;
            color: var(--animal-gray-color);
            max-width: 700px;
            margin: 0 auto;
            line-height: 1.8;
        }

        .animal-categories-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
        }

        .animal-category-card {
            background: white;
            border-radius: var(--animal-border-radius);
            padding: 40px 30px;
            text-align: center;
            box-shadow: var(--animal-box-shadow);
            transition: var(--animal-transition);
            position: relative;
            overflow: hidden;
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .animal-category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--animal-primary-color), var(--animal-secondary-color));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.5s ease;
        }

        .animal-category-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        .animal-category-card:hover::before {
            transform: scaleX(1);
        }

        .animal-category-title {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 15px;
            color: var(--animal-dark-color);
            position: relative;
            display: inline-block;
        }

        .animal-category-title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            right: 0;
            width: 50px;
            height: 3px;
            background: var(--animal-primary-color);
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        .animal-category-card:hover .animal-category-title::after {
            width: 100%;
        }

        .animal-category-description {
            color: var(--animal-gray-color);
            font-size: 1.1rem;
            line-height: 1.7;
            margin-bottom: 25px;
        }

        .animal-category-count {
            display: inline-block;
            background: linear-gradient(135deg, var(--animal-primary-color), var(--animal-secondary-color));
            color: white;
            padding: 10px 25px;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: var(--animal-transition);
        }

        .animal-category-card:hover .animal-category-count {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        /* استایل برای حالت کلیک */
        .animal-category-card.active {
            border: 2px solid var(--animal-primary-color);
            background: linear-gradient(135deg, #ffffff 0%, #f8fdff 100%);
        }

        /* استایل برای نمایش زیردسته‌ها */
        .animal-subcategories {
            display: none;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid #eee;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animal-category-card.active .animal-subcategories {
            display: block;
        }

        .animal-subcategory-list {
            list-style: none;
            text-align: right;
        }

        .animal-subcategory-item {
            padding: 12px 0;
            border-bottom: 1px dashed #eee;
            transition: var(--animal-transition);
        }

        .animal-subcategory-item:hover {
            background: rgba(78, 205, 196, 0.05);
            padding-right: 10px;
            border-radius: 8px;
        }

        .animal-subcategory-item:last-child {
            border-bottom: none;
        }

        .animal-subcategory-link {
            color: var(--animal-gray-color);
            text-decoration: none;
            transition: var(--animal-transition);
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1rem;
            font-weight: 500;
        }

        .animal-subcategory-link:hover {
            color: var(--animal-primary-color);
        }

        .animal-subcategory-count {
            background: rgba(255, 107, 107, 0.1);
            color: var(--animal-secondary-color);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* استایل برای نمایش شبکه‌ای */
        .animal-categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
            margin-top: 60px;
        }

        .animal-grid-category {
            background: white;
            border-radius: var(--animal-border-radius);
            padding: 30px 20px;
            text-align: center;
            box-shadow: var(--animal-box-shadow);
            transition: var(--animal-transition);
            cursor: pointer;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .animal-grid-category:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
        }

        .animal-grid-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--animal-dark-color);
            margin-bottom: 15px;
        }

        .animal-grid-count {
            display: inline-block;
            background: linear-gradient(135deg, var(--animal-primary-color), var(--animal-secondary-color));
            color: white;
            padding: 8px 18px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
        }

        /* دکمه مشاهده همه */
        .animal-view-all {
            text-align: center;
            margin-top: 70px;
        }

        .animal-btn-primary {
            background: linear-gradient(135deg, var(--animal-primary-color), var(--animal-secondary-color));
            border: none;
            padding: 16px 40px;
            border-radius: 50px;
            color: white;
            font-weight: 700;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--animal-transition);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            position: relative;
            overflow: hidden;
        }

        .animal-btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .animal-btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
        }

        .animal-btn-primary:hover::before {
            left: 100%;
        }

        /* رسپانسیو */
        @media (max-width: 1200px) {
            .animal-categories-container {
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            }
        }

        @media (max-width: 992px) {
            .animal-categories-container {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }

            .animal-section-title {
                font-size: 2.5rem;
            }

            .animal-category-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 768px) {
            .animal-categories-container {
                grid-template-columns: 1fr;
                max-width: 500px;
                margin: 0 auto;
            }

            .animal-section-title {
                font-size: 2.2rem;
            }

            .animal-categories-grid {
                grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            }
        }

        @media (max-width: 576px) {
            .animal-categories-section {
                padding: 60px 0;
            }

            .animal-section-title {
                font-size: 2rem;
            }

            .animal-categories-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .animal-category-card {
                padding: 30px 20px;
            }

            .animal-category-title {
                font-size: 1.6rem;
            }
        }


        /* استایل کارت‌های حیوانات با تصویر بند انگشتی */
        .animal-categories-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
        }

        .animal-category-card {
            background: white;
            border-radius: var(--animal-border-radius);
            overflow: hidden;
            box-shadow: var(--animal-box-shadow);
            transition: var(--animal-transition);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .animal-category-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
            text-decoration: none;
        }

        /* بخش تصویر */
        .animal-card-image {
            position: relative;
            width: 100%;
            padding-bottom: 75%;
            /* نسبت 4:3 */
            overflow: hidden;
            background: #f8f9fa;
        }

        .animal-thumb {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: all 0.5s ease;
        }

        .animal-category-card:hover .animal-thumb {
            transform: scale(1.1);
        }

        /* اوورلای روی تصویر با آیکون */
        .animal-card-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg,
                    rgba(0, 0, 0, 0.2) 0%,
                    rgba(0, 0, 0, 0.5) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: all 0.4s ease;
        }

        .animal-category-card:hover .animal-card-overlay {
            opacity: 1;
        }

        .animal-card-icon {
            font-size: 3rem;
            opacity: 0.8;
            transform: scale(0.5);
            transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .animal-category-card:hover .animal-card-icon {
            transform: scale(1);
            opacity: 1;
        }

        /* بخش اطلاعات */
        .animal-card-info {
            padding: 18px 20px 20px;
            text-align: center;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .animal-category-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--animal-dark-color);
            margin-bottom: 6px;
        }

        .animal-category-count {
            display: inline-block;
            background: linear-gradient(135deg, var(--animal-primary-color), var(--animal-secondary-color));
            color: white;
            padding: 4px 16px;
            border-radius: 50px;
            font-size: 0.8rem;
            font-weight: 600;
            transition: var(--animal-transition);
        }

        .animal-category-card:hover .animal-category-count {
            transform: scale(1.1);
        }

        /* رسپانسیو */
        @media (max-width: 768px) {
            .animal-categories-container {
                grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
                gap: 15px;
            }

            .animal-card-info {
                padding: 12px 15px 15px;
            }

            .animal-category-title {
                font-size: 1rem;
            }

            .animal-card-icon {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 480px) {
            .animal-categories-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
        }
    </style>
@endsection

@section('content')
    <div class="hero-slider">
        @forelse ($data->sliders as $index => $slider)
            <div class="slide {{ $index == 0 ? 'active' : '' }}"
                style="background-image: url('{{ get_full_url($slider->image) }}');">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    {{-- <span class="slide-subtitle">{{ $slider->title }}</span>
                    <h1 class="slide-title">{{ $slider->title }}</h1>
                    <p class="slide-description">{{ $slider->title }}</p> --}}
                    @if ($slider->link)
                        <a href="{{ $slider->link }}" class="slide-btn">مشاهده</a>
                    @else
                        <button class="slide-btn">مشاهده</button>
                    @endif
                </div>

                <!-- Floating pet icons -->
                @php
                    $icons = [
                        ['class' => 'bi bi-egg-fried', 'top' => '20%', 'left' => '10%', 'delay' => '0.2s'],
                        ['class' => 'bi bi-bone', 'top' => '70%', 'right' => '15%', 'delay' => '0.5s'],
                        ['class' => 'bi bi-balloon-heart', 'top' => '30%', 'right' => '20%', 'delay' => '0.7s'],
                        ['class' => 'bi bi-gem', 'bottom' => '10%', 'left' => '20%', 'delay' => '0.3s'],
                    ];
                    // انتخاب تصادفی 2 تا 4 آیکون
                    $selectedIcons = array_rand(array_flip(array_keys($icons)), rand(2, 4));
                    foreach ($selectedIcons as $i) {
                        $icon = $icons[$i];
                        echo "<i class='{$icon['class']} pet-icon floating' style='";
                        if (isset($icon['top'])) {
                            echo "top: {$icon['top']};";
                        }
                        if (isset($icon['bottom'])) {
                            echo "bottom: {$icon['bottom']};";
                        }
                        if (isset($icon['left'])) {
                            echo "left: {$icon['left']};";
                        }
                        if (isset($icon['right'])) {
                            echo "right: {$icon['right']};";
                        }
                        echo "animation-delay: {$icon['delay']};'></i>";
                    }
                @endphp
            </div>
        @empty
            <div class="slide">
                <div class="slide-overlay"></div>
                <div class="slide-content">
                    <span class="slide-subtitle">اسلایدری وجود ندارد</span>
                    <h1 class="slide-title">هیچ اسلایدری ثبت نشده است</h1>
                    <p class="slide-description">لطفاً از پنل مدیریت اسلایدر اضافه کنید.</p>
                </div>
            </div>
        @endforelse

        <!-- Slider Controls -->
        <div class="slider-controls">
            <div class="slider-dots">
                @foreach ($data->sliders as $index => $slider)
                    <div class="slider-dot {{ $index == 0 ? 'active' : '' }}" data-slide="{{ $index }}"></div>
                @endforeach
            </div>
        </div>

        <div class="slider-arrows">
            <div class="slider-arrow prev">
                <i class="bi bi-arrow-right"></i>
            </div>
            <div class="slider-arrow next">
                <i class="bi bi-arrow-left"></i>
            </div>
        </div>

        <div class="slide-counter">
            <span class="current">01</span> / <span
                class="total">{{ str_pad(count($data->sliders), 2, '0', STR_PAD_LEFT) }}</span>
        </div>
    </div>

    <!-- Creative Section 1 - Pet Categories -->

    <section class="animal-categories-section">
        <div class="animal-container">
            <div class="animal-section-header">
                <h2 class="animal-section-title">محصولات برای انواع حیوانات</h2>
                <p class="animal-section-subtitle">محصولات و خدمات تخصصی برای انواع حیوانات خانگی</p>
            </div>

            <div class="animal-categories-container">
                @foreach ($data->animal_tags as $animal_tag)
                    <a href="{{ route('products.tag', $animal_tag->slug) }}" class="animal-category-card">
                        <div class="animal-card-image">
                            @php
                                $imageUrl =
                                    $animal_tag->firstMedia('tags_main_image')?->full_url ??
                                    ($defaultImages[$animal_tag->name] ?? 'site/images/default-animal-tag.jpg');
                            @endphp
                            <img src="{{ $imageUrl }}" alt="{{ $animal_tag->name }}" class="animal-thumb">

                        </div>
                        <div class="animal-card-info">
                            <h3 class="animal-category-title">{{ $animal_tag->name }}</h3>
                            <span class="animal-category-count">{{ sizeof($animal_tag->products) }} محصول</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>


    <section class="creative-banner-section">
        <div class="banner-container">
            <a href="{{ $data->main_banner->link }}" class="main-banner"
                style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
            url('{{ get_full_url($data->main_banner->image) ?? '' }}') no-repeat center center / cover;">
                <div class="main-banner-content">
                    <h2>{{ $data->main_banner->title }}</h2>
                    <p>{{ $data->main_banner->description }}</p>
                    {{-- <button class="banner-btn">همین حالا ببینید</button> --}}
                </div>
                <div class="banner-decoration decoration-1">🐾</div>
                <div class="banner-decoration decoration-2">❤️</div>
            </a>

            <div class="side-banners">
                {{-- Second Banner --}}
                <a class="small-banner" href="{{ $data->second_banner->link }}"
                    style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                    url('{{ get_full_url($data->second_banner->image) ?? '' }}') no-repeat center center / cover;">
                    <div class="small-banner-content">
                        <h3>{{ $data->second_banner->title }}</h3>
                        <p>{{ $data->second_banner->description }}</p>
                        {{-- <button class="banner-btn">{{ $data->second_banner->button_text ?? 'مشاهده' }}</button> --}}
                    </div>
                    <div class="banner-decoration decoration-3">🎯</div>
                </a>

                {{-- Third Banner --}}
                <a class="small-banner" href="{{ $data->third_banner->link }}"
                    style="background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                    url('{{ get_full_url($data->third_banner->image) ?? '' }}') no-repeat center center / cover;">
                    <div class="small-banner-content">
                        <h3>{{ $data->third_banner->title }}</h3>
                        <p>{{ $data->third_banner->description }}</p>
                        {{-- <button class="banner-btn">{{ $data->third_banner->button_text ?? 'بیشتر' }}</button> --}}
                    </div>
                    <div class="banner-decoration decoration-4">✉️</div>
                </a>
            </div>

        </div>
    </section>

    <!-- Popular Products -->
    <section class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">
                {{ site_setting('title_of_the_first_list_of_products_on_the_home_page') }}</h2>
            <p class="lead">{{ site_setting('slogan_of_the_first_list_of_products_on_the_home_page') }}</p>
        </div>
        <div class="products-container">
            @foreach ($data->products as $product)
                <div class="product-card animate__animated animate__fadeInUp">
                    <a href="{{ route('products.show', $product->slug) }}" class="product-link"></a>
                    <div class="product-badge">پرفروش</div>
                    {{-- <button class="product-wishlist">
                        <i class="bi bi-heart"></i>
                    </button> --}}
                    <div class="product-img-container">
                        <img src="{{ asset($product->firstMedia('main_image')->full_url) }}" class="product-img"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="product-content">
                        <span class="product-category">{{ $product->category->name }}</span>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        {{-- <p class="product-description">غذای کامل و مقوی مخصوص گربه های بالغ با طعم مرغ</p> --}}

                        <div class="product-rating">
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <span class="rating-count">(42)</span>
                        </div>

                        <div class="product-price-container">
                            <div class="product-price">
                                <span class="current-price">{{ number_format($product->price) }} تومان</span>
                                <span class="old-price">{{ number_format($product->price * 1.12) }} تومان</span>
                            </div>
                            <div class="product-actions">
                                <a href="{{ route('products.show', $product->slug) }}" class="add-to-cart">
                                    <i class="bi bi-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg text-dark">مشاهده همه محصولات</a>
        </div>
    </section>

    <section class="featured-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="featured-content">
                        <span class="badge">پرفروش ترین ها</span>
                        <h2 class="section-title">بهترین ظرف غذاهای حیوانات</h2>
                        <p class="section-subtitle">
                            در توکا پت شاپ، با کیفیت‌ترین و بادوام‌ترین ظرف غذاها را برای حیوانات خانگی خود پیدا کنید.
                            محصولاتی که سلامت و راحتی حیوان شما را تضمین می‌کنند.
                        </p>

                        <ul class="feature-list">
                            <li>ساخته شده از مواد باکیفیت و غیرسمی</li>
                            <li>طراحی ارگونومیک برای راحتی حیوان</li>
                            <li>قابل استفاده در ماشین ظرفشویی</li>
                            <li>ضد لغزش و مقاوم در برابر ضربه</li>
                            <li>مناسب برای تمام نژادها و سنین</li>
                            <li>طراحی شده با مشاوره دامپزشکان</li>
                        </ul>

                        <div class="mt-4">
                            <a href="#" class="btn btn-primary">مشاهده همه محصولات</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="product-showcase">
                        <img src="{{ asset('site/images/photo-1533738363-b7f9aef128ce.jpeg') }}" alt="ظرف غذای حیوانات"
                            class="main-product">

                        <div class="floating-products">
                            <div class="floating-item">
                                <img src="{{ asset('site/images/photo-1533738363-b7f9aef128ce.jpeg') }}"
                                    alt="ظرف غذای سگ">
                            </div>
                            <div class="floating-item">
                                <img src="{{ asset('site/images/photo-1514888286974-6c03e2ca1dba.jpeg') }}"
                                    alt="ظرف غذای گربه">
                            </div>
                            <div class="floating-item">
                                <img src="{{ asset('site/images/photo-1552053831-71594a27632d.jpeg') }}"
                                    alt="ظرف غذای پرنده">
                            </div>
                            <div class="floating-item">
                                <img src="{{ asset('site/images/p1.jpeg') }}" alt="ظرف غذای همستر">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Products -->
    <section class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">انواع لانه و باکس نگهداری مراقبت از
                حیوانات</h2>
            <p class="lead">محصولاتی که مشتریان ما عاشقشان هستند</p>
        </div>
        <div class="products-container">
            @foreach ($data->cage_products as $product)
                <div class="product-card animate__animated animate__fadeInUp">
                    <a href="{{ route('products.show', $product->slug) }}" class="product-link"></a>
                    <div class="product-badge">پیشنهادی توکاشاپ</div>
                    {{-- <button class="product-wishlist">
                        <i class="bi bi-heart"></i>
                    </button> --}}
                    <div class="product-img-container">
                        <img src="{{ asset($product->firstMedia('main_image')->full_url) }}" class="product-img"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="product-content">
                        <span class="product-category">{{ $product->category->name }}</span>
                        <h3 class="product-title">{{ $product->name }}</h3>
                        {{-- <p class="product-description">غذای کامل و مقوی مخصوص گربه های بالغ با طعم مرغ</p> --}}

                        <div class="product-rating">
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                            </div>
                            <span class="rating-count">(42)</span>
                        </div>

                        <div class="product-price-container">
                            <div class="product-price">
                                <span class="current-price">{{ number_format($product->price) }} تومان</span>
                                <span class="old-price">{{ number_format($product->price * 1.12) }} تومان</span>
                            </div>
                            <div class="product-actions">
                                <a href="{{ route('products.show', $product->slug) }}" class="add-to-cart">
                                    <i class="bi bi-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg text-dark">مشاهده همه محصولات</a>
        </div>
    </section>


    <section class="articles-section">
        <div class="container">
            <div class="section-header">
                <span class="section-badge animate__animated animate__pulse animate__infinite">مطالب آموزشی</span>
                <h2 class="section-title animate__animated animate__fadeInDown">مقالات تخصصی توکا پت</h2>
                <p class="section-subtitle animate__animated animate__fadeInUp">
                    جدیدترین مطالب آموزشی و تخصصی در زمینه نگهداری، تغذیه و سلامت حیوانات خانگی
                </p>
            </div>

            <div class="articles-container">
                @foreach ($data->posts as $post)
                    <div class="article-card animate__animated animate__fadeInLeft">
                        <div class="article-image">
                            <img src="{{ $post->firstMedia('main_image')?->full_url }}" alt="{{ $post->title }}">
                            <span class="article-badge">{{ $post->category->name }}</span>
                        </div>
                        <div class="article-content">
                            <h3 class="article-title">{{ $post->title }}</h3>
                            <p class="article-excerpt">
                                {{ $post->summary }}
                            </p>
                            <div class="article-meta">
                                <span class="article-date"><i
                                        class="bi bi-calendar"></i>{{ jdate($post->created_at)->format('Y-m-d') }}</span>
                                <a href="{{ route('posts.show', $post->slug) }}" class="article-read-more">
                                    مطالعه مقاله <i class="bi bi-arrow-left"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="view-all-btn">
                <a href="{{ route('posts.index') }}" class="btn btn-primary">مشاهده همه مقالات</a>
            </div>
        </div>
    </section>

    <section class="habitat-section">
        <div class="container">
            <!-- آیکون‌های شناور -->
            <i class="bi bi-house-door floating-animal"></i>
            <i class="bi bi-grid-3x3-gap floating-animal"></i>
            <i class="bi bi-box-seam floating-animal"></i>
            <i class="bi bi-shield-check floating-animal"></i>

            <div class="habitat-header">
                <span class="section-badge animate__animated animate__pulse animate__infinite">خانه امن برای حیوانات</span>
                <h2 class="section-title animate__animated animate__fadeInDown">لانه، قفس و باکس حیوانات</h2>
                <p class="section-subtitle animate__animated animate__fadeInUp">
                    مکانی امن و راحت برای اعضای کوچک خانواده شما. همه محصولات با استاندارد و کیفیت و با مشاوره دامپزشکان
                    طراحی شده‌اند.
                </p>
            </div>

            <div class="habitat-content">
                <div class="habitat-info">
                    <h3 class="mb-4">خانه‌ای که شایسته حیوان شماست</h3>
                    <p class="mb-4" style="font-size: 1.1rem; line-height: 1.8; color: #555;">
                        در توکا پت شاپ، ما اهمیت یک محیط زندگی امن، راحت و stimulating برای حیوانات خانگی را درک
                        می‌کنیم.
                        هر محصول با دقت انتخاب شده تا نیازهای خاص هر حیوان را برآورده کند.
                    </p>

                    <ul class="habitat-features">
                        <li>ساخته شده از مواد باکیفیت و غیرسمی</li>
                        <li>طراحی ارگونومیک برای راحتی حیوان</li>
                        <li>قابلیت تمیزکاری آسان و نگهداری کم</li>
                        <li>امنیت بالا با قفل‌ها و درب‌های مطمئن</li>
                        <li>فضای کافی برای حرکت و فعالیت حیوان</li>
                        <li>مناسب برای استفاده در فضای داخلی و خارجی</li>
                    </ul>

                    <a class="btn btn-primary"
                        href="{{ route('products.categories', 'لانه-و-قفس-نگهداری-حیوانات') }}">مشاهده همه محصولات</a>
                </div>

                <div class="habitat-image animate__animated animate__fadeInRight">
                    <img src="{{ asset('site/images/image_tqvGenghp7vLzedr54DMgZgIemTRBn0TpE3S.webp') }}"
                        alt="لانه و قفس حیوانات">
                </div>
            </div>

            <div class="habitat-types">
                <div class="habitat-type animate__animated animate__fadeInUp">
                    <div class="type-icon">
                        <i class="bi bi-house-door"></i>
                    </div>
                    <h3 class="type-title">لانه‌های چوبی</h3>
                    <p class="type-description">
                        لانه‌های طبیعی و دنج که محیطی گرم و welcoming برای حیوانات کوچک فراهم می‌کنند.
                        مناسب برای همستر، خرگوش و حیوانات کوچک.
                    </p>
                </div>

                <div class="habitat-type animate__animated animate__fadeInUp" style="animation-delay: 0.2s;">
                    <div class="type-icon">
                        <i class="bi bi-grid-3x3-gap"></i>
                    </div>
                    <h3 class="type-title">قفس‌های فلزی</h3>
                    <p class="type-description">
                        قفس‌های با دوام و ایمن با طراحی مدرن که فضای کافی برای پرواز و حرکت پرندگان و
                        دیگر حیوانات را فراهم می‌کنند.
                    </p>
                </div>

                <div class="habitat-type animate__animated animate__fadeInUp" style="animation-delay: 0.4s;">
                    <div class="type-icon">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <h3 class="type-title">باکس های حمل و نقل</h3>
                    <p class="type-description">
                        باکس‌های ایمن و راحت برای سفر و حمل و نقل حیوانات. طراحی شده برای
                        ایمنی و آرامش حیوان در هنگام جابجایی.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Creative Section 2 - Testimonials -->
    <section class="creative-section bg-light">
        <div class="creative-bg" style="background-image: url('{{ asset('site/images/photo20788510751.jpg') }}');"></div>
        <div class="container">
            <div class="creative-content animate__animated animate__fadeIn">
                <div class="text-center mb-5">
                    <h2 class="section-title">نظرات مشتریان</h2>
                    <p class="lead">آنچه مشتریان ما درباره توکا پت می‌گویند</p>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('site/images/users/80.png') }}" class="testimonial-img me-3">
                                <div>
                                    <h6 class="mb-1">سارا محمدی</h6>
                                    <small class="text-muted">سرپرست گربه</small>
                                </div>
                            </div>
                            <p>محصولات توکا پت واقعا کیفیت بالایی دارند. گربه من عاشق غذای تونایی شده و هر بار با اشتها
                                می‌خوره. ممنون از خدمات عالیتون.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('site/images/users/12.png') }}" class="testimonial-img me-3">
                                <div>
                                    <h6 class="mb-1">امیر حسینی</h6>
                                    <small class="text-muted">سرپرست سگ</small>
                                </div>
                            </div>
                            <p>قلاده چرمی که خریدم واقعا لاکچریه و دوام بالایی داره. تحویل سریع و بسته‌بندی شیک هم از
                                مزایای
                                خرید از توکا پته.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-4">
                                <img src="{{ asset('site/images/users/90.png') }}" class="testimonial-img me-3">
                                <div>
                                    <h6 class="mb-1">نازنین رضایی</h6>
                                    <small class="text-muted">سرپرست پرنده</small>
                                </div>
                            </div>
                            <p>قفس پرنده‌ای که از توکا پت خریدم طراحی فوق‌العاده‌ای داره و واقعا برای پرنده‌ام فضای
                                مناسبی
                                ایجاد کرده. مشاوره خوبتون هم کمک بزرگی بود.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Creative Section 3 - Instagram -->
    <section class="container my-5 py-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">اینستاگرام ما</h2>
            <p class="lead">تصاویر حیوانات با نمک مشتریان ما را دنبال کنید</p>
        </div>
        <div class="row g-3">
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1514888286974-6c03e2ca1dba.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1533738363-b7f9aef128ce.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1526336024174-e58f5cdd8e13.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1594149929911-78975a43d4f5.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1552053831-71594a27632d.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
            <div class="col-md-2 col-4">
                <a href="#" class="d-block instagram-item">
                    <img src="{{ asset('site/images/photo-1583511655826-05700d52f4d9.jpeg') }}" class="img-fluid rounded"
                        alt="Instagram Post">
                </a>
            </div>
        </div>
        <div class="text-center mt-4">
            <a href="https://www.instagram.com/touca_petshop?igsh=MWQ1c24zbnowdDFuaQ%3D%3D&utm_source=qr" target="_blank"
                class="btn btn-outline-dark"><i class="bi bi-instagram me-2"></i>صفحه اینستاگرام ما</a>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="newsletter">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h3 class="mb-4">در خبرنامه توکا پت عضو شوید</h3>
                    <p class="mb-5">تخفیف‌های ویژه، محصولات جدید و نکات مراقبت از حیوانات را دریافت کنید</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="شماره همراه شما">
                        <button class="btn btn-dark" type="button">عضویت</button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Features Section -->
    <section class="container my-5 pt-5">
        <div class="text-center mb-5">
            <h2 class="section-title animate__animated animate__fadeInUp">چرا توکا پت؟</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4 animate__animated animate__fadeInUp" data-wow-delay="0.1s">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h4>کیفیت تضمینی</h4>
                    <p>تمام محصولات ما با بالاترین استانداردهای کیفیت انتخاب شده‌اند و سلامت حیوان شما را تضمین
                        می‌کنند.</p>
                </div>
            </div>
            <div class="col-md-4 animate__animated animate__fadeInUp" data-wow-delay="0.3s">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-truck"></i>
                    </div>
                    <h4>تحویل سریع</h4>
                    <p>سفارشات شما در کمترین زمان ممکن آماده و به درب منزل شما ارسال می‌شود.</p>
                </div>
            </div>
            <div class="col-md-4 animate__animated animate__fadeInUp" data-wow-delay="0.5s">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="bi bi-headset"></i>
                    </div>
                    <h4>پشتیبانی 24/7</h4>
                    <p>تیم پشتیبانی ما همیشه آماده پاسخگویی به سوالات و راهنمایی شماست.</p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                // ایجاد افکت کلیک
                card.addEventListener('click', function(e) {
                    // جلوگیری از اجرا وقتی روی دکمه‌ها کلیک می‌شود
                    if (e.target.closest('.product-wishlist') || e.target.closest('.add-to-cart')) {
                        return;
                    }

                    // ایجاد افکت دایره‌ای
                    const effect = document.createElement('div');
                    effect.className = 'click-effect';
                    effect.style.width = '100px';
                    effect.style.height = '100px';
                    effect.style.left = e.offsetX - 50 + 'px';
                    effect.style.top = e.offsetY - 50 + 'px';
                    this.appendChild(effect);

                    // حذف افکت بعد از انیمیشن
                    setTimeout(() => {
                        effect.remove();
                    }, 600);

                    // گرفتن لینک محصول
                    const productLink = this.querySelector('a.product-link');
                    if (productLink) {
                        // هدایت به صفحه محصول بعد از تاخیر کوتاه
                        setTimeout(() => {
                            window.location.href = productLink.href;
                        }, 300);
                    }
                });
            });
        });
    </script>

    <script>
        // افزودن انیمیشن هنگام اسکرول
        document.addEventListener('DOMContentLoaded', function() {
            const elements = document.querySelectorAll('.habitat-type');

            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.2}s`;
            });
        });
    </script>


    <script>
        // افزودن انیمیشن هنگام اسکرول
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.article-card');

            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.2}s`;
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Slider functionality
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.slider-dot');
            const prevBtn = document.querySelector('.slider-arrow.prev');
            const nextBtn = document.querySelector('.slider-arrow.next');
            const currentSlideEl = document.querySelector('.slide-counter .current');
            const totalSlidesEl = document.querySelector('.slide-counter .total');

            let currentSlide = 0;
            const totalSlides = slides.length;
            let slideInterval;

            // Set total slides
            totalSlidesEl.textContent = totalSlides < 10 ? `0${totalSlides}` : totalSlides;

            // Initialize slider
            function initSlider() {
                // Start autoplay
                startSlideInterval();

                // Update slide counter
                updateSlideCounter();

                // Add event listeners
                prevBtn.addEventListener('click', prevSlide);
                nextBtn.addEventListener('click', nextSlide);

                dots.forEach(dot => {
                    dot.addEventListener('click', function() {
                        const slideIndex = parseInt(this.getAttribute('data-slide'));
                        goToSlide(slideIndex);
                    });
                });

                // Pause autoplay when hovering over slider
                const slider = document.querySelector('.hero-slider');
                slider.addEventListener('mouseenter', pauseSlideInterval);
                slider.addEventListener('mouseleave', startSlideInterval);

                // Navbar scroll effect
                window.addEventListener('scroll', function() {
                    const navbar = document.querySelector('.navbar');
                    if (window.scrollY > 100) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                });
            }

            // Go to specific slide
            function goToSlide(index) {
                // Remove active class from current slide and dot
                slides[currentSlide].classList.remove('active');
                dots[currentSlide].classList.remove('active');

                // Update current slide
                currentSlide = index;

                // Add active class to new slide and dot
                slides[currentSlide].classList.add('active');
                dots[currentSlide].classList.add('active');

                // Update slide counter
                updateSlideCounter();

                // Restart autoplay
                restartSlideInterval();
            }

            // Next slide
            function nextSlide() {
                let nextIndex = currentSlide + 1;
                if (nextIndex >= totalSlides) {
                    nextIndex = 0;
                }
                goToSlide(nextIndex);
            }

            // Previous slide
            function prevSlide() {
                let prevIndex = currentSlide - 1;
                if (prevIndex < 0) {
                    prevIndex = totalSlides - 1;
                }
                goToSlide(prevIndex);
            }

            // Update slide counter
            function updateSlideCounter() {
                currentSlideEl.textContent = currentSlide + 1 < 10 ? `0${currentSlide + 1}` : currentSlide + 1;
            }

            // Start autoplay
            function startSlideInterval() {
                slideInterval = setInterval(nextSlide, 5000);
            }

            // Pause autoplay
            function pauseSlideInterval() {
                clearInterval(slideInterval);
            }

            // Restart autoplay
            function restartSlideInterval() {
                pauseSlideInterval();
                startSlideInterval();
            }

            // Initialize the slider
            initSlider();
        });
    </script>


    <script>
        // اسکریپت برای نمایش زیردسته‌ها با کلیک
        document.addEventListener('DOMContentLoaded', function() {
            const animalCategoryCards = document.querySelectorAll('.animal-category-card');

            animalCategoryCards.forEach(card => {
                card.addEventListener('click', function() {
                    // بستن همه دسته‌های دیگر
                    animalCategoryCards.forEach(otherCard => {
                        if (otherCard !== card) {
                            otherCard.classList.remove('active');
                        }
                    });

                    // باز یا بسته کردن دسته فعلی
                    this.classList.toggle('active');
                });
            });
        });
    </script>
@endsection
