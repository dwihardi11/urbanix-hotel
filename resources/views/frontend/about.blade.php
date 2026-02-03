@extends('layouts.frontend')

@section('title', 'About Us')

@section('content')
<div style="padding-top: 100px;">
    <!-- Header -->
    <section class="py-5" style="background: var(--primary-light);">
        <div class="container text-center">
            <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Our Story</p>
            <h1>About <span class="text-accent">Urbanix Hotel</span></h1>
            <p class="text-secondary mx-auto" style="max-width: 500px;">Experience luxury and comfort in the heart of Jakarta since 2010</p>
        </div>
    </section>

    <!-- Story Section -->
    <section class="section">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600" alt="Urbanix Hotel" class="img-fluid rounded-4" style="box-shadow: 0 30px 60px rgba(0,0,0,0.4);">
                        <div class="position-absolute" style="bottom: -20px; left: -20px; width: 120px; height: 120px; border: 3px solid var(--accent); border-radius: 20px; z-index: -1;"></div>
                        <div class="position-absolute glass-card py-3 px-4" style="bottom: 30px; right: -30px;">
                            <h3 class="text-accent mb-0">15+</h3>
                            <small class="text-secondary">Years of Excellence</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 2px; font-size: 0.85rem;">Who We Are</p>
                    <h2 class="mb-4">Our <span class="text-accent">Story</span></h2>
                    <p class="text-secondary" style="line-height: 1.9;">Urbanix Hotel was founded with a vision to redefine luxury hospitality in Jakarta. Since our establishment in 2010, we have been dedicated to providing an exceptional experience that combines modern comfort with timeless elegance.</p>
                    <p class="text-secondary" style="line-height: 1.9;">Our commitment to excellence is reflected in every aspect of our service, from our meticulously designed rooms to our world-class amenities and personalized guest services. Every detail has been carefully considered to ensure your stay is nothing short of extraordinary.</p>
                    
                    <div class="d-flex gap-4 mt-4">
                        <div class="text-center">
                            <h3 class="text-accent mb-1">200+</h3>
                            <small class="text-secondary">Luxury Rooms</small>
                        </div>
                        <div class="text-center">
                            <h3 class="text-accent mb-1">4.9</h3>
                            <small class="text-secondary">Guest Rating</small>
                        </div>
                        <div class="text-center">
                            <h3 class="text-accent mb-1">50K+</h3>
                            <small class="text-secondary">Happy Guests</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="section" style="background: var(--primary);">
        <div class="container">
            <div class="text-center mb-5">
                <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Our Values</p>
                <h2>Why Choose <span class="text-accent">Us</span></h2>
                <div class="section-divider"></div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box h-100">
                        <div class="feature-icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <h5 class="mb-3">Prime Location</h5>
                        <p class="text-secondary mb-0">Located in the heart of Jakarta's business district with easy access to major attractions, shopping centers, and transportation hubs.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box h-100">
                        <div class="feature-icon">
                            <i class="bi bi-star"></i>
                        </div>
                        <h5 class="mb-3">5-Star Service</h5>
                        <p class="text-secondary mb-0">Our dedicated team of hospitality professionals ensures every guest receives personalized attention and exceptional service around the clock.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box h-100">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h5 class="mb-3">Safety First</h5>
                        <p class="text-secondary mb-0">Your safety is our priority with 24/7 security surveillance, comprehensive health protocols, and a dedicated safety team.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box h-100">
                        <div class="feature-icon">
                            <i class="bi bi-gem"></i>
                        </div>
                        <h5 class="mb-3">Luxury Experience</h5>
                        <p class="text-secondary mb-0">Premium amenities, designer interiors, and attention to every detail ensure an unforgettable luxury experience.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box h-100">
                        <div class="feature-icon">
                            <i class="bi bi-cup-hot"></i>
                        </div>
                        <h5 class="mb-3">World-Class Dining</h5>
                        <p class="text-secondary mb-0">Savor exquisite cuisines from around the world prepared by our award-winning chefs in our multiple restaurants.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="feature-box h-100">
                        <div class="feature-icon">
                            <i class="bi bi-flower1"></i>
                        </div>
                        <h5 class="mb-3">Spa & Wellness</h5>
                        <p class="text-secondary mb-0">Rejuvenate your body and mind at our full-service spa featuring traditional and modern wellness treatments.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="section">
        <div class="container">
            <div class="text-center mb-5">
                <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Leadership</p>
                <h2>Meet Our <span class="text-accent">Team</span></h2>
                <div class="section-divider"></div>
            </div>
            
            <div class="row g-4 justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card text-center h-100">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--accent), var(--accent-dark));">
                            <span class="text-dark fw-bold fs-3">AR</span>
                        </div>
                        <h5 class="mb-1">Ahmad Rahman</h5>
                        <p class="text-accent small mb-2">General Manager</p>
                        <p class="text-secondary small mb-0">20+ years in luxury hospitality</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card text-center h-100">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--accent), var(--accent-dark));">
                            <span class="text-dark fw-bold fs-3">SW</span>
                        </div>
                        <h5 class="mb-1">Sarah Wijaya</h5>
                        <p class="text-accent small mb-2">Director of Operations</p>
                        <p class="text-secondary small mb-0">Excellence in guest services</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card text-center h-100">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--accent), var(--accent-dark));">
                            <span class="text-dark fw-bold fs-3">DK</span>
                        </div>
                        <h5 class="mb-1">David Kusuma</h5>
                        <p class="text-accent small mb-2">Executive Chef</p>
                        <p class="text-secondary small mb-0">Award-winning culinary expert</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="glass-card text-center h-100">
                        <div class="rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, var(--accent), var(--accent-dark));">
                            <span class="text-dark fw-bold fs-3">LP</span>
                        </div>
                        <h5 class="mb-1">Lisa Putri</h5>
                        <p class="text-accent small mb-2">Spa Director</p>
                        <p class="text-secondary small mb-0">Wellness & relaxation specialist</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section section text-center">
        <div class="container position-relative" style="z-index: 2;">
            <h2 class="mb-3">Experience the <span class="text-accent">Urbanix Difference</span></h2>
            <p class="text-secondary mb-4 mx-auto" style="max-width: 500px;">Ready to experience luxury hospitality at its finest? Book your stay with us today.</p>
            <a href="{{ route('rooms.index') }}" class="btn btn-gold btn-lg px-5">Book Your Stay</a>
        </div>
    </section>
</div>
@endsection
