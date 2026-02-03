@extends('layouts.admin')

@section('title', 'Edit Guest')
@section('header', 'Edit Guest')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <a href="{{ route('admin.guests.show', $guest) }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
        <i class="bi bi-arrow-left me-2"></i>Back to Details
    </a>
    <span class="badge fs-6" style="background: rgba(230, 198, 138, 0.2); color: var(--accent);">
        {{ $guest->name }}
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

<form action="{{ route('admin.guests.update', $guest) }}" method="POST">
    @csrf
    @method('PUT')
    
    <div class="row">
        <div class="col-lg-8">
            <!-- Personal Information -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-person me-2"></i>Personal Information</h5>
                
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $guest->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email', $guest->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                               value="{{ old('phone', $guest->phone) }}" required>
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Identification -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-card-text me-2"></i>Identification</h5>
                
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">ID Type <span class="text-danger">*</span></label>
                        <select name="id_type" class="form-select @error('id_type') is-invalid @enderror" required>
                            <option value="ktp" {{ old('id_type', $guest->id_type) == 'ktp' ? 'selected' : '' }}>KTP</option>
                            <option value="sim" {{ old('id_type', $guest->id_type) == 'sim' ? 'selected' : '' }}>SIM</option>
                            <option value="passport" {{ old('id_type', $guest->id_type) == 'passport' ? 'selected' : '' }}>Passport</option>
                        </select>
                        @error('id_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-8">
                        <label class="form-label">ID Number <span class="text-danger">*</span></label>
                        <input type="text" name="id_number" class="form-control @error('id_number') is-invalid @enderror" 
                               value="{{ old('id_number', $guest->id_number) }}" required>
                        @error('id_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Address -->
            <div class="glass-card mb-4">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-geo-alt me-2"></i>Address</h5>
                
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                  rows="2" placeholder="Street address...">{{ old('address', $guest->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control @error('city') is-invalid @enderror" 
                               value="{{ old('city', $guest->city) }}" placeholder="City">
                        @error('city')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <input type="text" name="country" class="form-control @error('country') is-invalid @enderror" 
                               value="{{ old('country', $guest->country) }}" placeholder="Country">
                        @error('country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="glass-card position-sticky" style="top: 100px;">
                <h5 class="mb-4" style="color: var(--accent);"><i class="bi bi-info-circle me-2"></i>Guest Info</h5>
                
                <div class="mb-3 pb-3" style="border-bottom: 1px solid rgba(230, 198, 138, 0.1);">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Member Since</span>
                        <span>{{ $guest->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary">Total Bookings</span>
                        <span class="badge" style="background: rgba(230, 198, 138, 0.2); color: var(--accent);">
                            {{ $guest->bookings_count ?? $guest->bookings()->count() }}
                        </span>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-gold w-100 mb-2">
                    <i class="bi bi-check-circle me-2"></i>Update Guest
                </button>
                
                <a href="{{ route('admin.guests.show', $guest) }}" class="btn btn-outline-gold w-100">
                    Cancel
                </a>
            </div>
        </div>
    </div>
</form>
@endsection
