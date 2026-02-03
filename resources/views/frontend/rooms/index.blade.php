@extends('layouts.frontend')

@section('title', 'Our Rooms')

@push('styles')
<style>
    /* Hero Banner */
    .rooms-hero {
        background: linear-gradient(135deg, rgba(10, 25, 47, 0.95) 0%, rgba(17, 34, 64, 0.9) 100%),
                    url('https://images.unsplash.com/photo-1618773928121-c32242e63f39?w=1920') center/cover;
        padding: 80px 0;
        position: relative;
        overflow: hidden;
    }
    
    .rooms-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 30% 50%, rgba(230, 198, 138, 0.08) 0%, transparent 50%);
    }

    /* Quick Stats */
    .quick-stat-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(230, 198, 138, 0.15);
        border-radius: 16px;
        padding: 20px 24px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .quick-stat-card:hover {
        background: rgba(255, 255, 255, 0.06);
        border-color: rgba(230, 198, 138, 0.3);
        transform: translateY(-3px);
    }

    .quick-stat-card i {
        font-size: 1.5rem;
        color: var(--accent);
        margin-bottom: 8px;
    }

    .quick-stat-card .stat-value {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-highlight);
    }

    .quick-stat-card .stat-label {
        font-size: 0.75rem;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Room Type Tabs */
    .room-type-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 30px;
    }

    .room-type-tab {
        padding: 12px 24px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(230, 198, 138, 0.15);
        border-radius: 50px;
        color: var(--text-secondary);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .room-type-tab:hover {
        background: rgba(230, 198, 138, 0.1);
        color: var(--accent);
        border-color: rgba(230, 198, 138, 0.3);
    }

    .room-type-tab.active {
        background: var(--gradient-accent);
        color: var(--text-dark);
        border-color: var(--accent);
        font-weight: 600;
    }

    /* Modern Room Card */
    .modern-room-card {
        background: linear-gradient(145deg, rgba(17, 34, 64, 0.8) 0%, rgba(10, 25, 47, 0.95) 100%);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .modern-room-card:hover {
        transform: translateY(-10px);
        border-color: rgba(230, 198, 138, 0.3);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.4),
                    0 0 40px rgba(230, 198, 138, 0.1);
    }

    .modern-room-card .room-image-container {
        position: relative;
        height: 220px;
        overflow: hidden;
    }

    .modern-room-card .room-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .modern-room-card:hover .room-image {
        transform: scale(1.08);
    }

    .modern-room-card .room-image-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 60%;
        background: linear-gradient(to top, rgba(10, 25, 47, 1) 0%, transparent 100%);
    }

    .modern-room-card .room-status {
        position: absolute;
        top: 16px;
        right: 16px;
        padding: 8px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .modern-room-card .room-status.available {
        background: rgba(100, 255, 218, 0.2);
        color: var(--teal);
        backdrop-filter: blur(10px);
    }

    .modern-room-card .room-status.occupied {
        background: rgba(255, 193, 7, 0.2);
        color: #ffc107;
        backdrop-filter: blur(10px);
    }

    .modern-room-card .room-favorite {
        position: absolute;
        top: 16px;
        left: 16px;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: none;
        border-radius: 50%;
        color: var(--text-highlight);
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modern-room-card .room-favorite:hover {
        background: rgba(230, 198, 138, 0.3);
        color: var(--accent);
        transform: scale(1.1);
    }

    .modern-room-card .room-body {
        padding: 24px;
    }

    .modern-room-card .room-type-badge {
        display: inline-block;
        padding: 4px 12px;
        background: rgba(230, 198, 138, 0.15);
        color: var(--accent);
        border-radius: 50px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }

    .modern-room-card .room-title {
        font-size: 1.4rem;
        font-weight: 600;
        color: var(--text-highlight);
        margin-bottom: 8px;
    }

    .modern-room-card .room-meta {
        display: flex;
        gap: 16px;
        color: var(--text-secondary);
        font-size: 0.85rem;
        margin-bottom: 16px;
    }

    .modern-room-card .room-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .modern-room-card .room-meta i {
        color: var(--accent);
    }

    .modern-room-card .room-amenities {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 20px;
    }

    .modern-room-card .amenity-icon {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 10px;
        color: var(--accent);
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .modern-room-card .amenity-icon:hover {
        background: rgba(230, 198, 138, 0.15);
        transform: translateY(-2px);
    }

    .modern-room-card .amenity-more {
        background: rgba(230, 198, 138, 0.1);
        color: var(--accent);
        font-size: 0.75rem;
        font-weight: 600;
    }

    .modern-room-card .room-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid rgba(230, 198, 138, 0.1);
    }

    .modern-room-card .room-price {
        display: flex;
        flex-direction: column;
    }

    .modern-room-card .price-amount {
        font-size: 1.5rem;
        font-weight: 700;
        background: var(--gradient-accent);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .modern-room-card .price-period {
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    .modern-room-card .btn-book {
        padding: 12px 28px;
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

    .modern-room-card .btn-book:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(230, 198, 138, 0.4);
        color: var(--text-dark);
    }

    /* Filters Panel */
    .filters-panel {
        background: linear-gradient(145deg, rgba(17, 34, 64, 0.9) 0%, rgba(10, 25, 47, 0.95) 100%);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 20px;
        padding: 28px;
    }

    .filters-panel .filter-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-highlight);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .filters-panel .filter-title i {
        color: var(--accent);
    }

    .filter-section {
        margin-bottom: 24px;
        padding-bottom: 24px;
        border-bottom: 1px solid rgba(230, 198, 138, 0.1);
    }

    .filter-section:last-child {
        margin-bottom: 0;
        padding-bottom: 0;
        border-bottom: none;
    }

    .filter-section .filter-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--accent);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }

    /* Custom Checkbox */
    .custom-checkbox {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 14px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid transparent;
        border-radius: 10px;
        margin-bottom: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-checkbox:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(230, 198, 138, 0.2);
    }

    .custom-checkbox input[type="checkbox"] {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        border: 2px solid rgba(230, 198, 138, 0.3);
        background: transparent;
        appearance: none;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .custom-checkbox input[type="checkbox"]:checked {
        background: var(--gradient-accent);
        border-color: var(--accent);
    }

    .custom-checkbox input[type="checkbox"]:checked::after {
        content: '✓';
        display: block;
        text-align: center;
        color: var(--text-dark);
        font-size: 0.75rem;
        font-weight: bold;
    }

    .custom-checkbox .checkbox-label {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 8px;
        color: var(--text-secondary);
        font-size: 0.9rem;
    }

    .custom-checkbox .checkbox-label i {
        color: var(--accent);
        font-size: 1rem;
    }

    /* Price Input */
    .price-input-group {
        display: flex;
        gap: 12px;
    }

    .price-input {
        flex: 1;
        position: relative;
    }

    .price-input input {
        width: 100%;
        padding: 12px 16px;
        padding-left: 36px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(230, 198, 138, 0.2);
        border-radius: 12px;
        color: var(--text-highlight);
        font-size: 0.9rem;
    }

    .price-input input:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(230, 198, 138, 0.1);
    }

    .price-input span {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--accent);
        font-size: 0.85rem;
    }

    /* View Toggle */
    .view-toggle {
        display: flex;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 4px;
    }

    .view-toggle button {
        padding: 8px 16px;
        background: transparent;
        border: none;
        color: var(--text-secondary);
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .view-toggle button.active {
        background: var(--accent);
        color: var(--text-dark);
    }

    /* Results Info Bar */
    .results-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 24px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 16px;
        margin-bottom: 24px;
    }

    .results-count {
        font-size: 0.95rem;
        color: var(--text-secondary);
    }

    .results-count strong {
        color: var(--accent);
        font-weight: 700;
    }

    /* Modern Pagination */
    .modern-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 8px;
        margin-top: 48px;
    }

    .modern-pagination .page-btn {
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(230, 198, 138, 0.15);
        border-radius: 12px;
        color: var(--text-secondary);
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .modern-pagination .page-btn:hover:not(.disabled) {
        background: rgba(230, 198, 138, 0.15);
        border-color: var(--accent);
        color: var(--accent);
        transform: translateY(-2px);
    }

    .modern-pagination .page-btn.active {
        background: var(--gradient-accent);
        border-color: var(--accent);
        color: var(--text-dark);
        font-weight: 700;
    }

    .modern-pagination .page-btn.disabled {
        opacity: 0.4;
        cursor: not-allowed;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 40px;
        background: rgba(255, 255, 255, 0.02);
        border: 1px dashed rgba(230, 198, 138, 0.2);
        border-radius: 24px;
    }

    .empty-state i {
        font-size: 4rem;
        color: rgba(230, 198, 138, 0.3);
        margin-bottom: 24px;
    }

    .empty-state h4 {
        color: var(--text-highlight);
        margin-bottom: 12px;
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 24px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .filters-panel {
            margin-bottom: 24px;
        }
    }

    @media (max-width: 768px) {
        .modern-room-card .room-image-container {
            height: 180px;
        }

        .room-type-tabs {
            overflow-x: auto;
            flex-wrap: nowrap;
            padding-bottom: 10px;
        }

        .room-type-tab {
            white-space: nowrap;
        }
    }
</style>
@endpush

@section('content')
<div style="padding-top: 100px;">
    <!-- Hero Banner -->
    <section class="rooms-hero">
        <div class="container position-relative">
            <div class="row align-items-center">
                <div class="col-lg-7">
                    <p class="text-accent mb-2 text-uppercase" style="letter-spacing: 3px; font-size: 0.85rem;">Accommodations</p>
                    <h1 class="mb-3" style="font-size: 3rem;">Discover Your <span class="text-accent">Perfect Stay</span></h1>
                    <p class="text-secondary mb-0" style="font-size: 1.1rem; max-width: 500px;">
                        Explore our collection of luxurious rooms and suites, each designed for ultimate comfort and elegance.
                    </p>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="quick-stat-card">
                                <i class="bi bi-door-open d-block"></i>
                                <div class="stat-value">{{ $rooms->total() ?? $rooms->count() }}</div>
                                <div class="stat-label">Rooms</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="quick-stat-card">
                                <i class="bi bi-tags d-block"></i>
                                <div class="stat-value">{{ $roomTypes->count() }}</div>
                                <div class="stat-label">Room Types</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Room Type Quick Tabs -->
    <section class="py-4" style="background: var(--primary);">
        <div class="container">
            <div class="room-type-tabs">
                <a href="{{ route('rooms.index') }}" class="room-type-tab {{ !request('room_type') ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap me-2"></i>All Rooms
                </a>
                @foreach($roomTypes as $type)
                <a href="{{ route('rooms.index', ['room_type' => $type->id]) }}" 
                   class="room-type-tab {{ request('room_type') == $type->id ? 'active' : '' }}">
                    {{ $type->name }}
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="section" style="background: var(--bg-dark);">
        <div class="container">
            <div class="row">
                <!-- Filters Sidebar -->
                <div class="col-lg-3 mb-4">
                    <div class="filters-panel sticky-top" style="top: 100px;">
                        <div class="filter-title">
                            <i class="bi bi-funnel"></i>
                            Filter Rooms
                        </div>
                        
                        <form action="{{ route('rooms.index') }}" method="GET" id="filterForm">
                            @if(request('room_type'))
                            <input type="hidden" name="room_type" value="{{ request('room_type') }}">
                            @endif

                            <!-- Price Range -->
                            <div class="filter-section">
                                <div class="filter-label">Price Range (per night)</div>
                                <div class="price-input-group">
                                    <div class="price-input">
                                        <span>Rp</span>
                                        <input type="number" name="price_min" placeholder="Min" value="{{ request('price_min') }}">
                                    </div>
                                    <div class="price-input">
                                        <span>Rp</span>
                                        <input type="number" name="price_max" placeholder="Max" value="{{ request('price_max') }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Amenities -->
                            <div class="filter-section">
                                <div class="filter-label">Amenities</div>
                                @foreach($amenities->take(8) as $amenity)
                                <label class="custom-checkbox">
                                    <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}"
                                        {{ in_array($amenity->id, (array) request('amenities', [])) ? 'checked' : '' }}>
                                    <span class="checkbox-label">
                                        <i class="{{ $amenity->icon }}"></i>
                                        {{ $amenity->name }}
                                    </span>
                                </label>
                                @endforeach
                            </div>

                            <!-- Action Buttons -->
                            <button type="submit" class="btn btn-gold w-100 mb-3">
                                <i class="bi bi-check2-circle me-2"></i>Apply Filters
                            </button>
                            <a href="{{ route('rooms.index') }}" class="btn btn-outline-gold w-100">
                                <i class="bi bi-x-circle me-2"></i>Clear All
                            </a>
                        </form>
                    </div>
                </div>

                <!-- Rooms Grid -->
                <div class="col-lg-9">
                    <!-- Results Bar -->
                    <div class="results-bar">
                        <div class="results-count">
                            Showing <strong>{{ $rooms->count() }}</strong> of <strong>{{ $rooms->total() ?? $rooms->count() }}</strong> rooms
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <select class="form-select form-select-sm" style="width: auto; background: rgba(255,255,255,0.05); border-color: rgba(230, 198, 138, 0.2); color: var(--text-highlight);" onchange="window.location.href=this.value">
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_asc']) }}" {{ request('sort', 'price_asc') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'price_desc']) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="{{ request()->fullUrlWithQuery(['sort' => 'type']) }}" {{ request('sort') == 'type' ? 'selected' : '' }}>Room Type</option>
                            </select>
                        </div>
                    </div>

                    <!-- Rooms Grid -->
                    <div class="row g-4">
                        @forelse($rooms as $room)
                        <div class="col-lg-6 col-md-6">
                            <div class="modern-room-card h-100">
                                <div class="room-image-container">
                                    @php
                                        $images = [
                                            'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=600',
                                            'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=600',
                                            'https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=600',
                                            'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=600',
                                        ];
                                    @endphp
                                    <img src="{{ $images[array_rand($images)] }}" alt="{{ $room->roomType->name }}" class="room-image">
                                    <div class="room-image-overlay"></div>
                                    
                                    @if($room->status == 'available')
                                    <span class="room-status available">Available</span>
                                    @else
                                    <span class="room-status occupied">{{ ucfirst($room->status) }}</span>
                                    @endif
                                    
                                    <button class="room-favorite" type="button" title="Add to wishlist">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>
                                
                                <div class="room-body">
                                    <span class="room-type-badge">{{ $room->roomType->name }}</span>
                                    
                                    <h4 class="room-title">Room {{ $room->room_number }}</h4>
                                    
                                    <div class="room-meta">
                                        <span><i class="bi bi-people-fill"></i> {{ $room->roomType->capacity }} Guests</span>
                                        <span><i class="bi bi-aspect-ratio"></i> {{ $room->roomType->size_sqm ?? '25' }} m²</span>
                                        <span><i class="bi bi-layers"></i> Floor {{ $room->floor }}</span>
                                    </div>
                                    
                                    <div class="room-amenities">
                                        @foreach($room->amenities->take(4) as $amenity)
                                        <div class="amenity-icon" title="{{ $amenity->name }}">
                                            <i class="{{ $amenity->icon }}"></i>
                                        </div>
                                        @endforeach
                                        @if($room->amenities->count() > 4)
                                        <div class="amenity-icon amenity-more">+{{ $room->amenities->count() - 4 }}</div>
                                        @endif
                                    </div>
                                    
                                    <div class="room-footer">
                                        <div class="room-price">
                                            <span class="price-amount">{{ $room->formatted_price }}</span>
                                            <span class="price-period">per night</span>
                                        </div>
                                        <a href="{{ route('rooms.show', $room) }}" class="btn-book">View Room</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="empty-state">
                                <i class="bi bi-search d-block"></i>
                                <h4>No Rooms Found</h4>
                                <p>We couldn't find any rooms matching your criteria. Try adjusting your filters.</p>
                                <a href="{{ route('rooms.index') }}" class="btn btn-gold">
                                    <i class="bi bi-arrow-counterclockwise me-2"></i>Clear Filters
                                </a>
                            </div>
                        </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($rooms->hasPages())
                    <div class="modern-pagination">
                        {{-- Previous Button --}}
                        @if($rooms->onFirstPage())
                            <span class="page-btn disabled"><i class="bi bi-chevron-left"></i></span>
                        @else
                            <a href="{{ $rooms->previousPageUrl() }}" class="page-btn"><i class="bi bi-chevron-left"></i></a>
                        @endif

                        {{-- Page Numbers --}}
                        @foreach($rooms->getUrlRange(1, $rooms->lastPage()) as $page => $url)
                            @if($page == $rooms->currentPage())
                                <span class="page-btn active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next Button --}}
                        @if($rooms->hasMorePages())
                            <a href="{{ $rooms->nextPageUrl() }}" class="page-btn"><i class="bi bi-chevron-right"></i></a>
                        @else
                            <span class="page-btn disabled"><i class="bi bi-chevron-right"></i></span>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
