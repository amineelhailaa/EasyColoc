<?php

namespace App\Services;

use App\Models\Membership;

class MemberExitService
{
    /**
     * Create a new class instance.
     */




    public function quit(Membership $membership){
        $user = $membership->user;
        $membership->status = 'inactive';
        $membership->left_at = now();

        if($membership->balance < 0){
            $user->reputation -= 1 ;
        } elseif ($membership->balance > 0){
                $user->reputation += 1;
        }
        $membership->splitsAsCrediteur()->update(['status' => 'paid']);
        $membership->splitsAsDebuteur()->update(['status' => 'paid']);
        $membership->save();
        $user->save();
        $members = $membership->colocation->memberships()->where('status', 'active')->get();
        foreach($members as $n){
            $n->balance = $n->splitsAsCrediteur()->where('status','=','unpaid')->sum('part') - $n->splitsAsDebuteur()->where('status','=','unpaid')->sum('part');
            $n->save();
        }


    }
}
