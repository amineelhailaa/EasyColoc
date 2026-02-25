<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseFormRequest;
use App\Models\User;
use App\Services\ExpenseService;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $colocation =  auth()->user()->membership->colocation;
       $expenses = $colocation->expenses;
       return $expenses; //ill use this function i guess in other functions or what
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
    public function store(ExpenseFormRequest $request, ExpenseService $expenseService)
    {
        $colocation  = auth()->user()->membership->colocation;
        if($colocation!= $request->membership_id->colocation){
            //return cuz he is not my groupe ms how to show the error ?

        }

        $expenseService->createwithSplits($request);

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

        //need to make splits



        return redirect()->back();

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
