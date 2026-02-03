@extends('layouts.frontend')

@section('title', 'Welcome')

@push('styles')
<style>
    /* Enhanced Hero Section */
    .hero-enhanced {
        min-height: 100vh;
        background: linear-gradient(135deg, rgba(2, 12, 27, 0.95) 0%, rgba(10, 25, 47, 0.9) 50%, rgba(17, 34, 64, 0.85) 100%),
                    url('https://images.unsplash.com/photo-1566073771259-6a8506099945?w=1920') center/cover fixed;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }

    .hero-enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 80%, rgba(230, 198, 138, 0.1) 0%, transparent 40%),
                    radial-gradient(circle at 80% 20%, rgba(100, 255, 218, 0.05) 0%, transparent 30%);
    }

    .hero-enhanced::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 200px;
        background: linear-gradient(to top, var(--bg-dark) 0%, transparent 100%);
        pointer-events: none;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        background: rgba(230, 198, 138, 0.1);
        border: 1px solid rgba(230, 198, 138, 0.2);
        border-radius: 50px;
        color: var(--accent);
        font-size: 0.85rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 24px;
        animation: fadeInUp 1s ease forwards;
    }

    .hero-badge i {
        font-size: 1rem;
    }

    .hero-title {
        font-size: 4.5rem;
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 24px;
        opacity: 0;
        animation: fadeInUp 1s ease forwards 0.2s;
    }

    .hero-title .highlight {
        position: relative;
        display: inline-block;
    }

    .hero-title .highlight::after {
        content: '';
        position: absolute;
        bottom: 5px;
        left: 0;
        width: 100%;
        height: 12px;
        background: linear-gradient(90deg, var(--accent) 0%, rgba(230, 198, 138, 0.3) 100%);
        z-index: -1;
        border-radius: 4px;
    }

    .hero-description {
        font-size: 1.2rem;
        color: var(--text-secondary);
        max-width: 500px;
        margin-bottom: 32px;
        opacity: 0;
        animation: fadeInUp 1s ease forwards 0.4s;
    }

    .hero-actions {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        opacity: 0;
        animation: fadeInUp 1s ease forwards 0.6s;
    }

    /* Modern Search Box */
    .booking-widget {
        background: linear-gradient(145deg, rgba(17, 34, 64, 0.9) 0%, rgba(10, 25, 47, 0.95) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(230, 198, 138, 0.15);
        border-radius: 24px;
        padding: 32px;
        margin-top: 48px;
        position: relative;
        overflow: hidden;
        opacity: 0;
        animation: fadeInUp 1s ease forwards 0.8s;
    }

    .booking-widget::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient-accent);
    }

    .booking-widget .widget-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .booking-field {
        position: relative;
    }

    .booking-field label {
        display: block;
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .booking-field input,
    .booking-field select {
        width: 100%;
        padding: 14px 16px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(230, 198, 138, 0.2);
        border-radius: 12px;
        color: var(--text-highlight);
        font-size: 0.95rem;
        transition: all 0.3s ease;
    }

    .booking-field input:focus,
    .booking-field select:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(230, 198, 138, 0.1);
        background: rgba(255, 255, 255, 0.08);
    }

    /* Floating Award Card */
    .floating-card {
        background: linear-gradient(145deg, rgba(17, 34, 64, 0.95) 0%, rgba(10, 25, 47, 0.98) 100%);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(230, 198, 138, 0.2);
        border-radius: 20px;
        padding: 28px;
        text-align: center;
        animation: float 6s ease-in-out infinite, fadeInUp 1s ease forwards 1s;
        opacity: 0;
    }

    .floating-card .icon-wrapper {
        width: 70px;
        height: 70px;
        background: linear-gradient(135deg, rgba(230, 198, 138, 0.2) 0%, rgba(230, 198, 138, 0.05) 100%);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 16px;
    }

    .floating-card .icon-wrapper i {
        font-size: 2rem;
        color: var(--accent);
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Room Type Cards */
    .room-type-card {
        background: linear-gradient(145deg, rgba(17, 34, 64, 0.8) 0%, rgba(10, 25, 47, 0.95) 100%);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .room-type-card:hover {
        transform: translateY(-12px);
        border-color: rgba(230, 198, 138, 0.3);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4),
                    0 0 50px rgba(230, 198, 138, 0.1);
    }

    .room-type-card .card-image {
        height: 200px;
        position: relative;
        overflow: hidden;
    }

    .room-type-card .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .room-type-card:hover .card-image img {
        transform: scale(1.1);
    }

    .room-type-card .card-image::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100px;
        background: linear-gradient(to top, rgba(10, 25, 47, 1) 0%, transparent 100%);
    }

    .room-type-card .card-body {
        padding: 24px;
    }

    .room-type-card .card-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--text-highlight);
        margin-bottom: 10px;
        transition: color 0.3s ease;
    }

    .room-type-card:hover .card-title {
        color: var(--accent);
    }

    .room-type-card .card-meta {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }

    .room-type-card .card-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .room-type-card .card-meta i {
        color: var(--accent);
    }

    .room-type-card .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 16px;
        border-top: 1px solid rgba(230, 198, 138, 0.1);
    }

    .room-type-card .price-tag {
        font-size: 1.3rem;
        font-weight: 700;
        background: var(--gradient-accent);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .room-type-card .price-tag small {
        font-size: 0.8rem;
        font-weight: 400;
        -webkit-text-fill-color: var(--text-secondary);
    }

    /* Feature Cards Modern */
    .feature-card-modern {
        background: linear-gradient(145deg, rgba(17, 34, 64, 0.6) 0%, rgba(10, 25, 47, 0.8) 100%);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 20px;
        padding: 32px 24px;
        text-align: center;
        transition: all 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .feature-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: var(--gradient-accent);
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .feature-card-modern:hover::before {
        transform: scaleX(1);
    }

    .feature-card-modern:hover {
        transform: translateY(-8px);
        border-color: rgba(230, 198, 138, 0.3);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    }

    .feature-card-modern .icon-box {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, rgba(230, 198, 138, 0.15) 0%, rgba(230, 198, 138, 0.05) 100%);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        transition: all 0.4s ease;
    }

    .feature-card-modern .icon-box i {
        font-size: 2rem;
        color: var(--accent);
        transition: all 0.4s ease;
    }

    .feature-card-modern:hover .icon-box {
        background: var(--gradient-accent);
        transform: rotateY(180deg);
    }

    .feature-card-modern:hover .icon-box i {
        color: var(--text-dark);
    }

    .feature-card-modern h5 {
        color: var(--text-highlight);
        margin-bottom: 8px;
        font-weight: 600;
    }

    .feature-card-modern p {
        color: var(--text-secondary);
        font-size: 0.9rem;
        margin: 0;
    }

    /* Stats Counter */
    .stat-card {
        background: linear-gradient(145deg, rgba(17, 34, 64, 0.8) 0%, rgba(10, 25, 47, 0.9) 100%);
        border: 1px solid rgba(230, 198, 138, 0.15);
        border-radius: 24px;
        padding: 40px 24px;
        text-align: center;
        position: relative;
        overflow: hidden;
        transition: all 0.4s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        border-color: rgba(230, 198, 138, 0.3);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: var(--gradient-accent);
        border-radius: 0 0 4px 4px;
    }

    .stat-card .stat-icon {
        font-size: 2rem;
        color: var(--accent);
        margin-bottom: 16px;
        opacity: 0.5;
    }

    .stat-card .stat-number {
        font-size: 3.5rem;
        font-weight: 700;
        background: var(--gradient-accent);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        line-height: 1;
        margin-bottom: 8px;
    }

    .stat-card .stat-label {
        color: var(--text-secondary);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Featured Room Card */
    .featured-room-card {
        background: linear-gradient(145deg, rgba(17, 34, 64, 0.8) 0%, rgba(10, 25, 47, 0.95) 100%);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .featured-room-card:hover {
        transform: translateY(-10px);
        border-color: rgba(230, 198, 138, 0.3);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4);
    }

    .featured-room-card .image-wrapper {
        height: 240px;
        position: relative;
        overflow: hidden;
    }

    .featured-room-card .image-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .featured-room-card:hover .image-wrapper img {
        transform: scale(1.08);
    }

    .featured-room-card .image-wrapper::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(to top, rgba(10, 25, 47, 1) 0%, transparent 100%);
    }

    .featured-room-card .room-badge {
        position: absolute;
        top: 16px;
        left: 16px;
        padding: 8px 16px;
        background: rgba(100, 255, 218, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50px;
        color: var(--teal);
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        z-index: 2;
    }

    .featured-room-card .card-content {
        padding: 24px;
    }

    .featured-room-card .room-type-name {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .featured-room-card .room-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: var(--text-highlight);
        margin-bottom: 12px;
    }

    .featured-room-card .room-info {
        display: flex;
        gap: 16px;
        margin-bottom: 16px;
    }

    .featured-room-card .room-info span {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.85rem;
        color: var(--text-secondary);
    }

    .featured-room-card .room-info i {
        color: var(--accent);
    }

    .featured-room-card .amenities-row {
        display: flex;
        gap: 8px;
        margin-bottom: 20px;
    }

    .featured-room-card .amenity-chip {
        padding: 8px 12px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 8px;
        font-size: 0.8rem;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .featured-room-card .amenity-chip i {
        color: var(--accent);
    }

    .featured-room-card .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid rgba(230, 198, 138, 0.1);
    }

    .featured-room-card .price-display {
        display: flex;
        flex-direction: column;
    }

    .featured-room-card .price-amount {
        font-size: 1.5rem;
        font-weight: 700;
        background: var(--gradient-accent);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .featured-room-card .price-period {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .featured-room-card .book-btn {
        padding: 14px 28px;
        background: var(--gradient-accent);
        border: none;
        border-radius: 50px;
        color: var(--text-dark);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        transition: all 0.4s ease;
    }

    .featured-room-card .book-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(230, 198, 138, 0.4);
        color: var(--text-dark);
    }

    /* Testimonial Cards */
    .testimonial-card {
        background: linear-gradient(145deg, rgba(17, 34, 64, 0.8) 0%, rgba(10, 25, 47, 0.9) 100%);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 24px;
        padding: 32px;
        position: relative;
        transition: all 0.4s ease;
    }

    .testimonial-card:hover {
        transform: translateY(-8px);
        border-color: rgba(230, 198, 138, 0.3);
    }

    .testimonial-card .quote-icon {
        position: absolute;
        top: 24px;
        right: 24px;
        font-size: 3rem;
        color: rgba(230, 198, 138, 0.1);
    }

    .testimonial-card .rating {
        display: flex;
        gap: 4px;
        margin-bottom: 16px;
    }

    .testimonial-card .rating i {
        color: var(--accent);
    }

    .testimonial-card .testimonial-text {
        color: var(--text-secondary);
        font-size: 1rem;
        line-height: 1.7;
        margin-bottom: 24px;
        font-style: italic;
    }

    .testimonial-card .author {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .testimonial-card .author-avatar {
        width: 56px;
        height: 56px;
        background: var(--gradient-accent);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--text-dark);
        font-size: 1.1rem;
    }

    .testimonial-card .author-info h6 {
        color: var(--text-highlight);
        margin-bottom: 4px;
        font-weight: 600;
    }

    .testimonial-card .author-info span {
        color: var(--text-secondary);
        font-size: 0.85rem;
    }

    /* CTA Section */
    .cta-modern {
        background: linear-gradient(135deg, rgba(17, 34, 64, 0.95) 0%, rgba(10, 25, 47, 0.98) 100%);
        border-top: 1px solid rgba(230, 198, 138, 0.1);
        border-bottom: 1px solid rgba(230, 198, 138, 0.1);
        position: relative;
        overflow: hidden;
    }

    .cta-modern::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 800px;
        height: 800px;
        background: radial-gradient(circle, rgba(230, 198, 138, 0.08) 0%, transparent 60%);
        pointer-events: none;
    }

    .cta-modern .cta-content {
        position: relative;
        z-index: 2;
    }

    .cta-modern h2 {
        font-size: 2.5rem;
        margin-bottom: 16px;
    }

    .cta-modern p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        max-width: 500px;
        margin: 0 auto 32px;
    }

    /* Section Headers */
    .section-header {
        text-align: center;
        margin-bottom: 48px;
    }

    .section-header .section-tag {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(230, 198, 138, 0.1);
        border: 1px solid rgba(230, 198, 138, 0.2);
        border-radius: 50px;
        color: var(--accent);
        font-size: 0.8rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 16px;
    }

    .section-header h2 {
        font-size: 2.5rem;
        margin-bottom: 16px;
    }

    .section-header p {
        color: var(--text-secondary);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .hero-title {
            font-size: 3rem;
        }
    }

    @media (max-width: 768px) {
        .hero-title {
            font-size: 2.5rem;
        }

        .hero-description {
            font-size: 1rem;
        }

        .stat-card .stat-number {
            font-size: 2.5rem;
        }

        .section-header h2 {
            font-size: 2rem;
        }

        .cta-modern h2 {
            font-size: 2rem;
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="hero-enhanced">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="bi bi-gem"></i>
                    Welcome to Urbanix Hotel
                </div>
                
                <h1 class="hero-title">
                    Experience <span class="highlight text-accent">Luxury</span><br>
                    Like Never Before
                </h1>
                
                <p class="hero-description">
                    Discover the perfect blend of modern comfort and timeless elegance. 
                    Your extraordinary journey begins in the heart of Jakarta.
                </p>
                
                <div class="hero-actions">
                    <a href="{{ route('rooms.index') }}" class="btn btn-gold">
                        <i class="bi bi-door-open me-2"></i>Explore Rooms
                    </a>
                    <a href="{{ route('about') }}" class="btn btn-outline-gold">
                        <i class="bi bi-play-circle me-2"></i>Take a Tour
                    </a>
                </div>

                <!-- Booking Widget -->
                <div class="booking-widget">
                    <div class="widget-title">
                        <i class="bi bi-calendar-check"></i>
                        Quick Booking
                    </div>
                    <form action="{{ route('search') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="booking-field">
                                    <label>Check In</label>
                                    <input type="date" name="check_in" min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="booking-field">
                                    <label>Check Out</label>
                                    <input type="date" name="check_out" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="booking-field">
                                    <label>Guests</label>
                                    <select name="guests">
                                        <option value="1">1 Guest</option>
                                        <option value="2" selected>2 Guests</option>
                                        <option value="3">3 Guests</option>
                                        <option value="4">4+ Guests</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 d-flex align-items-end">
                                <button type="submit" class="btn btn-gold w-100">
                                    <i class="bi bi-search me-2"></i>Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="col-lg-5 d-none d-lg-block">
                <div class="floating-card ms-auto" style="max-width: 280px;">
                    <div class="icon-wrapper">
                        <i class="bi bi-trophy"></i>
                    </div>
                    <h5 class="text-highlight mb-2">Award Winning</h5>
                    <p class="text-secondary small mb-3">Best Luxury Hotel 2025</p>
                    <div class="d-flex justify-content-center gap-1">
                        <i class="bi bi-star-fill text-accent"></i>
                        <i class="bi bi-star-fill text-accent"></i>
                        <i class="bi bi-star-fill text-accent"></i>
                        <i class="bi bi-star-fill text-accent"></i>
                        <i class="bi bi-star-fill text-accent"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="scroll-indicator">
        <div class="mouse">
            <div class="wheel"></div>
        </div>
    </div>
</section>

<!-- Room Types Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Accommodations</span>
            <h2>Our <span class="text-accent">Room Types</span></h2>
            <p>Choose from our carefully curated selection of luxurious rooms and suites</p>
        </div>
        
        <div class="row g-4">
            @php
                $roomImages = [
                    'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=500',
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=500',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=500',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=500',
                ];
            @endphp
            @foreach($roomTypes as $index => $type)
            <div class="col-lg-3 col-md-6">
                <div class="room-type-card h-100">
                    <div class="card-image">
                        <img src="{{ $roomImages[$index % count($roomImages)] }}" alt="{{ $type->name }}">
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">{{ $type->name }}</h4>
                        <div class="card-meta">
                            <span><i class="bi bi-people-fill"></i> {{ $type->capacity }}</span>
                            <span><i class="bi bi-aspect-ratio"></i> {{ $type->size_sqm ?? '25' }}m²</span>
                        </div>
                        <div class="card-footer">
                            <span class="price-tag">{{ $type->formatted_price }}<small>/night</small></span>
                            <a href="{{ route('rooms.index', ['room_type' => $type->id]) }}" class="btn btn-sm btn-outline-gold">View</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="text-center mt-5">
            <a href="{{ route('rooms.index') }}" class="btn btn-gold px-5">
                <i class="bi bi-grid-3x3-gap me-2"></i>View All Rooms
            </a>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section" style="background: var(--primary-light);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-5 mb-lg-0">
                <span class="section-tag">Why Choose Us</span>
                <h2 class="mt-3 mb-4">A Perfect Place for <span class="text-accent">Relaxation</span></h2>
                <p class="text-secondary mb-5" style="font-size: 1.1rem;">
                    At Urbanix Hotel, we believe in providing more than just accommodation. 
                    We create memorable experiences that last a lifetime.
                </p>
                
                <div class="row g-4">
                    <div class="col-6">
                        <div class="feature-card-modern">
                            <div class="icon-box">
                                <i class="bi bi-geo-alt"></i>
                            </div>
                            <h5>Prime Location</h5>
                            <p>Heart of Jakarta CBD</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-card-modern">
                            <div class="icon-box">
                                <i class="bi bi-cup-hot"></i>
                            </div>
                            <h5>Free Breakfast</h5>
                            <p>International buffet</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-card-modern">
                            <div class="icon-box">
                                <i class="bi bi-water"></i>
                            </div>
                            <h5>Infinity Pool</h5>
                            <p>Rooftop pool & bar</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="feature-card-modern">
                            <div class="icon-box">
                                <i class="bi bi-flower1"></i>
                            </div>
                            <h5>Spa & Wellness</h5>
                            <p>Full-service spa</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600" alt="Hotel Interior" class="img-fluid rounded-4" style="box-shadow: 0 30px 60px rgba(0,0,0,0.4);">
                    <div class="position-absolute" style="bottom: -30px; left: -30px; width: 150px; height: 150px; border: 3px solid var(--accent); border-radius: 20px; z-index: -1;"></div>
                    <div class="position-absolute" style="top: -30px; right: -30px; width: 100px; height: 100px; background: var(--gradient-accent); border-radius: 20px; z-index: -1; opacity: 0.3;"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="section">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6 col-6">
                <div class="stat-card">
                    <i class="bi bi-calendar-check stat-icon d-block"></i>
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <div class="stat-card">
                    <i class="bi bi-door-open stat-icon d-block"></i>
                    <div class="stat-number">200+</div>
                    <div class="stat-label">Luxury Rooms</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <div class="stat-card">
                    <i class="bi bi-people stat-icon d-block"></i>
                    <div class="stat-number">50K+</div>
                    <div class="stat-label">Happy Guests</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-6">
                <div class="stat-card">
                    <i class="bi bi-star stat-icon d-block"></i>
                    <div class="stat-number">4.9</div>
                    <div class="stat-label">Guest Rating</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Rooms -->
<section class="section" style="background: var(--primary);">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Handpicked Selection</span>
            <h2>Featured <span class="text-accent">Rooms</span></h2>
            <p>Our finest accommodations for an exceptional stay</p>
        </div>
        
        <div class="row g-4">
            @php
                $featuredImages = [
                    'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600',
                    'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=600',
                    'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600',
                ];
            @endphp
            @foreach($featuredRooms->take(3) as $index => $room)
            <div class="col-lg-4 col-md-6">
                <div class="featured-room-card h-100">
                    <div class="image-wrapper">
                        <img src="{{ $featuredImages[$index % count($featuredImages)] }}" alt="{{ $room->roomType->name }}">
                        <span class="room-badge">Available</span>
                    </div>
                    <div class="card-content">
                        <div class="room-type-name">{{ $room->roomType->name }}</div>
                        <h4 class="room-title">Room {{ $room->room_number }}</h4>
                        
                        <div class="room-info">
                            <span><i class="bi bi-people-fill"></i> {{ $room->roomType->capacity }} Guests</span>
                            <span><i class="bi bi-door-closed"></i> {{ $room->roomType->bed_type ?? 'King Bed' }}</span>
                        </div>
                        
                        <div class="amenities-row">
                            @foreach($room->amenities->take(3) as $amenity)
                            <span class="amenity-chip">
                                <i class="{{ $amenity->icon }}"></i>
                                {{ $amenity->name }}
                            </span>
                            @endforeach
                        </div>
                        
                        <div class="card-footer">
                            <div class="price-display">
                                <span class="price-amount">{{ $room->formatted_price }}</span>
                                <span class="price-period">per night</span>
                            </div>
                            <a href="{{ route('rooms.show', $room) }}" class="book-btn">View Room</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Testimonials Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-tag">Testimonials</span>
            <h2>What Our <span class="text-accent">Guests Say</span></h2>
            <p>Real experiences from our valued guests</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card h-100">
                    <i class="bi bi-quote quote-icon"></i>
                    <div class="rating">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="testimonial-text">
                        "An absolutely stunning hotel. The service was impeccable and the room exceeded all expectations. Will definitely return!"
                    </p>
                    <div class="author">
                        <div class="author-avatar">SA</div>
                        <div class="author-info">
                            <h6>Sarah Anderson</h6>
                            <span>Business Traveler</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card h-100">
                    <i class="bi bi-quote quote-icon"></i>
                    <div class="rating">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="testimonial-text">
                        "Perfect location, beautiful design, and the staff made us feel like royalty. The spa was absolutely divine!"
                    </p>
                    <div class="author">
                        <div class="author-avatar">MJ</div>
                        <div class="author-info">
                            <h6>Michael Johnson</h6>
                            <span>Honeymoon Guest</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="testimonial-card h-100">
                    <i class="bi bi-quote quote-icon"></i>
                    <div class="rating">
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <p class="testimonial-text">
                        "The attention to detail is remarkable. From check-in to check-out, everything was seamless. Highly recommend!"
                    </p>
                    <div class="author">
                        <div class="author-avatar">EW</div>
                        <div class="author-info">
                            <h6>Emily Watson</h6>
                            <span>Luxury Traveler</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-modern section text-center">
    <div class="container">
        <div class="cta-content">
            <h2>Ready for an <span class="text-accent">Unforgettable Stay?</span></h2>
            <p>Book your room today and experience the best of luxury hospitality at Urbanix Hotel.</p>
            <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-lg px-5">
                <i class="bi bi-calendar-check me-2"></i>Book Now
            </a>
        </div>
    </div>
</section>
@endsection
