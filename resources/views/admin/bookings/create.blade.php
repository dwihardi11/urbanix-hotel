@extends('layouts.admin')

@section('title', 'Create Booking')
@section('header', 'Create New Booking')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.bookings.index') }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
        <i class="bi bi-arrow-left me-2"></i>Back to Bookings
    </a>
</div>

<form action="{{ route('admin.bookings.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <!-- Room Selection -->
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-door-open me-2"></i>Room Selection</h5>
                
                <div class="row g-3">
                    <div class="col-md-12">
                        <label class="form-label">Select Room <span class="text-danger">*</span></label>
                        <select name="room_id" id="room_id" class="form-select @error('room_id') is-invalid @enderror" required>
                            <option value="">Choose a room...</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" 
                                        data-price="{{ $room->roomType->price_per_night }}"
                                        {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->room_number }} - {{ $room->roomType->name }} 
                                    ({{ $room->hotel->name ?? 'Main Hotel' }}) 
                                    - Rp {{ number_format($room->roomType->price_per_night, 0, ',', '.') }}/night
                                </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Check-in Date <span class="text-danger">*</span></label>
                        <input type="date" name="check_in" id="check_in" 
                               class="form-control @error('check_in') is-invalid @enderror" 
                               value="{{ old('check_in') }}" 
                               min="{{ date('Y-m-d') }}" required>
                        @error('check_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Check-out Date <span class="text-danger">*</span></label>
                        <input type="date" name="check_out" id="check_out" 
                               class="form-control @error('check_out') is-invalid @enderror" 
                               value="{{ old('check_out') }}" required>
                        @error('check_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Guest Information -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-person me-2"></i>Guest Information</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Guest Name <span class="text-danger">*</span></label>
                        <input type="text" name="guest_name" class="form-control @error('guest_name') is-invalid @enderror" 
                               value="{{ old('guest_name') }}" required>
                        @error('guest_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                        <input type="tel" name="guest_phone" class="form-control @error('guest_phone') is-invalid @enderror" 
                               value="{{ old('guest_phone') }}" required>
                        @error('guest_phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="guest_email" class="form-control @error('guest_email') is-invalid @enderror" 
                               value="{{ old('guest_email') }}">
                        @error('guest_email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">ID Type <span class="text-danger">*</span></label>
                        <select name="id_type" class="form-select @error('id_type') is-invalid @enderror" required>
                            <option value="ktp" {{ old('id_type') == 'ktp' ? 'selected' : '' }}>KTP</option>
                            <option value="sim" {{ old('id_type') == 'sim' ? 'selected' : '' }}>SIM</option>
                            <option value="passport" {{ old('id_type') == 'passport' ? 'selected' : '' }}>Passport</option>
                        </select>
                        @error('id_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">ID Number <span class="text-danger">*</span></label>
                        <input type="text" name="id_number" class="form-control @error('id_number') is-invalid @enderror" 
                               value="{{ old('id_number') }}" required>
                        @error('id_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Special Requests</label>
                        <textarea name="special_requests" class="form-control @error('special_requests') is-invalid @enderror" 
                                  rows="3" placeholder="Any special requests or notes...">{{ old('special_requests') }}</textarea>
                        @error('special_requests')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Booking Summary -->
        <div class="col-lg-4">
            <div class="glass-card position-sticky" style="top: 100px;">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-receipt me-2"></i>Booking Summary</h5>
                
                <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Room</span>
                        <span id="summaryRoom">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Check-in</span>
                        <span id="summaryCheckIn">-</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Check-out</span>
                        <span id="summaryCheckOut">-</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Nights</span>
                        <span id="summaryNights">0</span>
                    </div>
                </div>
                
                <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Price per night</span>
                        <span id="summaryPricePerNight">Rp 0</span>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between mb-4">
                    <span class="fs-5 fw-medium">Estimated Total</span>
                    <span id="summaryTotal" class="fs-5 fw-bold" style="color: var(--accent);">Rp 0</span>
                </div>
                
                <button type="submit" class="btn btn-gold w-100">
                    <i class="bi bi-check-circle me-2"></i>Create Booking
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomSelect = document.getElementById('room_id');
    const checkIn = document.getElementById('check_in');
    const checkOut = document.getElementById('check_out');
    
    function updateSummary() {
        const selectedOption = roomSelect.options[roomSelect.selectedIndex];
        const pricePerNight = selectedOption.dataset.price || 0;
        
        // Update room
        document.getElementById('summaryRoom').textContent = 
            roomSelect.value ? selectedOption.text.split(' - ')[0] : '-';
        
        // Update dates
        document.getElementById('summaryCheckIn').textContent = 
            checkIn.value ? new Date(checkIn.value).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';
        document.getElementById('summaryCheckOut').textContent = 
            checkOut.value ? new Date(checkOut.value).toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' }) : '-';
        
        // Calculate nights
        let nights = 0;
        if (checkIn.value && checkOut.value) {
            const start = new Date(checkIn.value);
            const end = new Date(checkOut.value);
            nights = Math.max(0, Math.ceil((end - start) / (1000 * 60 * 60 * 24)));
        }
        document.getElementById('summaryNights').textContent = nights;
        
        // Update price
        document.getElementById('summaryPricePerNight').textContent = 
            'Rp ' + Number(pricePerNight).toLocaleString('id-ID');
        
        // Calculate total
        const total = nights * pricePerNight;
        document.getElementById('summaryTotal').textContent = 
            'Rp ' + total.toLocaleString('id-ID');
    }
    
    roomSelect.addEventListener('change', updateSummary);
    checkIn.addEventListener('change', function() {
        checkOut.min = checkIn.value;
        updateSummary();
    });
    checkOut.addEventListener('change', updateSummary);
    
    // Initial update
    updateSummary();
});
</script>
@endpush
