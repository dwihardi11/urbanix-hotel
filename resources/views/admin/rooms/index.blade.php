@extends('layouts.admin')

@section('title', 'Rooms')
@section('header', 'Room Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <form action="{{ route('admin.rooms.index') }}" method="GET" class="d-flex gap-2 flex-wrap">
        <select name="room_type" class="form-select" style="width: auto; min-width: 150px;" onchange="this.form.submit()">
            <option value="">All Types</option>
            @foreach($roomTypes as $type)
            <option value="{{ $type->id }}" {{ request('room_type') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
            @endforeach
        </select>
        <select name="status" class="form-select" style="width: auto; min-width: 150px;" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
            <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
        <div class="input-group" style="width: auto;">
            <input type="text" name="search" class="form-control" placeholder="Search room..." value="{{ request('search') }}" style="min-width: 180px;">
            <button type="submit" class="btn btn-outline-gold"><i class="bi bi-search"></i></button>
        </div>
    </form>
    <a href="{{ route('admin.rooms.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-circle me-2"></i>Add Room
    </a>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table table-dark-custom mb-0">
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Type</th>
                    <th>Floor</th>
                    <th>Price/Night</th>
                    <th>Status</th>
                    <th>Amenities</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rooms as $room)
                <tr>
                    <td>
                        <span class="fw-bold" style="color: var(--accent);">{{ $room->room_number }}</span>
                        @if(!$room->is_active)
                        <span class="badge ms-1" style="background: rgba(108, 117, 125, 0.2); color: #6c757d;">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $room->roomType->name }}</td>
                    <td><span class="text-secondary">Floor</span> {{ $room->floor }}</td>
                    <td class="fw-medium" style="color: var(--accent);">{{ $room->formatted_price }}</td>
                    <td>
                        @php
                            $statusStyles = [
                                'available' => 'background: rgba(100, 255, 218, 0.2); color: var(--teal);',
                                'occupied' => 'background: rgba(13, 110, 253, 0.2); color: #0d6efd;',
                                'maintenance' => 'background: rgba(255, 193, 7, 0.2); color: #ffc107;',
                            ];
                        @endphp
                        <span class="badge" style="{{ $statusStyles[$room->status] ?? '' }}">
                            <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>{{ ucfirst($room->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            @foreach($room->amenities->take(3) as $amenity)
                            <span class="badge" style="background: rgba(230, 198, 138, 0.1); color: var(--accent);" title="{{ $amenity->name }}">
                                <i class="{{ $amenity->icon }}"></i>
                            </span>
                            @endforeach
                            @if($room->amenities->count() > 3)
                            <span class="badge" style="background: rgba(255, 255, 255, 0.1); color: var(--text-secondary);">
                                +{{ $room->amenities->count() - 3 }}
                            </span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.rooms.show', $room) }}" class="btn btn-sm" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="{{ route('admin.rooms.edit', $room) }}" class="btn btn-sm btn-outline-gold" title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this room?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm" style="background: rgba(220, 53, 69, 0.1); border: 1px solid rgba(220, 53, 69, 0.3); color: #dc3545;" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-secondary py-5">
                        <i class="bi bi-door-closed fs-1 d-block mb-3"></i>
                        No rooms found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($rooms->hasPages())
    <div class="mt-4">
        <p class="pagination-info">
            Showing {{ $rooms->firstItem() }} to {{ $rooms->lastItem() }} of {{ $rooms->total() }} rooms
        </p>
        <div class="d-flex justify-content-center">
            {{ $rooms->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
