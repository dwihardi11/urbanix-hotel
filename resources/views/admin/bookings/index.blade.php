@extends('layouts.admin')

@section('title', 'Bookings')
@section('header', 'Booking Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.bookings.index') }}" class="btn {{ !request('status') ? 'btn-gold' : '' }}" style="{{ request('status') ? 'background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);' : '' }}">
            All
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="btn" style="{{ request('status') == 'pending' ? 'background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.5);' : 'background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);' }}">
            <i class="bi bi-hourglass-split me-1"></i>Pending
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}" class="btn" style="{{ request('status') == 'confirmed' ? 'background: rgba(100, 255, 218, 0.2); color: var(--teal); border: 1px solid rgba(100, 255, 218, 0.5);' : 'background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);' }}">
            <i class="bi bi-check-circle me-1"></i>Confirmed
        </a>
        <a href="{{ route('admin.bookings.index', ['status' => 'checked_in']) }}" class="btn" style="{{ request('status') == 'checked_in' ? 'background: rgba(13, 110, 253, 0.2); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.5);' : 'background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);' }}">
            <i class="bi bi-box-arrow-in-right me-1"></i>Checked In
        </a>
    </div>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-circle me-2"></i>New Booking
    </a>
</div>

<!-- Search -->
<div class="glass-card mb-4">
    <form action="{{ route('admin.bookings.index') }}" method="GET" class="row g-3">
        <div class="col-md-4">
            <label class="form-label text-secondary small">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Code, name, or phone..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label text-secondary small">From Date</label>
            <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
        </div>
        <div class="col-md-2">
            <label class="form-label text-secondary small">To Date</label>
            <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-gold w-100"><i class="bi bi-search me-2"></i>Search</button>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-gold w-100">Clear</a>
        </div>
    </form>
</div>

<!-- Bookings Table -->
<div class="glass-card">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Booking Code</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking) }}" class="text-accent text-decoration-none fw-medium">
                            {{ $booking->booking_code }}
                        </a>
                    </td>
                    <td>
                        <div class="fw-medium">{{ $booking->guest->name }}</div>
                        <small class="text-secondary">{{ $booking->guest->phone }}</small>
                    </td>
                    <td>
                        <div class="fw-medium">{{ $booking->room->room_number }}</div>
                        <small class="text-secondary">{{ $booking->room->roomType->name }}</small>
                    </td>
                    <td>{{ $booking->check_in->format('d M Y') }}</td>
                    <td>{{ $booking->check_out->format('d M Y') }}</td>
                    <td class="fw-medium" style="color: var(--accent);">{{ $booking->formatted_price }}</td>
                    <td>
                        @php
                            $statusStyles = [
                                'pending' => 'background: rgba(255, 193, 7, 0.2); color: #ffc107;',
                                'confirmed' => 'background: rgba(100, 255, 218, 0.2); color: var(--teal);',
                                'checked_in' => 'background: rgba(13, 110, 253, 0.2); color: #0d6efd;',
                                'checked_out' => 'background: rgba(108, 117, 125, 0.2); color: #6c757d;',
                                'cancelled' => 'background: rgba(220, 53, 69, 0.2); color: #dc3545;',
                            ];
                            $paymentStyles = [
                                'pending' => 'background: rgba(255, 193, 7, 0.15); color: #ffc107;',
                                'paid' => 'background: rgba(100, 255, 218, 0.15); color: var(--teal);',
                                'refunded' => 'background: rgba(108, 117, 125, 0.15); color: #6c757d;',
                            ];
                        @endphp
                        <span class="badge d-block mb-1" style="{{ $statusStyles[$booking->status] ?? '' }}">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                        <span class="badge" style="{{ $paymentStyles[$booking->payment_status] ?? '' }}">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-gold" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($booking->status == 'pending')
                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm" style="background: rgba(100, 255, 218, 0.2); color: var(--teal); border: 1px solid rgba(100, 255, 218, 0.3);" title="Confirm">
                                    <i class="bi bi-check-lg"></i>
                                </button>
                            </form>
                            @elseif($booking->status == 'confirmed')
                            <form action="{{ route('admin.bookings.checkIn', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm" style="background: rgba(13, 110, 253, 0.2); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.3);" title="Check In">
                                    <i class="bi bi-box-arrow-in-right"></i>
                                </button>
                            </form>
                            @elseif($booking->status == 'checked_in')
                            <form action="{{ route('admin.bookings.checkOut', $booking) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.3);" title="Check Out">
                                    <i class="bi bi-box-arrow-right"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-secondary py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        No bookings found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($bookings->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
