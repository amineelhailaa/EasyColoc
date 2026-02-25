<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $membership = auth()->user()->membership;
        $colocation = $membership->colocation;
        $expenses = $colocation->expenses()->with('membership.user', 'category')->latest()->limit(5)->get();
        $totalPaid = $membership->expenses()->sum('amount');
        $totalOwe = $membership->balance;
        $members = $colocation->memberships()->with('user')->where('status','active')->where('user_id','!=',auth()->id())->get();
        $members =

        return view('member.dashboard', compact(
            'membership',
            'colocation',
            'expenses',
            'totalPaid',
            'totalOwe',
            'members',
        ));
    }
}
