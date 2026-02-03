@extends('layouts.frontend')

@section('title', 'Booking Confirmed')

@section('content')
<div style="padding-top: 100px;">
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Success Message -->
                    <div class="glass-card text-center mb-4">
                        <div class="mb-4">
                            <div class="d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(100, 255, 218, 0.2), rgba(100, 255, 218, 0.1)); border-radius: 50%;">
                                <i class="bi bi-check-lg text-teal" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Reservation Complete</p>
                        <h1 class="mb-3">Booking <span class="text-accent">Confirmed!</span></h1>
                        <p class="text-secondary mb-4">Thank you for your reservation. We've sent the booking details to your email.</p>
                        
                        <div class="glass-card d-inline-block px-5 py-4 mb-4" style="background: rgba(230, 198, 138, 0.05);">
                            <small class="text-secondary d-block mb-2 text-uppercase" style="letter-spacing: 2px;">Your Booking Code</small>
                            <h2 class="room-card-price mb-0" style="font-size: 2rem; letter-spacing: 5px;">{{ $booking->booking_code }}</h2>
                        </div>
                        
                        <p class="text-secondary small">Please save this code to check your booking status later.</p>
                    </div>

                    <!-- Booking Details -->
                    <div class="glass-card mb-4">
                        <h4 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-bookmark-check me-2"></i>Booking Details
                        </h4>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="p-3 rounded" style="background: rgba(230, 198, 138, 0.05); border: 1px solid rgba(230, 198, 138, 0.1);">
                                    <h6 class="text-accent mb-3 d-flex align-items-center">
                                        <i class="bi bi-door-open me-2"></i>Room Information
                                    </h6>
                                    <p class="mb-2"><strong>{{ $booking->room->roomType->name }}</strong></p>
                                    <p class="text-secondary mb-2 small">
                                        <i class="bi bi-hash me-1"></i>Room {{ $booking->room->room_number }} • Floor {{ $booking->room->floor }}
                                    </p>
                                    <p class="text-secondary mb-0 small">
                                        <i class="bi bi-building me-1"></i>{{ $booking->room->hotel->name }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="p-3 rounded" style="background: rgba(100, 255, 218, 0.05); border: 1px solid rgba(100, 255, 218, 0.1);">
                                    <h6 class="text-teal mb-3 d-flex align-items-center">
                                        <i class="bi bi-calendar-range me-2"></i>Stay Duration
                                    </h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-secondary">Check In</small>
                                            <p class="mb-0"><strong>{{ $booking->check_in->format('d M Y') }}</strong></p>
                                            <small class="text-secondary">From 14:00</small>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-secondary">Check Out</small>
                                            <p class="mb-0"><strong>{{ $booking->check_out->format('d M Y') }}</strong></p>
                                            <small class="text-secondary">Until 12:00</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr style="border-color: rgba(230, 198, 138, 0.2);">

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <h6 class="text-accent mb-3 d-flex align-items-center">
                                    <i class="bi bi-person me-2"></i>Guest Information
                                </h6>
                                <p class="mb-1"><strong>{{ $booking->guest->name }}</strong></p>
                                <p class="text-secondary mb-1 small"><i class="bi bi-telephone me-2"></i>{{ $booking->guest->phone }}</p>
                                @if($booking->guest->email)
                                <p class="text-secondary mb-0 small"><i class="bi bi-envelope me-2"></i>{{ $booking->guest->email }}</p>
                                @endif
                            </div>
                            <div class="col-md-6 mb-4">
                                <h6 class="text-accent mb-3 d-flex align-items-center">
                                    <i class="bi bi-receipt me-2"></i>Payment Summary
                                </h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">{{ $booking->total_nights }} nights</span>
                                    <span>{{ $booking->formatted_price }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-secondary">Status</span>
                                    <span class="badge" style="background: rgba(100, 255, 218, 0.2); color: var(--teal);">{{ ucfirst($booking->status) }}</span>
                                </div>
                            </div>
                        </div>

                        @if($booking->special_requests)
                        <hr style="border-color: rgba(230, 198, 138, 0.2);">
                        <h6 class="text-accent mb-2 d-flex align-items-center">
                            <i class="bi bi-chat-dots me-2"></i>Special Requests
                        </h6>
                        <p class="mb-0 text-secondary">{{ $booking->special_requests }}</p>
                        @endif
                    </div>

                    <!-- What's Next -->
                    <div class="glass-card">
                        <h4 class="text-accent mb-4 d-flex align-items-center">
                            <i class="bi bi-arrow-right-circle me-2"></i>What's Next?
                        </h4>
                        <div class="row g-4">
                            <div class="col-md-4 text-center">
                                <div class="feature-box h-100">
                                    <div class="feature-icon">
                                        <i class="bi bi-envelope"></i>
                                    </div>
                                    <h6 class="mb-2">Check Email</h6>
                                    <p class="text-secondary small mb-0">We've sent a confirmation to your email</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="feature-box h-100">
                                    <div class="feature-icon">
                                        <i class="bi bi-credit-card"></i>
                                    </div>
                                    <h6 class="mb-2">Payment</h6>
                                    <p class="text-secondary small mb-0">Pay at the hotel during check-in</p>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="feature-box h-100">
                                    <div class="feature-icon">
                                        <i class="bi bi-door-open"></i>
                                    </div>
                                    <h6 class="mb-2">Check In</h6>
                                    <p class="text-secondary small mb-0">Arrive at the hotel from 14:00</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        <a href="{{ route('home') }}" class="btn btn-outline-gold me-2">
                            <i class="bi bi-house me-2"></i>Back to Home
                        </a>
                        <a href="{{ route('rooms.index') }}" class="btn btn-gold">
                            <i class="bi bi-door-open me-2"></i>Book Another Room
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .text-teal {
        color: var(--teal) !important;
    }
</style>
@endpush
