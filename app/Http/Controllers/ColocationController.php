<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColocationFormRequest;
use App\Models\Colocation;
use Illuminate\Http\Request;

class ColocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        dd(auth()->user()->membership); aintnowawy notwrkig switching to relationship builder
        if (auth()->user()->membership?->colocation == null){ //adding? to avoid read properit on nul error
            return redirect()->route('colocation.create');
        }
//        return view('colocation.owner.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('colocation.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ColocationFormRequest $request)
    {
       $colocation =  Colocation::create(['name'=>$request->name,
            'description'=>$request->description,
            'avatar'=>$request->avatar,]);
       $colocation->memberships()->create(['user_id'=>$request->user()->id,'role'=>'owner']);
       redirect()->route('owner.dashboard');
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
