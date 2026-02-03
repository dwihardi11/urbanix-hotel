@extends('layouts.admin')

@section('title', 'Edit Booking')
@section('header', 'Edit Booking')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.bookings.show', $booking) }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
        <i class="bi bi-arrow-left me-2"></i>Back to Details
    </a>
    <span class="badge fs-6" style="background: rgba(230, 198, 138, 0.2); color: var(--accent);">
        {{ $booking->booking_code }}
    </span>
</div>

@if($errors->any())
<div class="alert" style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); color: #dc3545;">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Booking Status -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-gear me-2"></i>Booking Status</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="checked_in" {{ old('status', $booking->status) == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                            <option value="checked_out" {{ old('status', $booking->status) == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                            <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Payment Status <span class="text-danger">*</span></label>
                        <select name="payment_status" class="form-select @error('payment_status') is-invalid @enderror" required>
                            <option value="unpaid" {{ old('payment_status', $booking->payment_status) == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="partial" {{ old('payment_status', $booking->payment_status) == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="paid" {{ old('payment_status', $booking->payment_status) == 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        @error('payment_status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Payment Information -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-credit-card me-2"></i>Payment Information</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Paid Amount</label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-secondary);">Rp</span>
                            <input type="number" name="paid_amount" class="form-control @error('paid_amount') is-invalid @enderror" 
                                   value="{{ old('paid_amount', $booking->paid_amount ?? 0) }}" min="0" step="1000">
                        </div>
                        @error('paid_amount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror">
                            <option value="">Select method...</option>
                            <option value="cash" {{ old('payment_method', $booking->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="debit_card" {{ old('payment_method', $booking->payment_method) == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                            <option value="credit_card" {{ old('payment_method', $booking->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="bank_transfer" {{ old('payment_method', $booking->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="e_wallet" {{ old('payment_method', $booking->payment_method) == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Special Requests -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-chat-text me-2"></i>Additional Notes</h5>
                
                <div class="mb-3">
                    <label class="form-label">Special Requests</label>
                    <textarea name="special_requests" class="form-control @error('special_requests') is-invalid @enderror" 
                              rows="3" placeholder="Any special requests or notes...">{{ old('special_requests', $booking->special_requests) }}</textarea>
                    @error('special_requests')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div>
                    <label class="form-label">Cancellation Reason (if cancelled)</label>
                    <textarea name="cancellation_reason" class="form-control @error('cancellation_reason') is-invalid @enderror" 
                              rows="2" placeholder="Reason for cancellation...">{{ old('cancellation_reason', $booking->cancellation_reason) }}</textarea>
                    @error('cancellation_reason')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Booking Info Sidebar -->
        <div class="col-lg-4">
            <div class="glass-card position-sticky" style="top: 100px;">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-info-circle me-2"></i>Booking Information</h5>
                
                <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                    <small class="text-secondary d-block">Guest</small>
                    <span class="fw-medium">{{ $booking->guest->name }}</span>
                    <br>
                    <small class="text-secondary">{{ $booking->guest->phone }}</small>
                </div>
                
                <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                    <small class="text-secondary d-block">Room</small>
                    <span class="fw-medium">{{ $booking->room->room_number }}</span>
                    <br>
                    <small class="text-secondary">{{ $booking->room->roomType->name }}</small>
                </div>
                
                <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Check-in</span>
                        <span>{{ $booking->check_in->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Check-out</span>
                        <span>{{ $booking->check_out->format('d M Y') }}</span>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="fs-5">Total Price</span>
                    <span class="fs-5 fw-bold" style="color: var(--accent);">{{ $booking->formatted_price }}</span>
                </div>
                
                <button type="submit" class="btn btn-gold w-100">
                    <i class="bi bi-check-circle me-2"></i>Update Booking
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
