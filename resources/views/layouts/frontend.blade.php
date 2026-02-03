<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Urbanix Hotel') - Luxury Hotel Experience</title>
    <meta name="description" content="@yield('description', 'Experience luxury and comfort at Urbanix Hotel. Premium accommodations with world-class amenities in the heart of Jakarta.')">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            /* Premium Color Palette */
            --primary: #0a192f;
            --primary-light: #112240;
            --secondary: #1d3557;
            --accent: #e6c68a;
            --accent-light: #f0d9a8;
            --accent-rose: #d4a574;
            --accent-glow: rgba(230, 198, 138, 0.3);
            --teal: #64ffda;
            --teal-dark: #4fd1c5;
            
            /* Text Colors */
            --text-primary: #ccd6f6;
            --text-secondary: #8892b0;
            --text-highlight: #e6f1ff;
            --text-dark: #0a192f;
            
            /* Background Colors */
            --bg-dark: #020c1b;
            --bg-card: rgba(17, 34, 64, 0.6);
            --bg-glass: rgba(255, 255, 255, 0.03);
            
            /* Gradients */
            --gradient-hero: linear-gradient(135deg, #0a192f 0%, #112240 50%, #1d3557 100%);
            --gradient-accent: linear-gradient(135deg, #e6c68a 0%, #d4a574 100%);
            --gradient-card: linear-gradient(145deg, rgba(17, 34, 64, 0.8) 0%, rgba(10, 25, 47, 0.9) 100%);
            --gradient-glow: radial-gradient(ellipse at center, rgba(230, 198, 138, 0.15) 0%, transparent 70%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background: var(--bg-dark);
            color: var(--text-primary);
            line-height: 1.7;
            overflow-x: hidden;
        }

        h1, h2, h3, h4, h5, h6 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            color: var(--text-highlight);
            letter-spacing: 0.5px;
        }

        /* Utility Classes */
        .text-accent { color: var(--accent) !important; }
        .text-teal { color: var(--teal) !important; }
        .bg-accent { background: var(--gradient-accent) !important; }
        .border-accent { border-color: var(--accent) !important; }

        /* Animated Background Orbs */
        .bg-orbs {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
            animation: float 20s ease-in-out infinite;
        }

        .orb-1 {
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, rgba(230, 198, 138, 0.2) 0%, rgba(212, 165, 116, 0.1) 100%);
            top: -200px;
            right: -200px;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(135deg, rgba(100, 255, 218, 0.1) 0%, rgba(79, 209, 197, 0.05) 100%);
            bottom: -100px;
            left: -100px;
            animation-delay: -5s;
        }

        .orb-3 {
            width: 300px;
            height: 300px;
            background: linear-gradient(135deg, rgba(29, 53, 87, 0.3) 0%, rgba(17, 34, 64, 0.2) 100%);
            top: 50%;
            left: 50%;
            animation-delay: -10s;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) rotate(0deg); }
            25% { transform: translate(30px, -30px) rotate(5deg); }
            50% { transform: translate(-20px, 20px) rotate(-5deg); }
            75% { transform: translate(20px, 30px) rotate(3deg); }
        }

        /* Navbar */
        .navbar-custom {
            background: rgba(2, 12, 27, 0.8);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            padding: 1rem 0;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-bottom: 1px solid rgba(230, 198, 138, 0.1);
        }

        .navbar-custom.scrolled {
            padding: 0.6rem 0;
            background: rgba(2, 12, 27, 0.95);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-highlight) !important;
            letter-spacing: 2px;
        }

        .navbar-brand span {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.5rem 1.25rem !important;
            transition: all 0.3s ease;
            position: relative;
            letter-spacing: 0.5px;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--gradient-accent);
            transition: all 0.3s ease;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .nav-link:hover::before,
        .nav-link.active::before {
            width: 30px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--text-highlight) !important;
        }

        /* Buttons */
        .btn-gold {
            background: var(--gradient-accent);
            border: none;
            color: var(--text-dark);
            font-weight: 600;
            padding: 0.85rem 2.5rem;
            border-radius: 50px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.85rem;
            position: relative;
            overflow: hidden;
        }

        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }

        .btn-gold:hover::before {
            left: 100%;
        }

        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(230, 198, 138, 0.4);
            color: var(--text-dark);
        }

        .btn-outline-gold {
            border: 2px solid var(--accent);
            color: var(--accent);
            background: transparent;
            font-weight: 600;
            padding: 0.85rem 2.5rem;
            border-radius: 50px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            letter-spacing: 1px;
            font-size: 0.85rem;
        }

        .btn-outline-gold:hover {
            background: var(--accent);
            color: var(--text-dark);
            box-shadow: 0 10px 30px rgba(230, 198, 138, 0.3);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: var(--gradient-hero);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="0.5" fill="rgba(255,255,255,0.03)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.5;
            pointer-events: none;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 200px;
            background: linear-gradient(to top, var(--bg-dark) 0%, transparent 100%);
            pointer-events: none;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-content h1 {
            font-size: 4.5rem;
            line-height: 1.1;
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: slideUp 1s ease forwards 0.2s;
        }

        .hero-content p {
            font-size: 1.15rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            opacity: 0;
            animation: slideUp 1s ease forwards 0.4s;
        }

        .hero-buttons {
            opacity: 0;
            animation: slideUp 1s ease forwards 0.6s;
        }

        .hero-tagline {
            font-size: 0.9rem;
            color: var(--accent);
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 1rem;
            opacity: 0;
            animation: slideUp 1s ease forwards 0s;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Search Box */
        .search-box {
            background: var(--gradient-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(230, 198, 138, 0.15);
            border-radius: 24px;
            padding: 2.5rem;
            margin-top: 3rem;
            position: relative;
            overflow: hidden;
            opacity: 0;
            animation: slideUp 1s ease forwards 0.8s;
        }

        .search-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0.5;
        }

        .search-box .form-control,
        .search-box .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(230, 198, 138, 0.2);
            color: var(--text-highlight);
            padding: 1rem 1.25rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .search-box .form-control:focus,
        .search-box .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(230, 198, 138, 0.15);
            color: var(--text-highlight);
        }

        .search-box .form-control::placeholder {
            color: var(--text-secondary);
        }

        .search-box label {
            color: var(--accent);
            font-size: 0.8rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Room Cards */
        .room-card {
            background: var(--gradient-card);
            border: 1px solid rgba(230, 198, 138, 0.1);
            border-radius: 24px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .room-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--gradient-glow);
            opacity: 0;
            transition: opacity 0.5s ease;
            pointer-events: none;
        }

        .room-card:hover {
            transform: translateY(-12px) scale(1.02);
            border-color: rgba(230, 198, 138, 0.3);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4),
                        0 0 60px rgba(230, 198, 138, 0.1);
        }

        .room-card:hover::before {
            opacity: 1;
        }

        .room-card-img {
            height: 260px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.6s ease;
        }

        .room-card:hover .room-card-img {
            transform: scale(1.08);
        }

        .room-card-img-wrapper {
            overflow: hidden;
            position: relative;
        }

        .room-card-img-wrapper::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 100px;
            background: linear-gradient(to top, rgba(10, 25, 47, 1) 0%, transparent 100%);
            pointer-events: none;
        }

        .room-card-body {
            padding: 1.75rem;
            position: relative;
            z-index: 2;
        }

        .room-card-title {
            font-size: 1.6rem;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .room-card:hover .room-card-title {
            color: var(--accent);
        }

        .room-card-price {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 1.4rem;
            font-weight: 700;
            white-space: nowrap;
            display: inline-flex;
            align-items: baseline;
            gap: 0;
        }

        .room-card-price span {
            font-size: 0.85rem;
            color: var(--text-secondary);
            font-weight: 400;
            -webkit-text-fill-color: var(--text-secondary);
            white-space: nowrap;
        }

        /* Section Styling */
        .section {
            padding: 7rem 0;
            position: relative;
            z-index: 1;
        }

        .section-title {
            font-size: 3rem;
            margin-bottom: 1rem;
            text-align: center;
        }

        .section-subtitle {
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 4rem;
            font-size: 1.1rem;
        }

        .section-divider {
            width: 60px;
            height: 3px;
            background: var(--gradient-accent);
            margin: 1rem auto 0;
            border-radius: 3px;
        }

        /* Amenity Icons */
        .amenity-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(230, 198, 138, 0.1);
            color: var(--accent);
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.8rem;
            margin: 0.25rem;
            border: 1px solid rgba(230, 198, 138, 0.2);
            transition: all 0.3s ease;
        }

        .amenity-badge:hover {
            background: rgba(230, 198, 138, 0.2);
            transform: translateY(-2px);
        }

        /* Feature Section */
        .feature-box {
            background: var(--gradient-card);
            border: 1px solid rgba(230, 198, 138, 0.1);
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            transition: all 0.4s ease;
        }

        .feature-box:hover {
            border-color: var(--accent);
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, rgba(230, 198, 138, 0.2) 0%, rgba(230, 198, 138, 0.05) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 1.75rem;
            color: var(--accent);
            transition: all 0.4s ease;
        }

        .feature-box:hover .feature-icon {
            background: var(--gradient-accent);
            color: var(--text-dark);
            transform: rotateY(180deg);
        }

        /* Footer */
        .footer {
            background: var(--primary);
            padding: 5rem 0 2rem;
            border-top: 1px solid rgba(230, 198, 138, 0.1);
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--accent), transparent);
            opacity: 0.3;
        }

        .footer-brand {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-highlight);
            margin-bottom: 1rem;
        }

        .footer-brand span {
            background: var(--gradient-accent);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .footer-links a {
            color: var(--text-secondary);
            text-decoration: none;
            display: block;
            padding: 0.4rem 0;
            transition: all 0.3s ease;
            position: relative;
        }

        .footer-links a:hover {
            color: var(--accent);
            padding-left: 10px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(230, 198, 138, 0.1);
            border: 1px solid rgba(230, 198, 138, 0.2);
            border-radius: 50%;
            color: var(--accent);
            margin-right: 0.75rem;
            transition: all 0.4s ease;
        }

        .social-links a:hover {
            background: var(--gradient-accent);
            color: var(--text-dark);
            border-color: var(--accent);
            transform: translateY(-5px) rotate(360deg);
        }

        /* Form Styling */
        .form-floating > .form-control,
        .form-floating > .form-select {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(230, 198, 138, 0.2);
            color: var(--text-highlight);
        }

        .form-floating > label {
            color: var(--text-secondary);
        }

        .form-floating > .form-control:focus,
        .form-floating > .form-select:focus {
            background: rgba(255, 255, 255, 0.06);
            border-color: var(--accent);
            color: var(--text-highlight);
            box-shadow: 0 0 0 4px rgba(230, 198, 138, 0.1);
        }

        /* Glassmorphism Cards */
        .glass-card {
            background: var(--gradient-card);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(230, 198, 138, 0.1);
            border-radius: 24px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(230, 198, 138, 0.3), transparent);
        }

        /* CTA Section */
        .cta-section {
            background: var(--gradient-card);
            border-top: 1px solid rgba(230, 198, 138, 0.1);
            border-bottom: 1px solid rgba(230, 198, 138, 0.1);
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(230, 198, 138, 0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .shimmer {
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            background-size: 200% 100%;
            animation: shimmer 2s infinite;
        }

        /* Scroll indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 10;
        }

        .scroll-indicator .mouse {
            width: 26px;
            height: 40px;
            border: 2px solid rgba(230, 198, 138, 0.5);
            border-radius: 20px;
            position: relative;
        }

        .scroll-indicator .wheel {
            width: 4px;
            height: 8px;
            background: var(--accent);
            border-radius: 2px;
            position: absolute;
            top: 8px;
            left: 50%;
            transform: translateX(-50%);
            animation: scrollWheel 1.5s ease-in-out infinite;
        }

        @keyframes scrollWheel {
            0%, 100% { opacity: 1; top: 8px; }
            50% { opacity: 0.5; top: 18px; }
        }

        /* Responsive */
        @media (max-width: 992px) {
            .hero-content h1 {
                font-size: 3rem;
            }

            .section-title {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2.5rem;
            }

            .section {
                padding: 5rem 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .navbar-brand {
                font-size: 1.5rem;
            }

            .search-box {
                padding: 1.5rem;
            }

            .btn-gold, .btn-outline-gold {
                padding: 0.75rem 1.5rem;
                font-size: 0.8rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-dark);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-light);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--accent);
        }

        /* Pagination Styles */
        .pagination {
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination .page-item .page-link {
            background: var(--bg-glass);
            border: 1px solid rgba(230, 198, 138, 0.2);
            color: var(--text-secondary);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 48px;
            text-align: center;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .pagination .page-item .page-link:hover {
            background: rgba(230, 198, 138, 0.15);
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(230, 198, 138, 0.2);
        }

        .pagination .page-item.active .page-link {
            background: var(--gradient-accent);
            border-color: var(--accent);
            color: var(--text-dark);
            font-weight: 600;
            box-shadow: 0 8px 25px rgba(230, 198, 138, 0.35);
        }

        .pagination .page-item.disabled .page-link {
            background: rgba(255,255,255,0.02);
            border-color: rgba(230, 198, 138, 0.08);
            color: var(--text-secondary);
            opacity: 0.4;
            cursor: not-allowed;
            transform: none;
        }

        .pagination .page-item:first-child .page-link,
        .pagination .page-item:last-child .page-link {
            border-radius: 12px;
        }

        /* Pagination info text */
        .pagination-info {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .pagination-info span {
            color: var(--accent);
            font-weight: 600;
        }

        /* Laravel Tailwind pagination override */
        nav[aria-label="Pagination Navigation"] {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        nav[aria-label="Pagination Navigation"] > div {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        nav[aria-label="Pagination Navigation"] p {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin: 0;
        }

        nav[aria-label="Pagination Navigation"] p span {
            color: var(--accent);
            font-weight: 600;
        }

        nav[aria-label="Pagination Navigation"] span[aria-current="page"] span {
            background: var(--gradient-accent) !important;
            border-color: var(--accent) !important;
            color: var(--text-dark) !important;
            box-shadow: 0 8px 25px rgba(230, 198, 138, 0.35);
            border-radius: 12px;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
        }

        nav[aria-label="Pagination Navigation"] a {
            background: var(--bg-glass) !important;
            border: 1px solid rgba(230, 198, 138, 0.2) !important;
            color: var(--text-secondary) !important;
            border-radius: 12px !important;
            padding: 0.75rem 1.25rem !important;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            font-weight: 500 !important;
        }

        nav[aria-label="Pagination Navigation"] a:hover {
            background: rgba(230, 198, 138, 0.15) !important;
            border-color: var(--accent) !important;
            color: var(--accent) !important;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(230, 198, 138, 0.2);
        }

        nav[aria-label="Pagination Navigation"] span.cursor-default {
            background: rgba(255,255,255,0.02) !important;
            border: 1px solid rgba(230, 198, 138, 0.08) !important;
            color: var(--text-secondary) !important;
            opacity: 0.4;
            border-radius: 12px !important;
            padding: 0.75rem 1.25rem !important;
        }

        /* Hide SVG arrows and style them properly */
        nav[aria-label="Pagination Navigation"] svg {
            display: none !important;
        }

        /* Style the navigation elements to use text instead */
        nav[aria-label="Pagination Navigation"] > div > div {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        /* Hidden elements for mobile */
        nav[aria-label="Pagination Navigation"] > div > div:first-child {
            display: none;
        }

        /* Custom pagination wrapper */
        .custom-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .custom-pagination .page-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 44px;
            height: 44px;
            padding: 0 1rem;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(230, 198, 138, 0.2);
            border-radius: 12px;
            color: var(--text-secondary);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.9rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .custom-pagination .page-btn:hover {
            background: rgba(230, 198, 138, 0.15);
            border-color: var(--accent);
            color: var(--accent);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(230, 198, 138, 0.2);
        }

        .custom-pagination .page-btn.active {
            background: linear-gradient(135deg, #e6c68a 0%, #d4a574 100%);
            border-color: var(--accent);
            color: var(--text-dark);
            font-weight: 600;
            box-shadow: 0 8px 25px rgba(230, 198, 138, 0.35);
        }

        .custom-pagination .page-btn.disabled {
            opacity: 0.3;
            cursor: not-allowed;
            pointer-events: none;
        }

        .custom-pagination .page-btn i {
            font-size: 1rem;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        
        /* Extra Large Desktop (1400px+) */
        @media (min-width: 1400px) {
            .container {
                max-width: 1320px;
            }
            
            h1 { font-size: 3.5rem; }
            h2 { font-size: 2.75rem; }
        }

        /* Large Desktop (1200px - 1399px) */
        @media (min-width: 1200px) and (max-width: 1399px) {
            .container {
                max-width: 1140px;
            }
            
            h1 { font-size: 3rem; }
            h2 { font-size: 2.5rem; }
        }

        /* Desktop (992px - 1199px) */
        @media (min-width: 992px) and (max-width: 1199px) {
            .container {
                max-width: 960px;
            }
            
            h1 { font-size: 2.75rem; }
            h2 { font-size: 2.25rem; }
            
            .glass-card {
                padding: 1.5rem;
            }
        }

        /* Tablet Landscape (768px - 991px) */
        @media (min-width: 768px) and (max-width: 991px) {
            .container {
                max-width: 720px;
            }
            
            h1 { font-size: 2.5rem; }
            h2 { font-size: 2rem; }
            h3 { font-size: 1.5rem; }
            
            .section {
                padding: 3rem 0;
            }
            
            .glass-card {
                padding: 1.25rem;
            }
            
            .room-card {
                max-width: 400px;
                margin: 0 auto;
            }
            
            .feature-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }
            
            .btn-gold, .btn-outline-gold {
                padding: 0.6rem 1.25rem;
                font-size: 0.85rem;
            }
        }

        /* Tablet Portrait (576px - 767px) */
        @media (min-width: 576px) and (max-width: 767px) {
            .container {
                max-width: 540px;
            }
            
            h1 { font-size: 2rem; }
            h2 { font-size: 1.75rem; }
            h3 { font-size: 1.35rem; }
            
            .section {
                padding: 2.5rem 0;
            }
            
            .glass-card {
                padding: 1rem;
            }
            
            .navbar-brand {
                font-size: 1.25rem;
            }
            
            .feature-icon {
                width: 45px;
                height: 45px;
                font-size: 1.1rem;
            }
            
            .footer {
                padding: 2rem 0;
            }
            
            .footer-brand {
                font-size: 1.5rem;
            }
        }

        /* Mobile Large (480px - 575px) */
        @media (min-width: 480px) and (max-width: 575px) {
            .container {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            
            h1 { font-size: 1.75rem; }
            h2 { font-size: 1.5rem; }
            h3 { font-size: 1.25rem; }
            
            .section {
                padding: 2rem 0;
            }
            
            .glass-card {
                padding: 1rem;
                border-radius: 16px;
            }
            
            .room-card {
                max-width: 100%;
            }
            
            .btn-gold, .btn-outline-gold {
                padding: 0.5rem 1rem;
                font-size: 0.8rem;
            }
            
            .custom-pagination .page-btn {
                min-width: 38px;
                height: 38px;
                padding: 0 0.75rem;
                font-size: 0.8rem;
            }
        }

        /* Mobile Small (< 480px) */
        @media (max-width: 479px) {
            .container {
                padding-left: 0.75rem;
                padding-right: 0.75rem;
            }
            
            h1 { font-size: 1.5rem; }
            h2 { font-size: 1.35rem; }
            h3 { font-size: 1.15rem; }
            h4 { font-size: 1rem; }
            
            body {
                font-size: 0.9rem;
                line-height: 1.6;
            }
            
            .section {
                padding: 1.5rem 0;
            }
            
            .glass-card {
                padding: 0.875rem;
                border-radius: 12px;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
                letter-spacing: 1px;
            }
            
            .navbar-custom {
                padding: 0.5rem 0;
            }
            
            .nav-link {
                padding: 0.5rem 0;
                font-size: 0.9rem;
            }
            
            .feature-icon {
                width: 40px;
                height: 40px;
                font-size: 1rem;
            }
            
            .btn-gold, .btn-outline-gold {
                padding: 0.5rem 0.875rem;
                font-size: 0.75rem;
            }
            
            .custom-pagination {
                gap: 0.25rem;
            }
            
            .custom-pagination .page-btn {
                min-width: 32px;
                height: 32px;
                padding: 0 0.5rem;
                font-size: 0.75rem;
                border-radius: 8px;
            }
            
            .pagination-info {
                font-size: 0.8rem;
            }
            
            .footer {
                padding: 1.5rem 0;
            }
            
            .footer-brand {
                font-size: 1.25rem;
            }
            
            .footer-links a {
                font-size: 0.85rem;
            }
            
            .social-links a {
                width: 35px;
                height: 35px;
            }
        }

        /* Mobile navbar adjustments */
        @media (max-width: 991px) {
            .navbar-collapse {
                background: var(--primary-light);
                padding: 1rem;
                border-radius: 12px;
                margin-top: 0.5rem;
                border: 1px solid rgba(230, 198, 138, 0.1);
            }
            
            .navbar-nav {
                text-align: center;
            }
            
            .navbar-nav .nav-link {
                padding: 0.75rem 0;
                border-bottom: 1px solid rgba(230, 198, 138, 0.1);
            }
            
            .navbar-nav .nav-item:last-child .nav-link {
                border-bottom: none;
            }
            
            .ms-lg-4 {
                justify-content: center;
            }
        }

        /* Improve touch targets on mobile */
        @media (max-width: 767px) {
            .btn, button, a.btn {
                min-height: 44px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }
            
            input, select, textarea {
                min-height: 44px;
            }
            
            .form-control {
                font-size: 16px; /* Prevent zoom on iOS */
            }
        }

        /* Fix dropdown on mobile */
        @media (max-width: 991px) {
            .dropdown-menu {
                position: static !important;
                transform: none !important;
                width: 100%;
                margin-top: 0.5rem;
                text-align: center;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- Background Orbs -->
    <div class="bg-orbs">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                URBAN<span>IX</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class="bi bi-list text-white fs-4"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}" href="{{ route('rooms.index') }}">Rooms</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('booking.search') ? 'active' : '' }}" href="{{ route('booking.search') }}">My Booking</a>
                    </li>
                </ul>
                <div class="ms-lg-4 mt-3 mt-lg-0 d-flex align-items-center gap-2">
                    @auth
                        <div class="dropdown">
                            <button class="btn btn-outline-gold btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="background: var(--primary-light); border: 1px solid rgba(230, 198, 138, 0.2);">
                                <li><a class="dropdown-item" href="{{ route('booking.search') }}" style="color: var(--text-secondary);"><i class="bi bi-calendar-check me-2"></i>My Bookings</a></li>
                                @if(in_array(auth()->user()->role, ['admin', 'receptionist']))
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}" style="color: var(--text-secondary);"><i class="bi bi-speedometer2 me-2"></i>Admin Panel</a></li>
                                @endif
                                <li><hr class="dropdown-divider" style="border-color: rgba(230, 198, 138, 0.2);"></li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item" style="color: #ff6b6b;"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-gold btn-sm">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-gold btn-sm">Register</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand">URBAN<span>IX</span></div>
                    <p class="text-secondary mb-4">Experience luxury and comfort in the heart of Jakarta. Premium accommodations with world-class amenities for the discerning traveler.</p>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h6 class="text-accent mb-4">Quick Links</h6>
                    <div class="footer-links">
                        <a href="{{ route('home') }}">Home</a>
                        <a href="{{ route('rooms.index') }}">Our Rooms</a>
                        <a href="{{ route('about') }}">About Us</a>
                        <a href="{{ route('contact') }}">Contact</a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h6 class="text-accent mb-4">Services</h6>
                    <div class="footer-links">
                        <a href="#">Fine Dining</a>
                        <a href="#">Spa & Wellness</a>
                        <a href="#">Meeting Rooms</a>
                        <a href="#">Airport Transfer</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 mb-4">
                    <h6 class="text-accent mb-4">Contact Us</h6>
                    <p class="text-secondary mb-2"><i class="bi bi-geo-alt me-2 text-accent"></i>Jl. Sudirman No. 123, Jakarta</p>
                    <p class="text-secondary mb-2"><i class="bi bi-telephone me-2 text-accent"></i>+62 21 1234 5678</p>
                    <p class="text-secondary mb-2"><i class="bi bi-envelope me-2 text-accent"></i>info@urbanix-hotel.com</p>
                </div>
            </div>
            <hr class="my-4" style="border-color: rgba(230, 198, 138, 0.1);">
            <div class="text-center text-secondary">
                <small>&copy; {{ date('Y') }} Urbanix Hotel. Crafted with <i class="bi bi-heart-fill text-accent"></i> Dwi Hardiansyah</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate-fadeInUp');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.room-card, .feature-box, .glass-card').forEach(el => {
            observer.observe(el);
        });
    </script>
    @stack('scripts')
</body>
</html>
