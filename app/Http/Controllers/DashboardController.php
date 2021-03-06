<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $tasks = Task::groupBy('status')->select('status', DB::raw('count(*) as total'))->get();
        $completed_tasks = $tasks->where('status', 'completed')->first()?->total ?? 0;
        $pended_tasks = $tasks->where('status', 'pended')->first()?->total ?? 0;
        $InProgress_tasks = $tasks->where('status', 'in_progress')->first()?->total ?? 0;
        $canceled_tasks = $tasks->where('status', 'canceled')->first()?->total ?? 0;

        // Prepering data to be used in chart
        $result = Task::where('status','completed')->where('status_updated_at', '>=', now()->subYear())
            ->select(DB::raw('count(id) as data, EXTRACT(YEAR FROM status_updated_at) AS "year", EXTRACT(MONTH FROM status_updated_at) AS "month"'))
            ->groupby('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $monthsLabel = [];
        $monthsData = [];
        for ($t = 11; $t >= 0; $t--) {
            $monthsLabel[] = now()->subMonths($t)->format('M Y');
            $monthsData[] = $result->where('month', now()->subMonths($t)->format('m'))->first()?->data ?? 0;
        }

        return view('dashboard.index', compact('completed_tasks', 'pended_tasks', 'InProgress_tasks', 'canceled_tasks', 'monthsLabel', 'monthsData'));
    }
}
