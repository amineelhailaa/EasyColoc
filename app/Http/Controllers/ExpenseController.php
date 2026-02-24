<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string|required',
            'amount' => 'numeric:|required',
            'date' => 'date|required|date_format:Y-m-d',
            'category_id' => 'nullable|exists:categories,id',
            'membership_id' => 'required|exists:users,id',
        ]);
//            auth()->user()->membership->colocation->expenses()->create([
//                'title'=>$request->title,
//                'amount'=>$request->amount,
//                'date'=>$request->date,
//                'category_id'=>$request->category_id,
//                'user_id'=>$request->user_id,
//            ]); /wil limit me from chosing who want to pay
//        $member = User::find($request->user_id)->membership;
//        $member->colocation->expenses()->create([
//            'title' => $request->title,
//            'amount' => $request->amount,
//            'date' => $request->date,
//            'category_id' => $request->category_id,
//            'user_id' => $request->user_id,
//        ]);

        //need to make splits now


        return redirect()->back();
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
