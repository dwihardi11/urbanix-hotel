@extends('layouts.admin')

@section('title', 'Add New Room')
@section('header', 'Add New Room')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.rooms.index') }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
        <i class="bi bi-arrow-left me-2"></i>Back to Rooms
    </a>
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

<form action="{{ route('admin.rooms.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-door-open me-2"></i>Room Information</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Hotel <span class="text-danger">*</span></label>
                        <select name="hotel_id" class="form-select @error('hotel_id') is-invalid @enderror" required>
                            <option value="">Select hotel...</option>
                            @foreach($hotels as $hotel)
                                <option value="{{ $hotel->id }}" {{ old('hotel_id') == $hotel->id ? 'selected' : '' }}>
                                    {{ $hotel->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('hotel_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Room Type <span class="text-danger">*</span></label>
                        <select name="room_type_id" id="room_type_id" class="form-select @error('room_type_id') is-invalid @enderror" required>
                            <option value="">Select room type...</option>
                            @foreach($roomTypes as $type)
                                <option value="{{ $type->id }}" 
                                        data-price="{{ $type->price_per_night }}"
                                        {{ old('room_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->name }} - Rp {{ number_format($type->price_per_night, 0, ',', '.') }}/night
                                </option>
                            @endforeach
                        </select>
                        @error('room_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Room Number <span class="text-danger">*</span></label>
                        <input type="text" name="room_number" class="form-control @error('room_number') is-invalid @enderror" 
                               value="{{ old('room_number') }}" placeholder="e.g., 101" required>
                        @error('room_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Floor</label>
                        <input type="text" name="floor" class="form-control @error('floor') is-invalid @enderror" 
                               value="{{ old('floor') }}" placeholder="e.g., 1">
                        @error('floor')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Price per Night <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-secondary);">Rp</span>
                            <input type="number" name="price_per_night" id="price_per_night" 
                                   class="form-control @error('price_per_night') is-invalid @enderror" 
                                   value="{{ old('price_per_night') }}" min="0" step="1000" required>
                        </div>
                        @error('price_per_night')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="Room description...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Amenities -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-stars me-2"></i>Amenities</h5>
                
                <div class="row g-3">
                    @foreach($amenities as $amenity)
                    <div class="col-md-4 col-6">
                        <div class="form-check">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" 
                                   class="form-check-input" id="amenity_{{ $amenity->id }}"
                                   {{ in_array($amenity->id, old('amenities', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="amenity_{{ $amenity->id }}">
                                @if($amenity->icon)
                                <i class="{{ $amenity->icon }} me-2"></i>
                                @endif
                                {{ $amenity->name }}
                            </label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            
            <!-- Images -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-image me-2"></i>Room Images</h5>
                
                <div class="mb-3">
                    <label class="form-label">Upload Images</label>
                    <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" 
                           multiple accept="image/*">
                    <small class="text-secondary">You can upload multiple images. Accepted formats: JPEG, PNG, JPG, WebP. Max 2MB each.</small>
                    @error('images.*')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="glass-card position-sticky" style="top: 100px;">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-check-circle me-2"></i>Save Room</h5>
                
                <p class="text-secondary mb-4">Fill in all required fields and click save to add the new room.</p>
                
                <button type="submit" class="btn btn-gold w-100">
                    <i class="bi bi-plus-circle me-2"></i>Add Room
                </button>
            </div>
        </div>
    </div>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomTypeSelect = document.getElementById('room_type_id');
    const priceInput = document.getElementById('price_per_night');
    
    roomTypeSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const price = selectedOption.dataset.price;
        if (price) {
            priceInput.value = price;
        }
    });
});
</script>
@endpush
