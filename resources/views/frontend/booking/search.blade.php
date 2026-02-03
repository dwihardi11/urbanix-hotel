@extends('layouts.frontend')

@section('title', 'My Bookings')

@section('content')
<div style="padding-top: 100px;">
    <!-- Header -->
    <section class="py-5" style="background: var(--primary-light);">
        <div class="container text-center">
            <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Your Reservations</p>
            <h1>My <span class="text-accent">Bookings</span></h1>
            <p class="text-secondary mx-auto" style="max-width: 500px;">Welcome back, {{ auth()->user()->name }}! Here are your booking history.</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if($bookings->isEmpty())
                <!-- No Bookings State -->
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="glass-card text-center py-5">
                            <div class="feature-icon mx-auto mb-4" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                <i class="bi bi-calendar-x"></i>
                            </div>
                            <h4 class="mb-3">No Bookings Yet</h4>
                            <p class="text-secondary mb-4">You haven't made any reservations yet. Start exploring our luxurious rooms and book your perfect stay!</p>
                            <a href="{{ route('rooms.index') }}" class="btn btn-gold px-4 py-3">
                                <i class="bi bi-search me-2"></i>Browse Rooms & Book Now
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <!-- Bookings List -->
                <div class="row g-4">
                    @foreach($bookings as $booking)
                    <div class="col-lg-6">
                        <div class="glass-card h-100">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <span class="badge bg-accent text-dark mb-2">{{ $booking->booking_code }}</span>
                                    <h5 class="mb-1">{{ $booking->room->roomType->name ?? 'Room' }}</h5>
                                    <p class="text-secondary small mb-0">{{ $booking->room->room_number }}</p>
                                </div>
                                <span class="badge {{ $booking->status == 'confirmed' ? 'bg-success' : ($booking->status == 'pending' ? 'bg-warning text-dark' : ($booking->status == 'checked_in' ? 'bg-info' : ($booking->status == 'completed' ? 'bg-secondary' : 'bg-danger'))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </div>
                            
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <div class="p-3 rounded" style="background: rgba(255,255,255,0.03);">
                                        <p class="text-secondary small mb-1">Check-in</p>
                                        <p class="mb-0 text-accent"><i class="bi bi-calendar-check me-1"></i>{{ \Carbon\Carbon::parse($booking->check_in)->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3 rounded" style="background: rgba(255,255,255,0.03);">
                                        <p class="text-secondary small mb-1">Check-out</p>
                                        <p class="mb-0 text-accent"><i class="bi bi-calendar-x me-1"></i>{{ \Carbon\Carbon::parse($booking->check_out)->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3" style="border-top: 1px solid rgba(230, 198, 138, 0.1);">
                                <div>
                                    <p class="text-secondary small mb-0">Total Amount</p>
                                    <p class="text-accent h5 mb-0">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('booking.confirmation', $booking->booking_code) }}" class="btn btn-outline-gold btn-sm">
                                    <i class="bi bi-eye me-1"></i>View Details
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Book More -->
                <div class="text-center mt-5 pt-4" style="border-top: 1px solid rgba(230, 198, 138, 0.1);">
                    <p class="text-secondary mb-3">Looking for another stay?</p>
                    <a href="{{ route('rooms.index') }}" class="btn btn-gold px-4">
                        <i class="bi bi-plus-lg me-2"></i>Book Another Room
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .badge.bg-accent {
        background: var(--accent) !important;
    }
</style>
@endpush
