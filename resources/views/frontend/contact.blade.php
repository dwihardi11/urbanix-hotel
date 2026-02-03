@extends('layouts.frontend')

@section('title', 'Contact Us')

@section('content')
<div style="padding-top: 100px;">
    <!-- Header -->
    <section class="py-5" style="background: var(--primary-light);">
        <div class="container text-center">
            <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Get in Touch</p>
            <h1>Contact <span class="text-accent">Us</span></h1>
            <p class="text-secondary mx-auto" style="max-width: 500px;">We'd love to hear from you. Reach out for reservations, inquiries, or feedback.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row g-4">
                <!-- Contact Info Cards -->
                <div class="col-lg-4">
                    <div class="glass-card h-100">
                        <h5 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-headset me-2"></i> Get In Touch
                        </h5>
                        
                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="width: 50px; height: 50px; margin: 0; font-size: 1.1rem;">
                                    <i class="bi bi-geo-alt"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Address</h6>
                                    <p class="text-secondary mb-0 small">{{ $hotel->address ?? 'Jl. Sudirman No. 123' }}<br>{{ $hotel->city ?? 'Jakarta' }}, Indonesia</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="width: 50px; height: 50px; margin: 0; font-size: 1.1rem;">
                                    <i class="bi bi-telephone"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Phone</h6>
                                    <p class="text-secondary mb-0 small">{{ $hotel->phone ?? '+62 21 1234 5678' }}</p>
                                    <p class="text-secondary mb-0 small">+62 812 3456 7890 (WhatsApp)</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="width: 50px; height: 50px; margin: 0; font-size: 1.1rem;">
                                    <i class="bi bi-envelope"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Email</h6>
                                    <p class="text-secondary mb-0 small">{{ $hotel->email ?? 'info@urbanix-hotel.com' }}</p>
                                    <p class="text-secondary mb-0 small">reservations@urbanix-hotel.com</p>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="d-flex align-items-start">
                                <div class="feature-icon me-3" style="width: 50px; height: 50px; margin: 0; font-size: 1.1rem;">
                                    <i class="bi bi-clock"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1">Front Desk Hours</h6>
                                    <p class="text-secondary mb-0 small">Open 24 hours, 7 days a week</p>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: rgba(230, 198, 138, 0.2);">

                        <h6 class="text-accent mb-3">Follow Us</h6>
                        <div class="social-links">
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-twitter-x"></i></a>
                            <a href="#"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-8">
                    <div class="glass-card">
                        <h5 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-chat-dots me-2"></i> Send Us a Message
                        </h5>
                        
                        <form action="#" method="POST">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Your Name</label>
                                    <input type="text" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" placeholder="John Doe" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Email Address</label>
                                    <input type="email" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" placeholder="john@example.com" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Phone Number</label>
                                    <input type="tel" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" placeholder="+62 812 3456 7890">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Subject</label>
                                    <select class="form-select" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);">
                                        <option value="">Select a subject</option>
                                        <option value="reservation">Reservation Inquiry</option>
                                        <option value="general">General Question</option>
                                        <option value="feedback">Feedback</option>
                                        <option value="partnership">Business Partnership</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Message</label>
                                    <textarea class="form-control" rows="5" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" placeholder="Tell us how we can help you..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-gold px-5">
                                        <i class="bi bi-send me-2"></i>Send Message
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Map Section -->
            <div class="mt-5">
                <div class="glass-card p-0 overflow-hidden">
                    <div class="row g-0">
                        <div class="col-lg-8">
                            <div style="background: var(--primary-light); height: 350px; display: flex; align-items: center; justify-content: center;">
                                <div class="text-center">
                                    <i class="bi bi-map text-accent" style="font-size: 4rem;"></i>
                                    <p class="text-secondary mt-3 mb-0">Interactive map would be displayed here</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="p-4 h-100 d-flex flex-column justify-content-center">
                                <h5 class="text-accent mb-3">Find Us</h5>
                                <p class="text-secondary small mb-3">Located in the prestigious Sudirman Central Business District (SCBD), just 10 minutes from major shopping centers and 30 minutes from the airport.</p>
                                <div class="mb-3">
                                    <span class="amenity-badge"><i class="bi bi-car-front me-1"></i> Valet Parking</span>
                                    <span class="amenity-badge"><i class="bi bi-train-front me-1"></i> Near MRT</span>
                                </div>
                                <a href="https://maps.google.com" target="_blank" class="btn btn-outline-gold btn-sm">
                                    <i class="bi bi-map me-2"></i>Get Directions
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .form-control::placeholder,
    .form-select option {
        color: var(--text-secondary) !important;
    }
    
    .form-select option {
        background: var(--primary);
    }
</style>
@endpush
