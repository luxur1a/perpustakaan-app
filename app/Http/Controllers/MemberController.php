<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Member::latest();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $members = $query->get();
        return view('members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_no' => 'required|string|unique:members,member_no',
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);

        Member::create($request->all());

        return redirect()->route('members.index')->with('success', 'Anggota berhasil ditambahkan.');
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'member_no' => 'required|string|unique:members,member_no,' . $member->id,
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
        ]);
        //
        $member->update($request->all());

        return redirect()->route('members.index')->with('success', 'Data anggota berhasil diubah.');
        //)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Anggota berhasil dihapus.');
        //
    }
}
