<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $membership = auth()->user()->membership;
        $colocation = $membership->colocation;

        //expenses
        $expenses= $colocation->expenses()->with('membership.user','category')->latest()->limit(5)->get();
        $totalSpent = $colocation->expenses()->sum('amount');
        $totalExpenses = $colocation->expenses()->count();

        //members
        $members = $colocation->memberships()->with('user')->where('status','active')->where('user_id','!=',auth()->id())->get();
        $totalMembers = $members->count()+1;

        //categories
        $categories = $colocation->categories ?? collect(); //fr count
        $totalCategories = $categories->count();

        return view('colocation.owner.dashboard',compact(
            'membership',
            'colocation',
            'expenses',
            'totalSpent',
            'totalExpenses',
            'totalMembers',
            'members',
            'totalCategories',
            'categories'
        ));
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
    //manage categories
    public function destroy(Category $category)
    {
        $colocation = auth()->user()->membership->colocation;
        $colocation->categories()->findOrFail($category->id);
        $category->delete();
        return redirect()->back();
    }

    //store categories
    public function store(Request $request)
    {
        $membership = auth()->user()->membership;
        $colocation = $membership->colocation;
        $request->validate([
            'name' => 'required|string',
        ]);
        $colocation->categories()->create([
            'name' => $request->name,
        ]);

        return redirect()->back();
    }





    // my functions

}
