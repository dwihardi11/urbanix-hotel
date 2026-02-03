@extends('layouts.frontend')

@section('title', $room->roomType->name . ' - Room ' . $room->room_number)

@section('content')
<div style="padding-top: 100px;">
    <!-- Room Header -->
    <section class="py-5" style="background: var(--primary-light);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3" style="background: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-accent text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}" class="text-accent text-decoration-none">Rooms</a></li>
                    <li class="breadcrumb-item text-secondary">{{ $room->roomType->name }}</li>
                </ol>
            </nav>
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="mb-2">{{ $room->roomType->name }}</h1>
                    <p class="text-secondary mb-0">
                        <i class="bi bi-door-open me-2 text-accent"></i>Room {{ $room->room_number }} • Floor {{ $room->floor }}
                        @if($room->status == 'available')
                        <span class="badge ms-3" style="background: rgba(100, 255, 218, 0.2); color: var(--teal);">Available</span>
                        @endif
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                    <div class="room-card-price" style="font-size: 2.5rem;">
                        {{ $room->formatted_price }}<span style="font-size: 1rem;">/night</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row">
                <!-- Room Details -->
                <div class="col-lg-8">
                    <!-- Gallery -->
                    <div class="glass-card mb-4 p-0 overflow-hidden">
                        <div class="position-relative">
                            <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800" alt="{{ $room->roomType->name }}" class="img-fluid w-100" style="height: 450px; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 end-0 p-4" style="background: linear-gradient(to top, rgba(2,12,27,0.9), transparent);">
                                <div class="d-flex gap-2">
                                    @foreach($room->amenities->take(4) as $amenity)
                                    <span class="amenity-badge"><i class="{{ $amenity->icon }}"></i> {{ $amenity->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="glass-card mb-4">
                        <h4 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-info-circle me-2"></i>About This Room
                        </h4>
                        <p class="text-secondary mb-4" style="line-height: 1.8;">{{ $room->description ?? $room->roomType->description }}</p>
                        
                        <div class="row g-4 mt-2">
                            <div class="col-md-4">
                                <div class="feature-box text-start p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-icon me-3" style="width: 50px; height: 50px; margin: 0;">
                                            <i class="bi bi-people"></i>
                                        </div>
                                        <div>
                                            <small class="text-secondary d-block">Capacity</small>
                                            <strong>{{ $room->roomType->capacity }} Guests</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-box text-start p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-icon me-3" style="width: 50px; height: 50px; margin: 0;">
                                            <i class="bi bi-rulers"></i>
                                        </div>
                                        <div>
                                            <small class="text-secondary d-block">Room Size</small>
                                            <strong>{{ $room->roomType->size_sqm ?? 25 }} m²</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-box text-start p-3">
                                    <div class="d-flex align-items-center">
                                        <div class="feature-icon me-3" style="width: 50px; height: 50px; margin: 0;">
                                            <i class="bi bi-lamp"></i>
                                        </div>
                                        <div>
                                            <small class="text-secondary d-block">Bed Type</small>
                                            <strong>{{ $room->roomType->bed_type }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Amenities -->
                    <div class="glass-card mb-4">
                        <h4 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-stars me-2"></i>Room Amenities
                        </h4>
                        <div class="row g-3">
                            @foreach($room->amenities as $amenity)
                            <div class="col-md-4 col-6">
                                <div class="d-flex align-items-center p-2 rounded" style="background: rgba(230, 198, 138, 0.05); border: 1px solid rgba(230, 198, 138, 0.1);">
                                    <i class="{{ $amenity->icon }} text-accent me-3 fs-5"></i>
                                    <span>{{ $amenity->name }}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Hotel Policies -->
                    <div class="glass-card">
                        <h4 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-file-text me-2"></i>Hotel Policies
                        </h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="d-flex align-items-start mb-3">
                                    <div class="feature-icon me-3" style="width: 45px; height: 45px; margin: 0; font-size: 1.1rem;">
                                        <i class="bi bi-clock"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block">Check-in</strong>
                                        <span class="text-secondary">{{ $room->hotel->check_in_time ?? '14:00' }} - 22:00</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-start">
                                    <div class="feature-icon me-3" style="width: 45px; height: 45px; margin: 0; font-size: 1.1rem;">
                                        <i class="bi bi-clock-history"></i>
                                    </div>
                                    <div>
                                        <strong class="d-block">Check-out</strong>
                                        <span class="text-secondary">Before {{ $room->hotel->check_out_time ?? '12:00' }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-x-circle text-danger me-3 fs-5"></i>
                                    <span>No smoking in rooms</span>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-check-circle text-teal me-3 fs-5"></i>
                                    <span>Free cancellation (24h before)</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-check-circle text-teal me-3 fs-5"></i>
                                    <span>Pets allowed on request</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Sidebar -->
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="glass-card sticky-lg-top" style="top: 100px;">
                        <div class="text-center mb-4">
                            <p class="text-secondary mb-1 small text-uppercase" style="letter-spacing: 2px;">Price per night</p>
                            <div class="room-card-price" style="font-size: 2rem;">
                                {{ $room->formatted_price }}
                            </div>
                        </div>
                        
                        <hr style="border-color: rgba(230, 198, 138, 0.2);">
                        
                        <form action="{{ route('booking.create', $room) }}" method="GET" id="bookingForm">
                            <div class="mb-3">
                                <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Check In</label>
                                <input type="date" name="check_in" id="checkIn" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" min="{{ date('Y-m-d') }}" value="{{ request('check_in') }}" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Check Out</label>
                                <input type="date" name="check_out" id="checkOut" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" min="{{ date('Y-m-d', strtotime('+1 day')) }}" value="{{ request('check_out') }}" required>
                            </div>

                            <!-- Price Summary -->
                            <div id="priceSummary" class="mb-4" style="display: none; background: rgba(230, 198, 138, 0.05); border-radius: 12px; padding: 1rem;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">{{ $room->formatted_price }} x <span id="nights">0</span> nights</span>
                                    <span id="subtotal">Rp 0</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2" id="discountRow" style="display: none !important;">
                                    <span class="text-secondary">Discount</span>
                                    <span class="text-teal" id="discount">-Rp 0</span>
                                </div>
                                <hr style="border-color: rgba(230, 198, 138, 0.2);">
                                <div class="d-flex justify-content-between">
                                    <strong>Total</strong>
                                    <strong class="text-accent" id="totalPrice">Rp 0</strong>
                                </div>
                            </div>

                            @if($room->status == 'available')
                            <button type="submit" class="btn btn-gold w-100 py-3" id="bookBtn" disabled>
                                <i class="bi bi-calendar-check me-2"></i>Check Availability
                            </button>
                            @else
                            <button type="button" class="btn btn-secondary w-100 py-3" disabled>
                                <i class="bi bi-x-circle me-2"></i>Not Available
                            </button>
                            @endif
                        </form>

                        <div class="text-center mt-4 pt-4" style="border-top: 1px solid rgba(230, 198, 138, 0.1);">
                            <p class="text-secondary small mb-2">Need assistance?</p>
                            <p class="mb-0">
                                <a href="tel:{{ $room->hotel->phone ?? '+6221234568' }}" class="text-accent text-decoration-none">
                                    <i class="bi bi-telephone me-2"></i>{{ $room->hotel->phone ?? '+62 21 1234 5678' }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Similar Rooms -->
            @if($similarRooms->count() > 0)
            <div class="mt-5 pt-5">
                <h3 class="section-title">Similar <span class="text-accent">Rooms</span></h3>
                <div class="section-divider"></div>
                <p class="section-subtitle">You might also like these accommodations</p>
                
                <div class="row g-4">
                    @foreach($similarRooms as $similar)
                    <div class="col-lg-4 col-md-6">
                        <div class="room-card h-100">
                            <div class="room-card-img-wrapper">
                                <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=400" alt="{{ $similar->room_number }}" class="room-card-img">
                            </div>
                            <div class="room-card-body">
                                <h5 class="room-card-title">Room {{ $similar->room_number }}</h5>
                                <p class="text-secondary small mb-3">{{ $similar->roomType->name }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="room-card-price">{{ $similar->formatted_price }}<span>/night</span></span>
                                    <a href="{{ route('rooms.show', $similar) }}" class="btn btn-sm btn-outline-gold">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--text-secondary);
    }
</style>
@endpush

@push('scripts')
<script>
    const pricePerNight = {{ $room->price_per_night }};
    const checkIn = document.getElementById('checkIn');
    const checkOut = document.getElementById('checkOut');
    const bookBtn = document.getElementById('bookBtn');
    const priceSummary = document.getElementById('priceSummary');

    function calculatePrice() {
        if (checkIn.value && checkOut.value) {
            const start = new Date(checkIn.value);
            const end = new Date(checkOut.value);
            const nights = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
            
            if (nights > 0) {
                const subtotal = pricePerNight * nights;
                let discount = 0;
                
                if (nights >= 7) {
                    discount = subtotal * 0.10;
                } else if (nights >= 3) {
                    discount = subtotal * 0.05;
                }
                
                const total = subtotal - discount;
                
                document.getElementById('nights').textContent = nights;
                document.getElementById('subtotal').textContent = formatRupiah(subtotal);
                document.getElementById('totalPrice').textContent = formatRupiah(total);
                
                if (discount > 0) {
                    document.getElementById('discount').textContent = '-' + formatRupiah(discount);
                    document.getElementById('discountRow').style.cssText = 'display: flex !important;';
                } else {
                    document.getElementById('discountRow').style.cssText = 'display: none !important;';
                }
                
                priceSummary.style.display = 'block';
                bookBtn.disabled = false;
                bookBtn.innerHTML = '<i class="bi bi-calendar-check me-2"></i>Book Now';
            }
        }
    }

    function formatRupiah(amount) {
        return 'Rp ' + amount.toLocaleString('id-ID');
    }

    checkIn.addEventListener('change', function() {
        const minCheckOut = new Date(this.value);
        minCheckOut.setDate(minCheckOut.getDate() + 1);
        checkOut.min = minCheckOut.toISOString().split('T')[0];
        if (checkOut.value && new Date(checkOut.value) <= new Date(this.value)) {
            checkOut.value = '';
        }
        calculatePrice();
    });

    checkOut.addEventListener('change', calculatePrice);
    
    // Initial calculation if dates are provided
    if (checkIn.value && checkOut.value) {
        calculatePrice();
    }
</script>
@endpush
