@extends('layouts.admin')

@section('title', 'Edit Room')
@section('header', 'Edit Room')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.rooms.show', $room) }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
        <i class="bi bi-arrow-left me-2"></i>Back to Details
    </a>
    <span class="badge fs-6" style="background: rgba(230, 198, 138, 0.2); color: var(--accent);">
        Room {{ $room->room_number }}
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

<form action="{{ route('admin.rooms.update', $room) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
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
                                <option value="{{ $hotel->id }}" {{ old('hotel_id', $room->hotel_id) == $hotel->id ? 'selected' : '' }}>
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
                                        {{ old('room_type_id', $room->room_type_id) == $type->id ? 'selected' : '' }}>
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
                               value="{{ old('room_number', $room->room_number) }}" placeholder="e.g., 101" required>
                        @error('room_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Floor</label>
                        <input type="text" name="floor" class="form-control @error('floor') is-invalid @enderror" 
                               value="{{ old('floor', $room->floor) }}" placeholder="e.g., 1">
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
                                   value="{{ old('price_per_night', $room->price_per_night) }}" min="0" step="1000" required>
                        </div>
                        @error('price_per_night')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                            <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Active Status</label>
                        <div class="form-check form-switch mt-2">
                            <input type="hidden" name="is_active" value="0">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active"
                                   {{ old('is_active', $room->is_active) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">
                                Room is active and available for booking
                            </label>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="3" placeholder="Room description...">{{ old('description', $room->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Amenities -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-stars me-2"></i>Amenities</h5>
                
                @php
                    $roomAmenityIds = $room->amenities->pluck('id')->toArray();
                @endphp
                
                <div class="row g-3">
                    @foreach($amenities as $amenity)
                    <div class="col-md-4 col-6">
                        <div class="form-check">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity->id }}" 
                                   class="form-check-input" id="amenity_{{ $amenity->id }}"
                                   {{ in_array($amenity->id, old('amenities', $roomAmenityIds)) ? 'checked' : '' }}>
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
                
                @if($room->images && count($room->images) > 0)
                <div class="mb-4">
                    <label class="form-label text-secondary">Current Images</label>
                    <div class="row g-3">
                        @foreach($room->images as $index => $image)
                        <div class="col-md-3 col-4">
                            <div class="position-relative" style="border-radius: 8px; overflow: hidden;">
                                <img src="{{ asset('storage/' . $image) }}" alt="Room image" class="w-100" style="height: 100px; object-fit: cover;">
                                <form action="{{ route('admin.rooms.deleteImage', ['room' => $room->id, 'index' => $index]) }}" 
                                      method="POST" class="position-absolute" style="top: 5px; right: 5px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" 
                                            style="background: rgba(220, 53, 69, 0.9); color: white; padding: 2px 8px;"
                                            onclick="return confirm('Delete this image?')">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
                
                <div>
                    <label class="form-label">Add More Images</label>
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
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-check-circle me-2"></i>Save Changes</h5>
                
                <p class="text-secondary mb-4">Update the room information and click save to apply changes.</p>
                
                <button type="submit" class="btn btn-gold w-100 mb-3">
                    <i class="bi bi-check-circle me-2"></i>Update Room
                </button>
                
                <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-outline-gold w-100">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
