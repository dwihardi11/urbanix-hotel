@extends('layouts.admin')

@section('title', 'Booking Details')
@section('header', 'Booking Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.bookings.index') }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
        <i class="bi bi-arrow-left me-2"></i>Back to Bookings
    </a>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-outline-gold">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        @if($booking->status == 'pending')
        <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn" style="background: rgba(100, 255, 218, 0.2); color: var(--teal); border: 1px solid rgba(100, 255, 218, 0.3);">
                <i class="bi bi-check-circle me-2"></i>Confirm
            </button>
        </form>
        @elseif($booking->status == 'confirmed')
        <form action="{{ route('admin.bookings.checkIn', $booking) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn" style="background: rgba(13, 110, 253, 0.2); color: #0d6efd; border: 1px solid rgba(13, 110, 253, 0.3);">
                <i class="bi bi-box-arrow-in-right me-2"></i>Check In
            </button>
        </form>
        @elseif($booking->status == 'checked_in')
        <form action="{{ route('admin.bookings.checkOut', $booking) }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn" style="background: rgba(255, 193, 7, 0.2); color: #ffc107; border: 1px solid rgba(255, 193, 7, 0.3);">
                <i class="bi bi-box-arrow-right me-2"></i>Check Out
            </button>
        </form>
        @endif
    </div>
</div>

@if(session('success'))
<div class="alert" style="background: rgba(100, 255, 218, 0.1); border: 1px solid rgba(100, 255, 218, 0.3); color: var(--teal);">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <!-- Booking Information -->
        <div class="glass-card mb-4">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h4 class="mb-1" style="color: var(--accent);">{{ $booking->booking_code }}</h4>
                    <small class="text-secondary">Created {{ $booking->created_at->format('d M Y, H:i') }}</small>
                </div>
                <div class="text-end">
                    @php
                        $statusStyles = [
                            'pending' => 'background: rgba(255, 193, 7, 0.2); color: #ffc107;',
                            'confirmed' => 'background: rgba(100, 255, 218, 0.2); color: var(--teal);',
                            'checked_in' => 'background: rgba(13, 110, 253, 0.2); color: #0d6efd;',
                            'checked_out' => 'background: rgba(108, 117, 125, 0.2); color: #6c757d;',
                            'cancelled' => 'background: rgba(220, 53, 69, 0.2); color: #dc3545;',
                        ];
                        $paymentStyles = [
                            'unpaid' => 'background: rgba(220, 53, 69, 0.15); color: #dc3545;',
                            'partial' => 'background: rgba(255, 193, 7, 0.15); color: #ffc107;',
                            'paid' => 'background: rgba(100, 255, 218, 0.15); color: var(--teal);',
                        ];
                    @endphp
                    <span class="badge mb-1" style="{{ $statusStyles[$booking->status] ?? '' }}">
                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                    </span>
                    <br>
                    <span class="badge" style="{{ $paymentStyles[$booking->payment_status] ?? '' }}">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <h6 class="text-secondary mb-3"><i class="bi bi-calendar3 me-2"></i>Stay Details</h6>
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-secondary">Check-in</span>
                        <span class="fw-medium">{{ $booking->check_in->format('d M Y') }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-secondary">Check-out</span>
                        <span class="fw-medium">{{ $booking->check_out->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Duration</span>
                        <span class="fw-medium">{{ $booking->check_in->diffInDays($booking->check_out) }} nights</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6 class="text-secondary mb-3"><i class="bi bi-door-open me-2"></i>Room</h6>
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-secondary">Room Number</span>
                        <span class="fw-medium">{{ $booking->room->room_number }}</span>
                    </div>
                    <div class="mb-2 d-flex justify-content-between">
                        <span class="text-secondary">Room Type</span>
                        <span class="fw-medium">{{ $booking->room->roomType->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Floor</span>
                        <span class="fw-medium">{{ $booking->room->floor ?? '-' }}</span>
                    </div>
                </div>
            </div>
            
            @if($booking->special_requests)
            <div class="mt-4 pt-4" style="border-top: 1px solid rgba(230, 198, 138, 0.1);">
                <h6 class="text-secondary mb-2"><i class="bi bi-chat-text me-2"></i>Special Requests</h6>
                <p class="mb-0">{{ $booking->special_requests }}</p>
            </div>
            @endif
        </div>
        
        <!-- Guest Information -->
        <div class="glass-card mb-4">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-person me-2"></i>Guest Information</h5>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <small class="text-secondary d-block">Full Name</small>
                        <span class="fw-medium">{{ $booking->guest->name }}</span>
                    </div>
                    <div class="mb-3">
                        <small class="text-secondary d-block">Phone</small>
                        <span class="fw-medium">{{ $booking->guest->phone }}</span>
                    </div>
                    <div>
                        <small class="text-secondary d-block">Email</small>
                        <span class="fw-medium">{{ $booking->guest->email ?? '-' }}</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <small class="text-secondary d-block">ID Type</small>
                        <span class="fw-medium text-uppercase">{{ $booking->guest->id_type }}</span>
                    </div>
                    <div>
                        <small class="text-secondary d-block">ID Number</small>
                        <span class="fw-medium">{{ $booking->guest->id_number }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Timeline -->
        <div class="glass-card">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-clock-history me-2"></i>Timeline</h5>
            
            <div class="timeline">
                <div class="timeline-item">
                    <div class="timeline-marker" style="background: var(--accent);"></div>
                    <div class="timeline-content">
                        <small class="text-secondary">{{ $booking->created_at->format('d M Y, H:i') }}</small>
                        <p class="mb-0 fw-medium">Booking Created</p>
                    </div>
                </div>
                @if($booking->confirmed_at)
                <div class="timeline-item">
                    <div class="timeline-marker" style="background: var(--teal);"></div>
                    <div class="timeline-content">
                        <small class="text-secondary">{{ $booking->confirmed_at->format('d M Y, H:i') }}</small>
                        <p class="mb-0 fw-medium">Booking Confirmed</p>
                    </div>
                </div>
                @endif
                @if($booking->checked_in_at)
                <div class="timeline-item">
                    <div class="timeline-marker" style="background: #0d6efd;"></div>
                    <div class="timeline-content">
                        <small class="text-secondary">{{ $booking->checked_in_at->format('d M Y, H:i') }}</small>
                        <p class="mb-0 fw-medium">Guest Checked In</p>
                    </div>
                </div>
                @endif
                @if($booking->checked_out_at)
                <div class="timeline-item">
                    <div class="timeline-marker" style="background: #6c757d;"></div>
                    <div class="timeline-content">
                        <small class="text-secondary">{{ $booking->checked_out_at->format('d M Y, H:i') }}</small>
                        <p class="mb-0 fw-medium">Guest Checked Out</p>
                    </div>
                </div>
                @endif
                @if($booking->cancelled_at)
                <div class="timeline-item">
                    <div class="timeline-marker" style="background: #dc3545;"></div>
                    <div class="timeline-content">
                        <small class="text-secondary">{{ $booking->cancelled_at->format('d M Y, H:i') }}</small>
                        <p class="mb-0 fw-medium">Booking Cancelled</p>
                        @if($booking->cancellation_reason)
                        <small class="text-secondary">Reason: {{ $booking->cancellation_reason }}</small>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Payment Summary -->
    <div class="col-lg-4">
        <div class="glass-card position-sticky" style="top: 100px;">
            <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-receipt me-2"></i>Payment Summary</h5>
            
            <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Price per night</span>
                    <span>Rp {{ number_format($booking->room->roomType->price_per_night, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Number of nights</span>
                    <span>{{ $booking->check_in->diffInDays($booking->check_out) }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-secondary">Subtotal</span>
                    <span>{{ $booking->formatted_price }}</span>
                </div>
            </div>
            
            @if($booking->discount_amount > 0)
            <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                <div class="d-flex justify-content-between">
                    <span class="text-secondary">Discount</span>
                    <span style="color: var(--teal);">-Rp {{ number_format($booking->discount_amount, 0, ',', '.') }}</span>
                </div>
            </div>
            @endif
            
            <div class="d-flex justify-content-between mb-4">
                <span class="fs-5 fw-medium">Total</span>
                <span class="fs-5 fw-bold" style="color: var(--accent);">{{ $booking->formatted_price }}</span>
            </div>
            
            <div class="mb-4 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Paid Amount</span>
                    <span style="color: var(--teal);">Rp {{ number_format($booking->paid_amount ?? 0, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-secondary">Balance Due</span>
                    <span style="color: {{ ($booking->total_price - ($booking->paid_amount ?? 0)) > 0 ? '#dc3545' : 'var(--teal)' }};">
                        Rp {{ number_format(max(0, $booking->total_price - ($booking->paid_amount ?? 0)), 0, ',', '.') }}
                    </span>
                </div>
            </div>
            
            @if($booking->payment_method)
            <div class="mb-4">
                <small class="text-secondary d-block">Payment Method</small>
                <span class="fw-medium">{{ $booking->payment_method }}</span>
            </div>
            @endif
            
            @if($booking->status !== 'cancelled' && $booking->status !== 'checked_out')
            <button type="button" class="btn btn-outline-gold w-100 mb-2" data-bs-toggle="modal" data-bs-target="#paymentModal">
                <i class="bi bi-credit-card me-2"></i>Record Payment
            </button>
            @endif
            
            @if(!in_array($booking->status, ['cancelled', 'checked_out', 'checked_in']))
            <button type="button" class="btn w-100" style="background: rgba(220, 53, 69, 0.1); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.3);" data-bs-toggle="modal" data-bs-target="#cancelModal">
                <i class="bi bi-x-circle me-2"></i>Cancel Booking
            </button>
            @endif
        </div>
    </div>
</div>

<!-- Cancel Modal -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content" style="background: var(--surface); border: 1px solid rgba(230, 198, 138, 0.2);">
            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST">
                @csrf
                <div class="modal-header border-0">
                    <h5 class="modal-title" style="color: var(--accent);">Cancel Booking</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-secondary">Are you sure you want to cancel this booking?</p>
                    <div class="mb-3">
                        <label class="form-label">Cancellation Reason</label>
                        <textarea name="cancellation_reason" class="form-control" rows="3" placeholder="Enter reason for cancellation..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn" style="background: rgba(255,255,255,0.05); color: var(--text-primary);" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn" style="background: rgba(220, 53, 69, 0.2); color: #dc3545;">Cancel Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline::before {
    content: '';
    position: absolute;
    left: 8px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: rgba(230, 198, 138, 0.2);
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -26px;
    width: 14px;
    height: 14px;
    border-radius: 50%;
    top: 3px;
}

.timeline-content {
    padding-left: 10px;
}
</style>
@endpush
@endsection
