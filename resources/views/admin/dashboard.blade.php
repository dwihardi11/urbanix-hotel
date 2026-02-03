@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header', 'Dashboard Overview')

@section('content')
<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Total Bookings</p>
                    <h3>{{ $stats['total_bookings'] }}</h3>
                </div>
                <div class="icon"><i class="bi bi-calendar-check"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Pending Bookings</p>
                    <h3>{{ $stats['pending_bookings'] }}</h3>
                </div>
                <div class="icon"><i class="bi bi-hourglass-split"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Occupancy Rate</p>
                    <h3>{{ $stats['occupancy_rate'] }}%</h3>
                </div>
                <div class="icon"><i class="bi bi-pie-chart"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <p>Monthly Revenue</p>
                    <h3>Rp {{ number_format($stats['monthly_revenue'] / 1000000, 1) }}M</h3>
                </div>
                <div class="icon"><i class="bi bi-currency-dollar"></i></div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Today's Activity -->
    <div class="col-lg-4">
        <div class="glass-card h-100">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-activity me-2"></i>Today's Activity</h5>
            
            <div class="d-flex justify-content-between align-items-center mb-4 pb-4" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3" style="background: rgba(100, 255, 218, 0.15);">
                        <i class="bi bi-box-arrow-in-right" style="color: var(--teal); font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-medium">Check-ins</p>
                        <small class="text-secondary">Expected today</small>
                    </div>
                </div>
                <h3 class="mb-0" style="color: var(--teal);">{{ $stats['today_checkins'] }}</h3>
            </div>

            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <div class="rounded-3 p-3 me-3" style="background: rgba(255, 193, 7, 0.15);">
                        <i class="bi bi-box-arrow-right text-warning" style="font-size: 1.25rem;"></i>
                    </div>
                    <div>
                        <p class="mb-0 fw-medium">Check-outs</p>
                        <small class="text-secondary">Expected today</small>
                    </div>
                </div>
                <h3 class="mb-0 text-warning">{{ $stats['today_checkouts'] }}</h3>
            </div>
        </div>
    </div>

    <!-- Room Status -->
    <div class="col-lg-4">
        <div class="glass-card h-100">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-door-open me-2"></i>Room Status</h5>
            
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.05);">
                <span class="d-flex align-items-center">
                    <i class="bi bi-check-circle me-2" style="color: var(--teal);"></i>Available
                </span>
                <span class="badge badge-teal">{{ $stats['available_rooms'] }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.05);">
                <span class="d-flex align-items-center">
                    <i class="bi bi-person-fill me-2 text-primary"></i>Occupied
                </span>
                <span class="badge" style="background: rgba(13, 110, 253, 0.2); color: #0d6efd;">{{ $stats['total_rooms'] - $stats['available_rooms'] }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <span class="d-flex align-items-center">
                    <i class="bi bi-building me-2 text-secondary"></i>Total Rooms
                </span>
                <span class="badge" style="background: rgba(255, 255, 255, 0.1); color: var(--text-secondary);">{{ $stats['total_rooms'] }}</span>
            </div>

            <div class="mt-4 pt-3">
                <div class="d-flex justify-content-between mb-2">
                    <small class="text-secondary">Occupancy</small>
                    <small style="color: var(--accent);">{{ $stats['total_rooms'] > 0 ? round(($stats['total_rooms'] - $stats['available_rooms']) / $stats['total_rooms'] * 100) : 0 }}%</small>
                </div>
                <div class="progress" style="height: 8px; background: rgba(255,255,255,0.05); border-radius: 4px;">
                    <div class="progress-bar" style="width: {{ $stats['total_rooms'] > 0 ? (($stats['total_rooms'] - $stats['available_rooms']) / $stats['total_rooms'] * 100) : 0 }}%; background: linear-gradient(90deg, var(--accent), var(--teal)); border-radius: 4px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-4">
        <div class="glass-card h-100">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-lightning me-2"></i>Quick Actions</h5>
            
            <div class="d-grid gap-3">
                <a href="{{ route('admin.bookings.create') }}" class="btn btn-gold py-3">
                    <i class="bi bi-plus-circle me-2"></i>New Booking
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="btn btn-outline-gold py-3">
                    <i class="bi bi-hourglass-split me-2"></i>Pending Bookings
                    @if($stats['pending_bookings'] > 0)
                    <span class="badge ms-2" style="background: rgba(255, 193, 7, 0.3); color: #ffc107;">{{ $stats['pending_bookings'] }}</span>
                    @endif
                </a>
                <a href="{{ route('admin.rooms.create') }}" class="btn py-3" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
                    <i class="bi bi-door-open me-2"></i>Add Room
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Recent Bookings -->
<div class="glass-card mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0" style="color: var(--accent);"><i class="bi bi-clock-history me-2"></i>Recent Bookings</h5>
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-gold">View All</a>
    </div>
    
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Booking Code</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentBookings as $booking)
                <tr>
                    <td><a href="{{ route('admin.bookings.show', $booking) }}" class="text-accent text-decoration-none fw-medium">{{ $booking->booking_code }}</a></td>
                    <td>{{ $booking->guest->name }}</td>
                    <td>
                        <span class="text-secondary">{{ $booking->room->room_number }}</span> - 
                        <span>{{ $booking->room->roomType->name }}</span>
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
                        <span class="badge" style="{{ $statusStyles[$booking->status] ?? 'background: rgba(230, 198, 138, 0.2); color: var(--accent);' }}">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </td>
                    <td class="fw-medium" style="color: var(--accent);">{{ $booking->formatted_price }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-secondary py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        No bookings yet
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
