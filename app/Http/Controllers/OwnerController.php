<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\Split;
use App\Models\User;
use App\Services\SplitService;
use Illuminate\Database\Eloquent\Builder;
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
//        dd($year, $month);
        if($year && $month){
            $expenses = $colocation->expenses()->with('membership.user','category')
                ->whereYear('date', $year)->whereMonth('date', $month)
                ->latest('date')->get();
//            dd($expenses, $year, $month);
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


    public function annulerColocation(Request $request){
       $owner=$request->user()->membership;
       $owner->colocation->update([
       'status'=>'inactive']);
       $owner->colocation->memberships()->update(['status'=>'inactive']);
       return redirect()->back();
    }

    public function KickMember(Membership $member, SplitService $service)
    {
        $owner = auth()->user()->membership;
        if($member->colocation->id != $owner->colocation->id || $owner->id === $member->id || $member->status === 'inactive'){
            abort(404);
        }

        $service->kickEdits($member,$owner);


        return redirect()->back();
    }



}
