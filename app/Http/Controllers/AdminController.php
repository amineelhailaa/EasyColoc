<?php

namespace App\Http\Controllers;

use App\Models\Colocation;
use App\Models\Expense;
use App\Models\Membership;
use App\Models\User;
use App\Services\MemberExitService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //dashboard
    public function index()
    {
        $admin = auth()->user();
        $membership = $admin->membership;
        $users = User::query()->where('id', '!=', $admin->id)->get();
        $colocations = Colocation::all();
        $chiffreDaffaire = Expense::sum('amount');
        $usersWithMembershipActive = Membership::where('status', 'active')->count();
        $usersWithNoMembership = $users->count() - $usersWithMembershipActive;
        return view('admin.index', compact(
            'admin',
            'membership',
            'users',
            'colocations',
            'chiffreDaffaire',
            'usersWithMembershipActive',
            'usersWithNoMembership'));
    }

    public function banUser(User $user, MemberExitService $service){
        $membership = $user->membership;
        if($membership){
            $colocation = $membership->colocation;
            if ($membership?->role === 'owner'){
                $member =  $colocation->memberships()->where('status', 'active')->where('id','!=',$membership->id)
                    ->first();

                if($member){
                    $member->role = 'owner';
                    $member->save();
                }
            }

                $service->quit($membership);



            $user->memberships()->delete();
        }

        $user->update(['ban' => 1]);
//        dd($user);

        return redirect()->back();
    }



    public function unbanUser(User $user)
    {
        $user->update(['ban' => 0]);
        return redirect()->back();
    }
}
