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
        $categories = $colocation->categories ?? collect();
        $totalPaid = $membership->expenses()->sum('amount');
        $totalOwe = $membership->balance;
        $members = $colocation->memberships()->with('user')->where('status','active')->where('user_id','!=',auth()->id())->get();
        $owes = $colocation->splits()->where('status','unpaid')->get();

        return view('member.dashboard', compact(
            'membership',
            'colocation',
            'expenses',
            'categories',
            'totalPaid',
            'totalOwe',
            'members',
            'owes'
        ));
    }
}
