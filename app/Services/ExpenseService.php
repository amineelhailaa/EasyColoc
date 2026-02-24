<?php

namespace App\Services;
use App\Models\Expense;
use App\Models\Membership;
use App\Models\User;
use function Laravel\Prompts\select;

class ExpenseService
{
    /**
     * Create a new class instance.
     */
    public function createwithSplits($request)
    {
        $member = User::find($request->membership_id)->membership;
        $expense = $member->colocation->expenses()->create([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'category_id' => $request->category_id,
            'membership_id' => $request->user_id,
        ]);
        $Ids = $expense->colocation->memberships()->pluck('id')->all(); //the all for getting array [1,2,3,4]
        $quota = $expense->amount/count($Ids); //member
        foreach ($Ids as $Id) {
            if($member->id!=$Id){

                $split1 = $member->splitsAsCrediteur()->where('debuteur_id','=',$Id)->first(); //ana li kansal
                $split2 = $member->splitsAsdebuteur()->where('crediteur_id','=',$Id)->first(); //ana li khsni nkhls
                if($split1){
                    $split1->part += $quota;
                    $split1->save();
                } // check wx kayna xi split li fiha l user li khalas howa crediteur o lakhor howa debiteur
                elseif($split2){  //ana li khsni nkhls
                    $temp = $split2->part - $quota; //dkxi li kitsaloni n9s mno dkxi li khlst
                    if($temp<0){ //ela kan tht 0 ya3ni khsni nwli ana li crediteur
                        $split2->crediteur_id = $member->id;
                        $split2->debuteur_id = $Id;
                        $split2->part = (-$temp);

                    } else { //ela kan tht
                        $split2->part -= $quota;
                    }
                    $split2->save();
                } else {
                    $expense->colocation->splits()->create([
                        'part' => $quota,
                        'debuteur_id' => $Id,
                        'crediteur_id' => $member->id,
                    ]);

                }


            }

        }

    }
}
