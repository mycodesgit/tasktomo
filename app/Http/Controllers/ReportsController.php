<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;

use App\Models\Daily;
use App\Models\Option;
use App\Models\User;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports.list');
    }

    /**
     * Generate PDF for reports (handles both POST for form and GET for iframe src).
     * For iframe, use GET with query params.
     */
    public function generateReports(Request $request) 
    {
        $data = $this->getAccomplishmentsByDateRange($request);

        $pdf = Pdf::loadView('reports.genReports', $data)->setPaper('Letter', 'portrait');
        
        // For POST (original form), stream/download
        if ($request->isMethod('post')) {
            return $pdf->stream('report.pdf');
        }
        
        // For GET (iframe src), inline for embedding
        return $pdf->inline('report.pdf');
    }

    /**
     * Extracted method to fetch accomplishments by date range as an array.
     * Returns the data structure for reuse in views or PDF.
     */
    protected function getAccomplishmentsByDateRange(Request $request)
    {
        $userId = Auth::id();
        $start_date = $request->input('start_date') ?? $request->query('start_date');
        $end_date = $request->input('end_date') ?? $request->query('end_date');
        $group = $request->input('group', 'on') ?? $request->query('group', 'on');

        // Validate dates if provided
        if ($start_date && $end_date) {
            $request->validate([
                'start_date' => 'required|date|before_or_equal:end_date',
                'end_date' => 'required|date',
            ]);
        }

        if ($group == 'on') {
            $accom = Daily::where('user_id', $userId)
                ->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59']) // Full day range
                ->groupBy('tasktitle')
                ->select('tasktitle', DB::raw('GROUP_CONCAT(taskdesc SEPARATOR "<br>") as grouped_no_accom'))
                ->get();

        } else {
            $accom = Daily::where('user_id', $userId)
                ->whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
                ->get();
        }

        return [
            'accom' => $accom,
            'group' => $group,
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
