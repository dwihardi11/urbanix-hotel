<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Guest;
use App\Services\BookingService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected BookingService $bookingService;

    public function __construct(BookingService $bookingService)
    {
        $this->bookingService = $bookingService;
    }

    public function index()
    {
        $stats = $this->bookingService->getDashboardStats();
        
        // Recent bookings
        $recentBookings = Booking::with(['room.roomType', 'guest'])
            ->latest()
            ->take(5)
            ->get();

        // Today's check-ins
        $todayCheckins = Booking::with(['room.roomType', 'guest'])
            ->where('check_in', Carbon::today())
            ->whereIn('status', ['confirmed'])
            ->get();

        // Today's check-outs
        $todayCheckouts = Booking::with(['room.roomType', 'guest'])
            ->where('check_out', Carbon::today())
            ->whereIn('status', ['checked_in'])
            ->get();

        // Monthly revenue chart data
        $monthlyRevenue = $this->getMonthlyRevenueData();

        return view('admin.dashboard', compact(
            'stats',
            'recentBookings',
            'todayCheckins',
            'todayCheckouts',
            'monthlyRevenue'
        ));
    }

    private function getMonthlyRevenueData(): array
    {
        $data = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = Booking::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->whereIn('status', ['confirmed', 'checked_in', 'checked_out'])
                ->sum('total_price');
            
            $data[] = [
                'month' => $month->format('M Y'),
                'revenue' => $revenue,
            ];
        }

        return $data;
    }
}
