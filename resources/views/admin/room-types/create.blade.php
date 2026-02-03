@extends('layouts.admin')

@section('title', 'Add Room Type')
@section('header', 'Add New Room Type')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.room-types.index') }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
        <i class="bi bi-arrow-left me-2"></i>Back to Room Types
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

<form action="{{ route('admin.room-types.store') }}" method="POST">
    @csrf
    
    <div class="row">
        <div class="col-lg-8">
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-tag me-2"></i>Room Type Details</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name') }}" placeholder="e.g., Deluxe Room" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Base Price per Night <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-secondary);">Rp</span>
                            <input type="number" name="base_price" class="form-control @error('base_price') is-invalid @enderror" 
                                   value="{{ old('base_price') }}" min="0" step="1000" required>
                        </div>
                        @error('base_price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Capacity (Guests) <span class="text-danger">*</span></label>
                        <input type="number" name="capacity" class="form-control @error('capacity') is-invalid @enderror" 
                               value="{{ old('capacity', 2) }}" min="1" max="10" required>
                        @error('capacity')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Bed Type <span class="text-danger">*</span></label>
                        <select name="bed_type" class="form-select @error('bed_type') is-invalid @enderror" required>
                            <option value="">Select bed type...</option>
                            <option value="Single" {{ old('bed_type') == 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Twin" {{ old('bed_type') == 'Twin' ? 'selected' : '' }}>Twin</option>
                            <option value="Double" {{ old('bed_type') == 'Double' ? 'selected' : '' }}>Double</option>
                            <option value="Queen" {{ old('bed_type') == 'Queen' ? 'selected' : '' }}>Queen</option>
                            <option value="King" {{ old('bed_type') == 'King' ? 'selected' : '' }}>King</option>
                            <option value="Super King" {{ old('bed_type') == 'Super King' ? 'selected' : '' }}>Super King</option>
                        </select>
                        @error('bed_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Size (m²)</label>
                        <input type="number" name="size_sqm" class="form-control @error('size_sqm') is-invalid @enderror" 
                               value="{{ old('size_sqm') }}" min="1" placeholder="e.g., 25">
                        @error('size_sqm')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-12">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                  rows="4" placeholder="Describe this room type...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="glass-card position-sticky" style="top: 100px;">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-info-circle me-2"></i>Tips</h5>
                
                <div class="mb-4">
                    <p class="text-secondary small">
                        Room types define categories of rooms with specific characteristics and pricing. 
                        Each individual room can then be assigned to a room type.
                    </p>
                    <ul class="text-secondary small ps-3">
                        <li>Set a competitive base price</li>
                        <li>Include clear descriptions</li>
                        <li>Specify accurate capacity</li>
                    </ul>
                </div>
                
                <button type="submit" class="btn btn-gold w-100">
                    <i class="bi bi-plus-circle me-2"></i>Create Room Type
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
