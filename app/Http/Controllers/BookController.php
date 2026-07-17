<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::latest()->get();
        return view('books.index', compact('books'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('books.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'dimension' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'dimension' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
        ]);

        $book->update($request->all());

        return redirect()->route('books.index')->with('success', 'Data buku berhasil diubah.');
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();

        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
        //
    }
}
