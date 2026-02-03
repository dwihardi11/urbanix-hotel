@extends('layouts.frontend')

@section('title', 'Book ' . $room->roomType->name)

@section('content')
<div style="padding-top: 100px;">
    <!-- Header -->
    <section class="py-5" style="background: var(--primary-light);">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-3" style="background: transparent;">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-accent text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rooms.index') }}" class="text-accent text-decoration-none">Rooms</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('rooms.show', $room) }}" class="text-accent text-decoration-none">{{ $room->roomType->name }}</a></li>
                    <li class="breadcrumb-item text-secondary">Booking</li>
                </ol>
            </nav>
            <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Complete Your Reservation</p>
            <h1>Book Your <span class="text-accent">Stay</span></h1>
        </div>
    </section>

    <section class="section">
        <div class="container">
            @if($errors->any())
            <div class="alert mb-4" style="background: rgba(255, 107, 107, 0.1); border-left: 4px solid #ff6b6b; border-radius: 12px; color: #ff6b6b;">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="room_id" value="{{ $room->id }}">
                <input type="hidden" name="check_in" value="{{ $checkIn }}">
                <input type="hidden" name="check_out" value="{{ $checkOut }}">

                <div class="row">
                    <!-- Guest Information -->
                    <div class="col-lg-8">
                        <div class="glass-card mb-4">
                            <h4 class="text-accent mb-4 d-flex align-items-center">
                                <i class="bi bi-person me-2"></i>Guest Information
                            </h4>
                            
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" name="guest_name" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" value="{{ old('guest_name', auth()->user()->name ?? '') }}" placeholder="Enter your full name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Email Address</label>
                                    <input type="email" name="guest_email" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" value="{{ old('guest_email', auth()->user()->email ?? '') }}" placeholder="email@example.com">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Phone Number <span class="text-danger">*</span></label>
                                    <input type="tel" name="guest_phone" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" value="{{ old('guest_phone') }}" placeholder="+62..." required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">ID Type <span class="text-danger">*</span></label>
                                    <select name="id_type" class="form-select" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" required>
                                        <option value="ktp" {{ old('id_type') == 'ktp' ? 'selected' : '' }}>KTP (ID Card)</option>
                                        <option value="sim" {{ old('id_type') == 'sim' ? 'selected' : '' }}>SIM (Driver License)</option>
                                        <option value="passport" {{ old('id_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">ID Number <span class="text-danger">*</span></label>
                                    <input type="text" name="id_number" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" value="{{ old('id_number') }}" placeholder="Enter ID number" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">City</label>
                                    <input type="text" name="city" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" value="{{ old('city') }}" placeholder="Your city">
                                </div>
                                <div class="col-12">
                                    <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Address</label>
                                    <textarea name="address" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" rows="2" placeholder="Enter your address">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card">
                            <h4 class="text-accent mb-4 d-flex align-items-center">
                                <i class="bi bi-chat-dots me-2"></i>Special Requests
                            </h4>
                            <textarea name="special_requests" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" rows="3" placeholder="Any special requests? (e.g., early check-in, extra pillows, etc.)">{{ old('special_requests') }}</textarea>
                            <small class="text-secondary mt-2 d-block">Special requests are subject to availability and may incur additional charges.</small>
                        </div>
                    </div>

                    <!-- Booking Summary -->
                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <div class="glass-card sticky-lg-top" style="top: 100px;">
                            <h4 class="text-accent mb-4 d-flex align-items-center">
                                <i class="bi bi-receipt me-2"></i>Booking Summary
                            </h4>
                            
                            <div class="d-flex mb-4">
                                <img src="https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=100" alt="{{ $room->roomType->name }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                <div class="ms-3">
                                    <h6 class="mb-1">{{ $room->roomType->name }}</h6>
                                    <p class="text-secondary small mb-0">Room {{ $room->room_number }}</p>
                                    <span class="badge mt-1" style="background: rgba(100, 255, 218, 0.2); color: var(--teal); font-size: 0.7rem;">{{ $room->roomType->bed_type }}</span>
                                </div>
                            </div>

                            <div style="background: rgba(230, 198, 138, 0.05); border-radius: 12px; padding: 1rem; margin-bottom: 1rem;">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-accent d-block">Check In</small>
                                        <strong>{{ \Carbon\Carbon::parse($checkIn)->format('d M Y') }}</strong>
                                        <small class="text-secondary d-block">From 14:00</small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-accent d-block">Check Out</small>
                                        <strong>{{ \Carbon\Carbon::parse($checkOut)->format('d M Y') }}</strong>
                                        <small class="text-secondary d-block">Until 12:00</small>
                                    </div>
                                </div>
                            </div>

                            <hr style="border-color: rgba(230, 198, 138, 0.2);">

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">{{ $room->formatted_price }} x {{ $price['total_nights'] }} nights</span>
                                <span>Rp {{ number_format($price['subtotal'], 0, ',', '.') }}</span>
                            </div>

                            @if($price['discount'] > 0)
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-secondary">Discount ({{ $price['total_nights'] >= 7 ? '10%' : '5%' }})</span>
                                <span class="text-teal">-Rp {{ number_format($price['discount'], 0, ',', '.') }}</span>
                            </div>
                            @endif

                            <hr style="border-color: rgba(230, 198, 138, 0.2);">

                            <div class="d-flex justify-content-between mb-4">
                                <strong>Total</strong>
                                <strong class="room-card-price" style="font-size: 1.5rem;">Rp {{ number_format($price['total_price'], 0, ',', '.') }}</strong>
                            </div>

                            <button type="submit" class="btn btn-gold w-100 py-3">
                                <i class="bi bi-check-circle me-2"></i>Confirm Booking
                            </button>

                            <p class="text-secondary small text-center mt-3 mb-0">
                                By clicking confirm, you agree to our <a href="#" class="text-accent">terms and conditions</a>.
                            </p>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .breadcrumb-item + .breadcrumb-item::before {
        color: var(--text-secondary);
    }
    
    .form-select option {
        background: var(--primary);
        color: var(--text-primary);
    }
    
    .form-control::placeholder {
        color: var(--text-secondary) !important;
        opacity: 0.7;
    }
</style>
@endpush
