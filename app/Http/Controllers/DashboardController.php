<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Models\Daily;
use App\Models\Option;

use App\Http\Controllers\DailyTaskController;

class DashboardController extends Controller
{
    public function index()
    {
        $option = Option::all();
        $dailyTaskController = new DailyTaskController();
        $data = $dailyTaskController->getCurrentMonthAccomplishments();

        return view('home.dashboard', compact('option', 'data'));
    }

    public function fetchActivityDates()
{
    $userId = Auth::id();
    $currentYear = Carbon::now()->year;

    // Fetch unique dates (YYYY-MM-DD) where user has accomplishments this year
    $dates = Daily::select(DB::raw('DATE(created_at) as activity_date'))
                  ->where('user_id', $userId)
                  ->whereYear('created_at', $currentYear)
                  ->distinct()
                  ->orderBy('activity_date')
                  ->pluck('activity_date')
                  ->toArray();

    return response()->json([
        'success' => true,
        'dates' => $dates // e.g., ['2025-11-10', '2025-11-05']
    ]);
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();

        return redirect()->route('getLogin')->with('success', 'You have been Successfully Logged Out');
    }
}
