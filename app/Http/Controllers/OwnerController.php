<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\Split;
use App\Models\User;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $membership = auth()->user()->membership;
        $myBalance = $membership->balance;
        $colocation = $membership->colocation;
        $year = $request->get("year");
        $month = $request->get("month");
        //expenses
        if($year && $month){
            $expenses = $colocation->expenses()->with('membership.user','category')
                ->whereYear('date', $year)
                ->whereMonth('date', $month)
                ->latest('date')->get();
        } else {
            $expenses= $colocation->expenses()->with('membership.user','category')
                ->latest()->limit(5)->get();
        }

        $totalSpent = $colocation->expenses()->sum('amount');
        $totalExpenses = $colocation->expenses()->count();

        //members
        $members = $colocation->memberships()->with('user')->where('status','active')->where('user_id','!=',auth()->id())->get();
        $totalMembers = $members->count()+1;

        //categories
        $categories = $colocation->categories ?? collect(); //fr count
        $totalCategories = $categories->count();

        $owes = $colocation->splits()->where('status','unpaid')->get();
        //adding reputation
        $reputation = auth()->user()->reputation;

        return view('colocation.owner.dashboard',compact(
            'membership',
            'reputation',
            'myBalance',
            'colocation',
            'expenses',
            'totalSpent',
            'totalExpenses',
            'totalMembers',
            'members',
            'totalCategories',
            'categories',
            'owes',
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


    public function kickMouad(User $mouad, Membership $owner)
    {

//        $owner->balance = $owner->splitsAsCrediteur()->sum('part')->get() - $owner->splitsAsDebuteur()->sum('part')->get();


        //change my status
      $mouad->membership()->update([
          'status' => 'inactive',
          'left_at' => now(),
      ]);



      $mouad->membership->splitsAsCrediteur()->update(['crediteur_id' => $owner->id]);

      $asDebuteurSplits = $mouad->membership->splitsAsDebuteur()->where('status','unpaid')->get();
      $asCrediteurSplits = $mouad->membership->splitsAsCrediteur()->where('status','unpaid')->get();







      foreach ($asCrediteurSplits as $split) {
          $exist = $owner->splitsAsCrediteur()->where(['debuteur_id',$split->debuteur_id])->first();
          if ($exist) {
              $exist->part += $split->part;
              $exist->save();
              $split->delete();
          } else {
              $split->crediteur_id = $owner->id;
              $split->save();
          }

          $owner->balance += $split->part;
      }

      foreach ($asDebuteurSplits as $split) {
          $exist = $owner->splitsAsDebuteur()->where(['crediteur_id',$split->crediteur_id])->first();

          if ($exist) {
              if($exist->part < $split->part){

              } else {
                  $exist->part -= $split->part;
                  $exist->save();

              }

          }

      }




      return redirect()->back();
    }
}
