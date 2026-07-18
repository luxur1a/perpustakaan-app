<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $borrowings = Borrowing::with(['member', 'book'])->latest()->get();
        return view('borrowings.index', compact('borrowings'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $members = Member::all();

        $books = Book::where('stock', '>', 0)->get();

        return view('borrowings.create', compact('members', 'books'));
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            
        ]);

        $activeBorrowings = Borrowing::where('member_id', $request->member_id)
            ->whereNull('return_date')
            ->count();

        // Maksimal pinjam 3 buku
        if($activeBorrowings >= 3){
            return back()->withErrors(['member_id' => 'Maaf, anggota sudah mencapai batas maksimal peminjaman 3 buku.']);
        }

        try{
            DB::beginTransaction();

            $book = Book::findOrFail($request->book_id);

            // Cek stok buku
            if ($book->stock < 1){
                return back()->withErrors(['book_id' => 'Maaf, stok buku tidak tersedia.']);
            }

            // Kurangi stok buku
            $book->decrement('stock');

            // Buat record peminjaman
            Borrowing::create([
                'member_id' => $request->member_id,
                'book_id' => $request->book_id,
                'borrow_date' => $request->borrow_date,
                'return_date' => null,
            ]);

            DB::commit();

            return redirect()->route('borrowings.index')->with('success', 'Peminjaman buku berhasil tercatat.');

        } catch (\Exception $e){
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem saat meminjam buku.']);
        }

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Borrowing $borrowing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Borrowing $borrowing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Borrowing $borrowing)
    {
        $request->validate([
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        try{
            DB::beginTransaction();

            $borrowing->update([
                'return_date' => $request->return_date,
            ]);

            $borrowing->book()->increment('stock');

            DB::commit();

            return redirect()->route('borrowings.index')->with('success', 'Pengembalian buku berhasil tercatat.');

        } catch (\Exception $e){
            DB::rollback();
            return back()->withErrors(['error' => 'Terjadi kesalahan sistem saat mengembalikan buku.']);
        }
            
        }
        //
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Borrowing $borrowing)
    {
        //
    }
}
