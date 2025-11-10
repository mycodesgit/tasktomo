<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Models\Daily;
use App\Models\Option;
use App\Models\User;

class DailyTaskController extends Controller
{
    public function index()
    {
        $option = Option::all();

        return view('task.daily', compact('option'));
    }

    public function store(Request $request) 
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'tasktitle' => 'required',
                'taskdesc' => 'required',
                'user_id' => 'required',
            ]);

            try {
                Daily::create([
                    'tasktitle' => $request->input('tasktitle'),
                    'taskdesc' => $request->input('taskdesc'),
                    'tasktag' => $request->input('tasktag'),
                    'user_id' => $request->input('user_id'),
                    'remember_token' => Str::random(60),
                ]);
                return response()->json(['success' => true, 'message' => 'Accomplishment stored successfully'], 200);
            } catch (\Exception $e) {
                return response()->json(['error' => true, 'message' => 'Failed to store Accomplishment!'], 404);
            }
        }
    }

    public function show() 
    {
        $data = $this->getCurrentMonthAccomplishments();

        return response()->json(['data' => $data]);
    }
    
    public function getCurrentMonthAccomplishments()
    {
        $userId = Auth::id();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        return Daily::join('users', 'accomplishment.user_id', '=', 'users.id')
                    ->leftJoin('optiontask', 'accomplishment.tasktitle', '=', 'optiontask.option_name')
                    ->select('accomplishment.*', 'accomplishment.id as accom_id', 'optiontask.*', 'accomplishment.created_at as acrt')
                    ->where('accomplishment.user_id', '=', $userId)
                    ->where(DB::raw('MONTH(accomplishment.created_at)'), '=', $currentMonth)
                    ->where(DB::raw('YEAR(accomplishment.created_at)'), '=', $currentYear)
                    ->orderBy('accomplishment.created_at', 'ASC')
                    ->get(); 
    }
}
