<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Borrowing;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i-- ){
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labels[] = Carbon::now()->subDays($i)->format('d-m');
            
            $count = Borrowing::whereDate('borrow_date', $date)->count();
            $data[] = $count;
        
        }
        return view('dashboard', compact('labels', 'data'));
    }
    //
}
