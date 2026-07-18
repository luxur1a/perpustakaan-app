<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Borrowing;
use App\Models\Member;
use App\Models\Book;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Menghitung ringkasan data
        $totalBooks = Book::count(); 
        $totalMembers = Member::count(); 
        $activeBorrowings = Borrowing::whereNull('return_date')->count(); 

        // Menyiapkan data untuk 4 minggu terakhir
        $labelsWeekly = [];
        $dataWeekly = [];

        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek()->format('Y-m-d');
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek()->format('Y-m-d');
            
            $urutanMinggu = 4 - $i;
            $labelTanggal = Carbon::parse($startOfWeek)->format('d/m') . '-' . Carbon::parse($endOfWeek)->format('d/m');
            
            $labelsWeekly[] = "Minggu " . $urutanMinggu . " (" . $labelTanggal . ")";
            $dataWeekly[] = Borrowing::whereBetween('borrow_date', [$startOfWeek, $endOfWeek])->count();
        }

        // Menyiapkan data untuk 7 hari terakhir
        $labelsDaily = [];
        $dataDaily = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $labelsDaily[] = Carbon::now()->subDays($i)->format('d M');
            $dataDaily[] = Borrowing::whereDate('borrow_date', $date)->count();
        }

        return view('dashboard', compact(
            'totalBooks', 'totalMembers', 'activeBorrowings', 
            'labelsWeekly', 'dataWeekly', 
            'labelsDaily', 'dataDaily'
        ));
    }
    //
}
