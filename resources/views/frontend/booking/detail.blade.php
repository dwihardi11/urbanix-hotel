@extends('layouts.frontend')

@section('title', 'My Booking - ' . $booking->booking_code)

@section('content')
<div style="padding-top: 100px;">
    <!-- Header -->
    <section class="py-5" style="background: var(--primary-light);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3" style="background: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-accent text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('booking.search') }}" class="text-accent text-decoration-none">My Booking</a></li>
                    <li class="breadcrumb-item text-secondary">{{ $booking->booking_code }}</li>
                </ol>
            </nav>
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Reservation Details</p>
                    <h1>Booking <span class="text-accent">{{ $booking->booking_code }}</span></h1>
                </div>
                @php
                    $statusStyles = [
                        'pending' => 'background: rgba(255, 193, 7, 0.2); color: #ffc107;',
                        'confirmed' => 'background: rgba(100, 255, 218, 0.2); color: var(--teal);',
                        'checked_in' => 'background: rgba(13, 110, 253, 0.2); color: #0d6efd;',
                        'checked_out' => 'background: rgba(108, 117, 125, 0.2); color: #6c757d;',
                        'cancelled' => 'background: rgba(220, 53, 69, 0.2); color: #dc3545;',
                    ];
                @endphp
                <span class="badge fs-6 px-4 py-2" style="{{ $statusStyles[$booking->status] ?? 'background: rgba(230, 198, 138, 0.2); color: var(--accent);' }}">
                    <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem;"></i>{{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                </span>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Room Info -->
                    <div class="glass-card mb-4">
                        <h4 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-door-open me-2"></i>Room Details
                        </h4>
                        <div class="row align-items-center">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=300" alt="{{ $booking->room->roomType->name }}" class="img-fluid rounded" style="box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
                            </div>
                            <div class="col-md-8">
                                <h5 class="mb-2">{{ $booking->room->roomType->name }}</h5>
                                <p class="text-secondary mb-2">
                                    <i class="bi bi-hash me-1"></i>Room {{ $booking->room->room_number }} • Floor {{ $booking->room->floor }}
                                </p>
                                <p class="mb-2">
                                    <i class="bi bi-building text-accent me-1"></i>{{ $booking->room->hotel->name }}
                                </p>
                                <p class="text-secondary mb-0 small">
                                    <i class="bi bi-geo-alt me-1"></i>{{ $booking->room->hotel->address }}, {{ $booking->room->hotel->city }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Stay Details -->
                    <div class="glass-card mb-4">
                        <h4 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-calendar-range me-2"></i>Stay Details
                        </h4>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="feature-icon me-3" style="width: 50px; height: 50px; margin: 0; font-size: 1.1rem;">
                                        <i class="bi bi-calendar-check"></i>
                                    </div>
                                    <div>
                                        <small class="text-secondary d-block">Check In</small>
                                        <strong>{{ $booking->check_in->format('l, d M Y') }}</strong>
                                        <small class="text-teal d-block">From 14:00</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="d-flex align-items-start">
                                    <div class="feature-icon me-3" style="width: 50px; height: 50px; margin: 0; font-size: 1.1rem;">
                                        <i class="bi bi-calendar-x"></i>
                                    </div>
                                    <div>
                                        <small class="text-secondary d-block">Check Out</small>
                                        <strong>{{ $booking->check_out->format('l, d M Y') }}</strong>
                                        <small class="text-teal d-block">Until 12:00</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3 pt-3" style="border-top: 1px solid rgba(230, 198, 138, 0.1);">
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <div class="p-3 rounded text-center" style="background: rgba(230, 198, 138, 0.05);">
                                        <i class="bi bi-moon text-accent fs-4 d-block mb-2"></i>
                                        <small class="text-secondary d-block">Duration</small>
                                        <strong>{{ $booking->total_nights }} nights</strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 rounded text-center" style="background: rgba(230, 198, 138, 0.05);">
                                        <i class="bi bi-people text-accent fs-4 d-block mb-2"></i>
                                        <small class="text-secondary d-block">Max Guests</small>
                                        <strong>{{ $booking->room->roomType->capacity }} persons</strong>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-3 rounded text-center" style="background: rgba(230, 198, 138, 0.05);">
                                        <i class="bi bi-lamp text-accent fs-4 d-block mb-2"></i>
                                        <small class="text-secondary d-block">Bed Type</small>
                                        <strong>{{ $booking->room->roomType->bed_type }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Guest Info -->
                    <div class="glass-card">
                        <h4 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-person me-2"></i>Guest Information
                        </h4>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <small class="text-accent d-block text-uppercase" style="letter-spacing: 1px;">Name</small>
                                <strong>{{ $booking->guest->name }}</strong>
                            </div>
                            <div class="col-md-6">
                                <small class="text-accent d-block text-uppercase" style="letter-spacing: 1px;">Phone</small>
                                <strong>{{ $booking->guest->phone }}</strong>
                            </div>
                            @if($booking->guest->email)
                            <div class="col-md-6">
                                <small class="text-accent d-block text-uppercase" style="letter-spacing: 1px;">Email</small>
                                <strong>{{ $booking->guest->email }}</strong>
                            </div>
                            @endif
                            <div class="col-md-6">
                                <small class="text-accent d-block text-uppercase" style="letter-spacing: 1px;">ID</small>
                                <strong>{{ $booking->guest->formatted_id_type }}: {{ $booking->guest->id_number }}</strong>
                            </div>
                        </div>

                        @if($booking->special_requests)
                        <div class="mt-4 pt-4" style="border-top: 1px solid rgba(230, 198, 138, 0.1);">
                            <small class="text-accent d-block text-uppercase mb-2" style="letter-spacing: 1px;">Special Requests</small>
                            <p class="mb-0 text-secondary">{{ $booking->special_requests }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="col-lg-4 mt-4 mt-lg-0">
                    <!-- Payment Summary -->
                    <div class="glass-card sticky-lg-top" style="top: 100px;">
                        <h4 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-receipt me-2"></i>Payment Summary
                        </h4>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary">{{ $booking->total_nights }} nights</span>
                            <span>{{ $booking->formatted_price }}</span>
                        </div>
                        
                        <hr style="border-color: rgba(230, 198, 138, 0.2);">
                        
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total</strong>
                            <strong class="room-card-price" style="font-size: 1.25rem;">{{ $booking->formatted_price }}</strong>
                        </div>
                        
                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-secondary">Payment Status</span>
                            @php
                                $paymentStyles = [
                                    'pending' => 'background: rgba(255, 193, 7, 0.2); color: #ffc107;',
                                    'paid' => 'background: rgba(100, 255, 218, 0.2); color: var(--teal);',
                                    'refunded' => 'background: rgba(108, 117, 125, 0.2); color: #6c757d;',
                                ];
                            @endphp
                            <span class="badge" style="{{ $paymentStyles[$booking->payment_status] ?? 'background: rgba(230, 198, 138, 0.2); color: var(--accent);' }}">
                                {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>

                        <hr style="border-color: rgba(230, 198, 138, 0.2);">

                        <div class="text-center">
                            <p class="text-secondary small mb-2">Need help with your booking?</p>
                            <a href="tel:{{ $booking->room->hotel->phone ?? '+6221234568' }}" class="text-accent text-decoration-none">
                                <i class="bi bi-telephone me-2"></i>{{ $booking->room->hotel->phone ?? '+62 21 1234 5678' }}
                            </a>
                        </div>

                        <div class="mt-4 pt-4" style="border-top: 1px solid rgba(230, 198, 138, 0.1);">
                            <a href="{{ route('rooms.index') }}" class="btn btn-outline-gold w-100">
                                <i class="bi bi-plus-lg me-2"></i>Book Another Room
                            </a>
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
    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--text-secondary);
    }
    
    .text-teal {
        color: var(--teal) !important;
    }
</style>
@endpush
