@extends('layouts.admin')

@section('title', 'Booking Calendar')
@section('header', 'Booking Calendar')

@push('styles')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<style>
    #calendar {
        background: rgba(255, 255, 255, 0.02);
        border-radius: 12px;
        padding: 20px;
        border: 1px solid rgba(230, 198, 138, 0.1);
    }
    
    .fc {
        --fc-border-color: rgba(230, 198, 138, 0.1);
        --fc-button-bg-color: rgba(230, 198, 138, 0.1);
        --fc-button-border-color: rgba(230, 198, 138, 0.2);
        --fc-button-text-color: #E6C68A;
        --fc-button-hover-bg-color: rgba(230, 198, 138, 0.2);
        --fc-button-hover-border-color: #E6C68A;
        --fc-button-active-bg-color: #E6C68A;
        --fc-button-active-border-color: #E6C68A;
        --fc-today-bg-color: rgba(230, 198, 138, 0.1);
    }
    
    .fc-theme-standard .fc-scrollgrid {
        border: none;
    }
    
    .fc-col-header-cell-cushion {
        color: var(--text-primary);
        font-weight: 500;
        text-decoration: none;
        padding: 10px 0;
    }
    
    .fc-daygrid-day-number {
        color: var(--text-secondary);
        text-decoration: none;
        padding: 8px;
    }
    
    .fc-daygrid-day.fc-day-today .fc-daygrid-day-number {
        color: var(--accent);
        font-weight: 600;
    }
    
    .fc-event {
        border: none;
        border-radius: 4px;
        font-size: 0.85rem;
        padding: 2px 6px;
        cursor: pointer;
    }
    
    .fc-event:hover {
        opacity: 0.85;
    }
    
    .fc-toolbar-title {
        color: var(--text-primary) !important;
        font-size: 1.25rem !important;
    }
    
    .fc-button {
        border-radius: 6px !important;
        font-weight: 500 !important;
    }
    
    .fc-button-active {
        color: var(--primary) !important;
    }
    
    .room-legend {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.875rem;
        color: var(--text-secondary);
    }
    
    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
    }
</style>
@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div class="d-flex gap-2 flex-wrap">
        <a href="{{ route('admin.bookings.index') }}" class="btn" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(230, 198, 138, 0.2); color: var(--text-primary);">
            <i class="bi bi-list me-2"></i>List View
        </a>
        <a href="{{ route('admin.bookings.calendar') }}" class="btn btn-gold">
            <i class="bi bi-calendar3 me-2"></i>Calendar View
        </a>
    </div>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-gold">
        <i class="bi bi-plus-circle me-2"></i>New Booking
    </a>
</div>

<!-- Room Filter -->
<div class="glass-card mb-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-4">
            <label class="form-label text-secondary small">Filter by Room</label>
            <select id="roomFilter" class="form-select">
                <option value="">All Rooms</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->room_number }} - {{ $room->roomType->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-8">
            <div class="room-legend">
                <div class="legend-item">
                    <div class="legend-color" style="background: #ffc107;"></div>
                    <span>Pending</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #0d6efd;"></div>
                    <span>Confirmed</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #198754;"></div>
                    <span>Checked In</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #6c757d;"></div>
                    <span>Checked Out</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Calendar -->
<div class="glass-card">
    <div id="calendar"></div>
</div>
@endsection

@push('scripts')
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    var roomFilter = document.getElementById('roomFilter');
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek'
        },
        events: function(info, successCallback, failureCallback) {
            fetch('{{ route("admin.bookings.calendarEvents") }}?' + new URLSearchParams({
                start: info.startStr,
                end: info.endStr,
                room_id: roomFilter.value
            }))
            .then(response => response.json())
            .then(data => successCallback(data))
            .catch(error => failureCallback(error));
        },
        eventClick: function(info) {
            if (info.event.url) {
                window.location.href = info.event.url;
                info.jsEvent.preventDefault();
            }
        },
        height: 'auto',
        dayMaxEvents: 3,
        firstDay: 1
    });
    
    calendar.render();
    
    roomFilter.addEventListener('change', function() {
        calendar.refetchEvents();
    });
});
</script>
@endpush
