@extends('layouts.admin')

@section('title', 'Room Details')
@section('header', 'Room Details')

@push('styles')
<style>
    .room-hero {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        height: 280px;
        background: linear-gradient(135deg, rgba(230, 198, 138, 0.1) 0%, rgba(10, 25, 47, 0.9) 100%);
    }
    
    .room-hero-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.6;
    }
    
    .room-hero-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 30px;
        background: linear-gradient(to top, rgba(10, 25, 47, 0.95) 0%, transparent 100%);
    }
    
    .room-number-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        font-size: 1.75rem;
        font-weight: 700;
        border-radius: 16px;
        background: linear-gradient(135deg, var(--accent) 0%, #C9A962 100%);
        color: var(--primary);
        box-shadow: 0 8px 32px rgba(230, 198, 138, 0.3);
    }
    
    .info-card {
        background: rgba(255, 255, 255, 0.02);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }
    
    .info-card:hover {
        background: rgba(255, 255, 255, 0.04);
        border-color: rgba(230, 198, 138, 0.2);
    }
    
    .info-card-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        border-radius: 12px;
        font-size: 1.25rem;
    }
    
    .info-card-value {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 4px;
    }
    
    .info-card-label {
        font-size: 0.8rem;
        color: var(--text-secondary);
    }
    
    .amenity-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(230, 198, 138, 0.1);
        border-radius: 8px;
        font-size: 0.875rem;
        transition: all 0.2s ease;
    }
    
    .amenity-badge:hover {
        background: rgba(230, 198, 138, 0.1);
        border-color: rgba(230, 198, 138, 0.3);
    }
    
    .amenity-badge i {
        color: var(--accent);
        font-size: 1rem;
    }
    
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }
    
    .image-gallery-item {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 4/3;
    }
    
    .image-gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .image-gallery-item:hover img {
        transform: scale(1.05);
    }
    
    .status-indicator {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 12px;
    }
    
    .status-indicator.available {
        background: rgba(100, 255, 218, 0.1);
        border: 1px solid rgba(100, 255, 218, 0.3);
    }
    
    .status-indicator.occupied {
        background: rgba(13, 110, 253, 0.1);
        border: 1px solid rgba(13, 110, 253, 0.3);
    }
    
    .status-indicator.maintenance {
        background: rgba(255, 193, 7, 0.1);
        border: 1px solid rgba(255, 193, 7, 0.3);
    }
    
    .quick-stat {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid rgba(230, 198, 138, 0.08);
    }
    
    .quick-stat:last-child {
        border-bottom: none;
    }
</style>
@endpush

@section('content')
<!-- Header Actions -->
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.rooms.index') }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
        <i class="bi bi-arrow-left me-2"></i>Back to Rooms
    </a>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-outline-gold">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="{{ route('admin.bookings.create') }}?room={{ $room->id }}" class="btn btn-gold">
            <i class="bi bi-plus-circle me-2"></i>New Booking
        </a>
    </div>
</div>

@if(session('success'))
<div class="alert" style="background: rgba(100, 255, 218, 0.1); border: 1px solid rgba(100, 255, 218, 0.3); color: var(--teal);">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <!-- Room Hero -->
        <div class="glass-card mb-4 p-0 overflow-hidden">
            <div class="room-hero">
                @if($room->images && count($room->images) > 0)
                    <img src="{{ asset('storage/' . $room->images[0]) }}" alt="Room {{ $room->room_number }}" class="room-hero-image">
                @endif
                <div class="room-hero-overlay">
                    <div class="d-flex align-items-end gap-4">
                        <div class="room-number-badge">{{ $room->room_number }}</div>
                        <div>
                            <h3 class="mb-1" style="color: var(--text-primary);">{{ $room->roomType->name }}</h3>
                            <p class="mb-0 text-secondary">
                                <i class="bi bi-building me-1"></i>{{ $room->hotel->name ?? 'Main Hotel' }}
                                @if($room->floor)
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-layers me-1"></i>Floor {{ $room->floor }}
                                @endif
                            </p>
                        </div>
                        <div class="ms-auto d-flex gap-2">
                            @php
                                $statusColors = [
                                    'available' => ['bg' => 'rgba(100, 255, 218, 0.2)', 'color' => 'var(--teal)'],
                                    'occupied' => ['bg' => 'rgba(13, 110, 253, 0.2)', 'color' => '#0d6efd'],
                                    'maintenance' => ['bg' => 'rgba(255, 193, 7, 0.2)', 'color' => '#ffc107'],
                                ];
                                $statusStyle = $statusColors[$room->status] ?? $statusColors['available'];
                            @endphp
                            <span class="badge px-3 py-2" style="background: {{ $statusStyle['bg'] }}; color: {{ $statusStyle['color'] }}; font-size: 0.9rem;">
                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>{{ ucfirst($room->status) }}
                            </span>
                            @if($room->is_active)
                            <span class="badge px-3 py-2" style="background: rgba(100, 255, 218, 0.15); color: var(--teal); font-size: 0.9rem;">Active</span>
                            @else
                            <span class="badge px-3 py-2" style="background: rgba(220, 53, 69, 0.15); color: #dc3545; font-size: 0.9rem;">Inactive</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Room Info Cards -->
        <div class="row g-3 mb-4">
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="info-card-icon" style="background: rgba(230, 198, 138, 0.15);">
                        <i class="bi bi-currency-dollar" style="color: var(--accent);"></i>
                    </div>
                    <div class="info-card-value" style="color: var(--accent);">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</div>
                    <div class="info-card-label">per night</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="info-card-icon" style="background: rgba(100, 255, 218, 0.15);">
                        <i class="bi bi-people" style="color: var(--teal);"></i>
                    </div>
                    <div class="info-card-value">{{ $room->roomType->capacity ?? 2 }}</div>
                    <div class="info-card-label">Max Guests</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="info-card-icon" style="background: rgba(13, 110, 253, 0.15);">
                        <i class="bi bi-arrows-fullscreen" style="color: #0d6efd;"></i>
                    </div>
                    <div class="info-card-value">{{ $room->roomType->size_sqm ?? '-' }} m²</div>
                    <div class="info-card-label">Room Size</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="info-card">
                    <div class="info-card-icon" style="background: rgba(255, 193, 7, 0.15);">
                        <i class="bi bi-bed" style="color: #ffc107;"></i>
                    </div>
                    <div class="info-card-value">{{ $room->roomType->bed_type ?? '-' }}</div>
                    <div class="info-card-label">Bed Type</div>
                </div>
            </div>
        </div>
        
        <!-- Description -->
        @if($room->description || $room->roomType->description)
        <div class="glass-card mb-4">
            <h5 class="mb-3" style="color: var(--accent);"><i class="bi bi-text-paragraph me-2"></i>Description</h5>
            <p class="mb-0 text-secondary" style="line-height: 1.7;">
                {{ $room->description ?? $room->roomType->description }}
            </p>
        </div>
        @endif
        
        <!-- Amenities -->
        @if($room->amenities && count($room->amenities) > 0)
        <div class="glass-card mb-4">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-stars me-2"></i>Amenities</h5>
            <div class="d-flex flex-wrap gap-2">
                @foreach($room->amenities as $amenity)
                <div class="amenity-badge">
                    @if($amenity->icon)
                    <i class="{{ $amenity->icon }}"></i>
                    @else
                    <i class="bi bi-check2-circle"></i>
                    @endif
                    <span>{{ $amenity->name }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Room Images Gallery -->
        @if($room->images && count($room->images) > 1)
        <div class="glass-card mb-4">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-images me-2"></i>Gallery</h5>
            <div class="image-gallery">
                @foreach($room->images as $index => $image)
                <div class="image-gallery-item">
                    <img src="{{ asset('storage/' . $image) }}" alt="Room image {{ $index + 1 }}">
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        <!-- Upcoming Bookings -->
        <div class="glass-card">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0" style="color: var(--accent);"><i class="bi bi-calendar3 me-2"></i>Upcoming Bookings</h5>
                @if($room->bookings && count($room->bookings) > 0)
                <span class="badge" style="background: rgba(230, 198, 138, 0.2); color: var(--accent);">
                    {{ count($room->bookings) }} bookings
                </span>
                @endif
            </div>
            
            @if($room->bookings && count($room->bookings) > 0)
            <div class="table-responsive">
                <table class="table table-dark-custom mb-0">
                    <thead>
                        <tr>
                            <th>Booking Code</th>
                            <th>Guest</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($room->bookings as $booking)
                        <tr>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-accent text-decoration-none fw-medium">
                                    {{ $booking->booking_code }}
                                </a>
                            </td>
                            <td>
                                <div class="fw-medium">{{ $booking->guest->name ?? 'N/A' }}</div>
                                <small class="text-secondary">{{ $booking->guest->phone ?? '' }}</small>
                            </td>
                            <td>
                                <div>{{ $booking->check_in->format('d M Y') }}</div>
                                <small class="text-secondary">{{ $booking->check_in->format('l') }}</small>
                            </td>
                            <td>
                                <div>{{ $booking->check_out->format('d M Y') }}</div>
                                <small class="text-secondary">{{ $booking->check_in->diffInDays($booking->check_out) }} nights</small>
                            </td>
                            <td>
                                @php
                                    $bookingStatuses = [
                                        'pending' => ['bg' => 'rgba(255, 193, 7, 0.2)', 'color' => '#ffc107'],
                                        'confirmed' => ['bg' => 'rgba(100, 255, 218, 0.2)', 'color' => 'var(--teal)'],
                                        'checked_in' => ['bg' => 'rgba(13, 110, 253, 0.2)', 'color' => '#0d6efd'],
                                    ];
                                    $bookingStyle = $bookingStatuses[$booking->status] ?? ['bg' => 'rgba(108, 117, 125, 0.2)', 'color' => '#6c757d'];
                                @endphp
                                <span class="badge" style="background: {{ $bookingStyle['bg'] }}; color: {{ $bookingStyle['color'] }};">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-gold">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-calendar-check fs-1 mb-3" style="color: rgba(230, 198, 138, 0.3);"></i>
                <p class="text-secondary mb-3">No upcoming bookings for this room</p>
                <a href="{{ route('admin.bookings.create') }}?room={{ $room->id }}" class="btn btn-gold btn-sm">
                    <i class="bi bi-plus-circle me-2"></i>Create Booking
                </a>
            </div>
            @endif
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Current Status -->
        <div class="glass-card mb-4">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-toggles me-2"></i>Room Status</h5>
            
            <div class="status-indicator {{ $room->status }}">
                @php
                    $statusIcons = [
                        'available' => 'bi-check-circle-fill',
                        'occupied' => 'bi-person-fill',
                        'maintenance' => 'bi-tools',
                    ];
                @endphp
                <i class="bi {{ $statusIcons[$room->status] ?? 'bi-circle' }}" style="font-size: 1.25rem; color: {{ $statusStyle['color'] }};"></i>
                <div>
                    <div class="fw-medium" style="color: {{ $statusStyle['color'] }};">{{ ucfirst($room->status) }}</div>
                    <small class="text-secondary">Current room status</small>
                </div>
            </div>
            
            <form action="{{ route('admin.rooms.update', $room) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="hotel_id" value="{{ $room->hotel_id }}">
                <input type="hidden" name="room_type_id" value="{{ $room->room_type_id }}">
                <input type="hidden" name="room_number" value="{{ $room->room_number }}">
                <input type="hidden" name="price_per_night" value="{{ $room->price_per_night }}">
                <input type="hidden" name="is_active" value="{{ $room->is_active }}">
                
                <label class="form-label text-secondary small">Change Status</label>
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>✓ Available</option>
                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>👤 Occupied</option>
                    <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>🔧 Maintenance</option>
                </select>
            </form>
        </div>
        
        <!-- Quick Stats -->
        <div class="glass-card mb-4">
            <h5 class="mb-3" style="color: var(--accent);"><i class="bi bi-graph-up me-2"></i>Statistics</h5>
            
            <div class="quick-stat">
                <span class="text-secondary">Total Bookings</span>
                <span class="fw-bold" style="color: var(--accent);">{{ $room->bookings_count ?? $room->bookings->count() }}</span>
            </div>
            <div class="quick-stat">
                <span class="text-secondary">Active Bookings</span>
                <span class="fw-medium">{{ $room->bookings->where('status', 'checked_in')->count() }}</span>
            </div>
            <div class="quick-stat">
                <span class="text-secondary">Upcoming</span>
                <span class="fw-medium">{{ $room->bookings->whereIn('status', ['pending', 'confirmed'])->count() }}</span>
            </div>
            <div class="quick-stat">
                <span class="text-secondary">Room Active</span>
                @if($room->is_active)
                <span class="badge" style="background: rgba(100, 255, 218, 0.2); color: var(--teal);">Yes</span>
                @else
                <span class="badge" style="background: rgba(220, 53, 69, 0.2); color: #dc3545;">No</span>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="glass-card">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-lightning me-2"></i>Quick Actions</h5>
            
            <a href="{{ route('admin.bookings.create') }}?room={{ $room->id }}" class="btn btn-gold w-100 mb-2">
                <i class="bi bi-plus-circle me-2"></i>Create Booking
            </a>
            
            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-outline-gold w-100 mb-2">
                <i class="bi bi-pencil me-2"></i>Edit Room
            </a>
            
            <a href="{{ route('admin.bookings.calendar') }}" class="btn w-100" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
                <i class="bi bi-calendar3 me-2"></i>View Calendar
            </a>
        </div>
    </div>
</div>
@endsection
