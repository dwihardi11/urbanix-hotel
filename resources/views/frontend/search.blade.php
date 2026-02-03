@extends('layouts.frontend')

@section('title', 'Search Results')

@section('content')
<div style="padding-top: 100px;">
    <!-- Header -->
    <section class="py-5" style="background: var(--primary-light);">
        <div class="container">
            <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Search Results</p>
            <h1 class="mb-3">Available <span class="text-accent">Rooms</span></h1>
            <div class="d-flex align-items-center flex-wrap gap-3">
                <span class="badge" style="background: rgba(230, 198, 138, 0.2); color: var(--accent); padding: 0.5rem 1rem;">
                    <i class="bi bi-calendar-check me-1"></i>
                    {{ \Carbon\Carbon::parse($checkIn)->format('d M Y') }} - {{ \Carbon\Carbon::parse($checkOut)->format('d M Y') }}
                </span>
                <span class="badge" style="background: rgba(100, 255, 218, 0.2); color: var(--teal); padding: 0.5rem 1rem;">
                    <i class="bi bi-moon me-1"></i>
                    {{ \Carbon\Carbon::parse($checkIn)->diffInDays(\Carbon\Carbon::parse($checkOut)) }} nights
                </span>
                @if($guests)
                <span class="badge" style="background: rgba(255, 255, 255, 0.1); color: var(--text-primary); padding: 0.5rem 1rem;">
                    <i class="bi bi-people me-1"></i>
                    {{ $guests }} guests
                </span>
                @endif
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <!-- Modify Search -->
            <div class="glass-card mb-5">
                <h5 class="text-accent mb-4 d-flex align-items-center">
                    <i class="bi bi-sliders me-2"></i>Modify Search
                </h5>
                <form action="{{ route('search') }}" method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Check In</label>
                        <input type="date" name="check_in" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" value="{{ $checkIn }}" min="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Check Out</label>
                        <input type="date" name="check_out" class="form-control" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" value="{{ $checkOut }}" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Room Type</label>
                        <select name="room_type" class="form-select" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);">
                            <option value="">All Types</option>
                            @foreach($roomTypes as $type)
                            <option value="{{ $type->id }}" {{ $selectedType == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label text-accent small text-uppercase" style="letter-spacing: 1px;">Guests</label>
                        <select name="guests" class="form-select" style="background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);">
                            @for($i = 1; $i <= 4; $i++)
                            <option value="{{ $i }}" {{ $guests == $i ? 'selected' : '' }}>{{ $i }} {{ $i == 1 ? 'Guest' : 'Guests' }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-gold w-100">
                            <i class="bi bi-search me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>

            <!-- Results -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p class="mb-0 text-secondary">
                    <span class="text-accent fw-bold fs-4">{{ $rooms->count() }}</span> rooms available
                </p>
            </div>
            
            <div class="row g-4">
                @forelse($rooms as $room)
                <div class="col-md-6 col-lg-4">
                    <div class="room-card h-100">
                        <div class="room-card-img-wrapper">
                            <img src="https://images.unsplash.com/photo-1590490360182-c33d57733427?w=500" alt="{{ $room->roomType->name }}" class="room-card-img">
                        </div>
                        <div class="room-card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h4 class="room-card-title mb-0">{{ $room->roomType->name }}</h4>
                                <span class="badge" style="background: rgba(100, 255, 218, 0.2); color: var(--teal);">Available</span>
                            </div>
                            <p class="text-secondary small mb-3">
                                Room {{ $room->room_number }} • <i class="bi bi-people me-1"></i>{{ $room->roomType->capacity }} guests
                            </p>
                            
                            <div class="mb-3">
                                @foreach($room->amenities->take(4) as $amenity)
                                <span class="amenity-badge"><i class="{{ $amenity->icon }}"></i></span>
                                @endforeach
                            </div>

                            <div class="d-flex justify-content-between align-items-center pt-3 mt-3" style="border-top: 1px solid rgba(230, 198, 138, 0.1);">
                                <div class="room-card-price">
                                    {{ $room->formatted_price }}<span>/night</span>
                                </div>
                                <a href="{{ route('rooms.show', $room) }}?check_in={{ $checkIn }}&check_out={{ $checkOut }}" class="btn btn-gold px-4 py-2" style="font-size: 0.8rem; letter-spacing: 1px;">BOOK NOW</a>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="glass-card text-center py-5">
                        <i class="bi bi-calendar-x text-accent" style="font-size: 4rem;"></i>
                        <h4 class="mt-4 mb-2">No Rooms Available</h4>
                        <p class="text-secondary mb-4">Sorry, no rooms are available for your selected dates. Please try different dates.</p>
                        <a href="{{ route('rooms.index') }}" class="btn btn-outline-gold">Browse All Rooms</a>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>
</div>
@endsection

@push('styles')
<style>
    .form-select option {
        background: var(--primary);
        color: var(--text-primary);
    }
</style>
@endpush
