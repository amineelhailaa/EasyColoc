<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $membership = auth()->user()->membership;
        $colocation = $membership->colocation;
//        $expenses = $colocation->expenses()->with('membership.user', 'category')->latest()->limit(5)->get();
        $categories = $colocation->categories ?? collect();
        $totalPaid = $membership->expenses()->sum('amount');
        $totalOwe = $membership->balance;
        $members = $colocation->memberships()->with('user')->where('status','active')->where('user_id','!=',auth()->id())->get();
        $owes = $colocation->splits()->where('status','unpaid')->get();
        $reputation = auth()->user()->reputation ;
        $year = $request->get("year");
        $month = $request->get("month");
        //expenses
//        dd($year, $month);
        if($year && $month){
            $expenses = $colocation->expenses()->with('membership.user','category')
                ->whereYear('date', $year)->whereMonth('date', $month)
                ->latest('date')->get();
        }
        else {
            $expenses= $colocation->expenses()->with('membership.user','category')
                ->latest()->get();
        }

        return view('member.dashboard', compact(
            'membership',
            'reputation',
            'colocation',
            'expenses',
            'categories',
            'totalPaid',
            'totalOwe',
            'members',
            'owes'
        ));
    }


    public function quitColocation(Request $request){

        $user = $request->user();
        $membership = $user->membership;
        $membership->status = 'inactive';
        $membership->left_at = now();
        if ($membership->balance < 0){
            $user->reputation -= 1 ;
        }
        elseif ($membership->balance > 0){
            $user->reputation += 1 ;
        }
        $user->save();
        $membership->splitsAsDebuteur()->update([
            'status' => 'paid'
        ]);
        $membership->splitsAsCrediteur()->update([
            'status' => 'paid'
        ]);
        $membership->save();
       $members = $membership->colocation->memberships()->where('status','active')->get();
        foreach ($members as $n) {
            $n->balance = $n->splitsAsCrediteur()->where('status','=','unpaid')->sum('part') - $n->splitsAsDebuteur()->where('status','=','unpaid')->sum('part');
            $n->save();
        }

        return redirect()->route('home');
    }
}
