@extends('layouts.admin')

@section('title', 'Guests')
@section('header', 'Guest Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 text-secondary">Manage your hotel guests</h5>
</div>

@if(session('success'))
<div class="alert" style="background: rgba(100, 255, 218, 0.1); border: 1px solid rgba(100, 255, 218, 0.3); color: var(--teal);">
    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert" style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); color: #dc3545;">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<!-- Search -->
<div class="glass-card mb-4">
    <form action="{{ route('admin.guests.index') }}" method="GET" class="row g-3">
        <div class="col-md-8">
            <label class="form-label text-secondary small">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone..." value="{{ request('search') }}">
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-gold w-100"><i class="bi bi-search me-2"></i>Search</button>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <a href="{{ route('admin.guests.index') }}" class="btn btn-outline-gold w-100">Clear</a>
        </div>
    </form>
</div>

<!-- Guests Table -->
<div class="glass-card">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Guest</th>
                    <th>Contact</th>
                    <th>ID</th>
                    <th>Location</th>
                    <th>Bookings</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($guests as $guest)
                <tr>
                    <td>
                        <a href="{{ route('admin.guests.show', $guest) }}" class="text-accent text-decoration-none fw-medium">
                            {{ $guest->name }}
                        </a>
                    </td>
                    <td>
                        <div>{{ $guest->email ?? '-' }}</div>
                        <small class="text-secondary">{{ $guest->phone }}</small>
                    </td>
                    <td>
                        <span class="text-uppercase badge" style="background: rgba(255,255,255,0.05); color: var(--text-secondary);">
                            {{ $guest->id_type }}
                        </span>
                        <small class="d-block text-secondary">{{ $guest->id_number }}</small>
                    </td>
                    <td>
                        @if($guest->city || $guest->country)
                            {{ $guest->city }}{{ $guest->city && $guest->country ? ', ' : '' }}{{ $guest->country }}
                        @else
                            <span class="text-secondary">-</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge" style="background: rgba(230, 198, 138, 0.2); color: var(--accent);">
                            {{ $guest->bookings_count }} bookings
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.guests.show', $guest) }}" class="btn btn-sm btn-outline-gold" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.guests.edit', $guest) }}" class="btn btn-sm btn-outline-gold" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($guest->bookings_count == 0)
                            <form action="{{ route('admin.guests.destroy', $guest) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this guest?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background: rgba(220, 53, 69, 0.2); color: #dc3545; border: 1px solid rgba(220, 53, 69, 0.3);" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-secondary py-5">
                        <i class="bi bi-people fs-1 d-block mb-3"></i>
                        No guests found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($guests->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $guests->links() }}
    </div>
    @endif
</div>
@endsection
