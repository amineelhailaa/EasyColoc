<?php

namespace App\Services;
use App\Models\Expense;
use App\Models\Membership;
use App\Models\Split;
use App\Models\User;
use function Laravel\Prompts\select;

class ExpenseService
{
    /**
     * Create a new class instance.
     */
    public function createwithSplits($request)
    {
        $member = Membership::find($request->membership_id);
        $expense = $member->colocation->expenses()->create([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'category_id' => $request->category_id,
            'membership_id' => $request->membership_id,
        ]);
        $Ids = $expense->colocation->memberships()->where('status','=','active')->pluck('id')->all(); //the all for getting array [1,2,3,4]
        $quota = $expense->amount/count($Ids); //member

        //
        //9sm quota per every user
        foreach ($expense->colocation->memberships()->where('status','active')->get() as $m) {
            if($m->id != $request->membership_id){
                $m->balance = $m->balance - $quota;
                $member->balance += $quota;
                $m->save();
            }
        }
        $member->save();

        //

        foreach ($Ids as $Id) {
            if($member->id!=$Id){

                $split1 = $member->splitsAsCrediteur()->where('debuteur_id','=',$Id)->where('status','=','unpaid')->first(); //ana li kansal
                $split2 = $member->splitsAsdebuteur()->where('crediteur_id','=',$Id)->where('status','=','unpaid')->first(); //ana li khsni nkhls
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
