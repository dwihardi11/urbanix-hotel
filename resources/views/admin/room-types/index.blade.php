@extends('layouts.admin')

@section('title', 'Room Types')
@section('header', 'Room Type Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 text-secondary">Manage your hotel room types</h5>
    <a href="{{ route('admin.room-types.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-circle me-2"></i>Add Room Type
    </a>
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

<!-- Room Types Table -->
<div class="glass-card">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Base Price</th>
                    <th>Capacity</th>
                    <th>Bed Type</th>
                    <th>Size</th>
                    <th>Rooms</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roomTypes as $type)
                <tr>
                    <td>
                        <div class="fw-medium" style="color: var(--accent);">{{ $type->name }}</div>
                        @if($type->description)
                        <small class="text-secondary">{{ Str::limit($type->description, 50) }}</small>
                        @endif
                    </td>
                    <td class="fw-medium">Rp {{ number_format($type->base_price, 0, ',', '.') }}</td>
                    <td>
                        <i class="bi bi-person me-1"></i>{{ $type->capacity }} guest(s)
                    </td>
                    <td>{{ $type->bed_type }}</td>
                    <td>{{ $type->size_sqm ? $type->size_sqm . ' m²' : '-' }}</td>
                    <td>
                        <span class="badge" style="background: rgba(230, 198, 138, 0.2); color: var(--accent);">
                            {{ $type->rooms_count }} rooms
                        </span>
                    </td>
                    <td>
                        @if($type->is_active)
                        <span class="badge" style="background: rgba(100, 255, 218, 0.2); color: var(--teal);">
                            Active
                        </span>
                        @else
                        <span class="badge" style="background: rgba(220, 53, 69, 0.2); color: #dc3545;">
                            Inactive
                        </span>
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.room-types.edit', $type) }}" class="btn btn-sm btn-outline-gold" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            @if($type->rooms_count == 0)
                            <form action="{{ route('admin.room-types.destroy', $type) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this room type?')">
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
                    <td colspan="8" class="text-center text-secondary py-5">
                        <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                        No room types found
                        <div class="mt-3">
                            <a href="{{ route('admin.room-types.create') }}" class="btn btn-gold btn-sm">
                                <i class="bi bi-plus-circle me-2"></i>Add First Room Type
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($roomTypes->hasPages())
    <div class="mt-4 d-flex justify-content-center">
        {{ $roomTypes->links() }}
    </div>
    @endif
</div>
@endsection
