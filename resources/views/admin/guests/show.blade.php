@extends('layouts.admin')

@section('title', 'Guest Details')
@section('header', 'Guest Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.guests.index') }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
        <i class="bi bi-arrow-left me-2"></i>Back to Guests
    </a>
    <a href="{{ route('admin.guests.edit', $guest) }}" class="btn btn-outline-gold">
        <i class="bi bi-pencil me-2"></i>Edit Guest
    </a>
</div>

@if(session('success'))
<div class="alert" style="background: rgba(100, 255, 218, 0.1); border: 1px solid rgba(100, 255, 218, 0.3); color: var(--teal);">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <!-- Guest Info -->
        <div class="glass-card mb-4">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="mb-1" style="color: var(--accent);">{{ $guest->name }}</h4>
                    <span class="text-secondary">Guest since {{ $guest->created_at->format('M Y') }}</span>
                </div>
                <div class="text-center" style="padding: 15px 25px; background: rgba(230, 198, 138, 0.1); border-radius: 12px;">
                    <div class="fs-3 fw-bold" style="color: var(--accent);">{{ $guest->bookings_count ?? $guest->bookings->count() }}</div>
                    <small class="text-secondary">Bookings</small>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-secondary mb-3"><i class="bi bi-person me-2"></i>Contact Information</h6>
                    <div class="mb-3">
                        <small class="text-secondary d-block">Email</small>
                        <span class="fw-medium">{{ $guest->email ?? '-' }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-secondary d-block">Phone</small>
                        <span class="fw-medium">{{ $guest->phone }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-secondary mb-3"><i class="bi bi-card-text me-2"></i>Identification</h6>
                    <div class="mb-3">
                        <small class="text-secondary d-block">ID Type</small>
                        <span class="fw-medium text-uppercase">{{ $guest->id_type }}</span>
                    </div>
                    <div>
                        <small class="text-secondary d-block">ID Number</small>
                        <span class="fw-medium">{{ $guest->id_number }}</span>
                    </div>
                </div>
            </div>
            
            @if($guest->address || $guest->city || $guest->country)
            <div class="mt-4 pt-4" style="border-top: 1px solid rgba(230, 198, 138, 0.1);">
                <h6 class="text-secondary mb-3"><i class="bi bi-geo-alt me-2"></i>Address</h6>
                <p class="mb-0">
                    @if($guest->address){{ $guest->address }}<br>@endif
                    {{ $guest->city }}{{ $guest->city && $guest->country ? ', ' : '' }}{{ $guest->country }}
                </p>
            </div>
            @endif
        </div>
        
        <!-- Recent Bookings -->
        <div class="glass-card">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-calendar3 me-2"></i>Recent Bookings</h5>
            
            @if($guest->bookings && count($guest->bookings) > 0)
            <div class="table-responsive">
                <table class="table table-dark-custom mb-0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Room</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guest->bookings as $booking)
                        <tr>
                            <td>
                                <a href="{{ route('admin.bookings.show', $booking) }}" class="text-accent text-decoration-none">
                                    {{ $booking->booking_code }}
                                </a>
                            </td>
                            <td>
                                {{ $booking->room->room_number ?? 'N/A' }}
                                <small class="d-block text-secondary">{{ $booking->room->roomType->name ?? '' }}</small>
                            </td>
                            <td>{{ $booking->check_in->format('d M Y') }}</td>
                            <td>{{ $booking->check_out->format('d M Y') }}</td>
                            <td>
                                @php
                                    $statusStyles = [
                                        'pending' => 'background: rgba(255, 193, 7, 0.2); color: #ffc107;',
                                        'confirmed' => 'background: rgba(100, 255, 218, 0.2); color: var(--teal);',
                                        'checked_in' => 'background: rgba(13, 110, 253, 0.2); color: #0d6efd;',
                                        'checked_out' => 'background: rgba(108, 117, 125, 0.2); color: #6c757d;',
                                        'cancelled' => 'background: rgba(220, 53, 69, 0.2); color: #dc3545;',
                                    ];
                                @endphp
                                <span class="badge" style="{{ $statusStyles[$booking->status] ?? '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td>
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
            <div class="text-center text-secondary py-4">
                <i class="bi bi-calendar-x fs-1 d-block mb-3"></i>
                No bookings found for this guest
            </div>
            @endif
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        <div class="glass-card position-sticky" style="top: 100px;">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-lightning me-2"></i>Quick Actions</h5>
            
            <a href="{{ route('admin.bookings.create') }}?guest={{ $guest->id }}" class="btn btn-gold w-100 mb-2">
                <i class="bi bi-plus-circle me-2"></i>New Booking
            </a>
            
            <a href="{{ route('admin.guests.edit', $guest) }}" class="btn btn-outline-gold w-100 mb-4">
                <i class="bi bi-pencil me-2"></i>Edit Guest
            </a>
            
            <h6 class="text-secondary mb-3">Guest Stats</h6>
            <div class="mb-2 d-flex justify-content-between">
                <span class="text-secondary">Total Bookings</span>
                <span class="fw-medium">{{ $guest->bookings_count ?? $guest->bookings->count() }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-secondary">Member Since</span>
                <span class="fw-medium">{{ $guest->created_at->format('d M Y') }}</span>
            </div>
        </div>
    </div>
</div>
@endsection
