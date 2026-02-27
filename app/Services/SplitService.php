<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\Split;
use Illuminate\Database\Eloquent\Builder;

class SplitService
{
    /**
     * Create a new class instance.
     */

    function deleteSplitsBetweenTwo($m1,$m2)
    {
        Split::where(function (Builder $query) use ($m1,$m2) {
            $query->where('crediteur_id',$m1->id)
                ->where('debuteur_id',$m2->id)->where('status','=','unpaid');
        })->orWhere(
            function (Builder $query) use ($m1,$m2) {
                $query->where('crediteur_id',$m2->id)
                    ->where('debuteur_id',$m1->id)->where('status','=','unpaid');}
        )->delete();
    }

    public function kickEdits(Membership $member, Membership $owner)
    {

        $this->editReputation($member);

        $colocation = $owner->colocation;
        $members = $owner->colocation->memberships()->where('status', 'active')->wherenotIn('id', [$owner->id, $member->id])->get();

        foreach ($members as $m) {

            $net = $m->splitsAsCrediteur()->where('debuteur_id', $owner->id)->where('status', '=', 'unpaid')->sum('part')
                - $owner->splitsAsCrediteur()->where('debuteur_id', $m->id)->where('status', '=', 'unpaid')->sum('part')
                + $m->splitsAsCrediteur()->where('debuteur_id', $member->id)->where('status', '=', 'unpaid')->sum('part')
                - $member->splitsAsCrediteur()->where('debuteur_id', $m->id)->where('status', '=', 'unpaid')->sum('part');

            $this->deleteSplitsBetweenTwo($member, $m);
            $this->deleteSplitsBetweenTwo($owner, $m);

            if ($net != 0) {
                if ($net > 0) {
                    $id1 = $owner->id;
                    $id2 = $m->id;
                } else if ($net < 0) {
                    $id1 = $m->id;
                    $id2 = $owner->id;
                }
                $colocation->splits()->create([
                    'part' => abs($net),
                    'debuteur_id' => $id1,
                    'crediteur_id' => $id2,
                ]);
            }


        }

        $this->deleteSplitsBetweenTwo($owner, $member);


        foreach ($members as $n) {
            $n->balance = $n->splitsAsCrediteur()->where('status', '=', 'unpaid')->sum('part') - $n->splitsAsDebuteur()->where('status', '=', 'unpaid')->sum('part');
            $n->save();
        }
        $owner->balance = $owner->splitsAsCrediteur()->where('status', '=', 'unpaid')->sum('part') - $owner->splitsAsDebuteur()->where('status', '=', 'unpaid')->sum('part');
        $owner->save();

        $member->update(['status' => 'inactive',
            'left_at'=>now()
        ]);
    }











//
////        $owner->balance = $owner->splitsAsCrediteur()->sum('part')->get() - $owner->splitsAsDebuteur()->sum('part')->get();
//
//
//        //change my status
//      $mouad->membership()->update([
//          'status' => 'inactive',
//          'left_at' => now(),
//      ]);
//
//
//
//      $mouad->membership->splitsAsCrediteur()->update(['crediteur_id' => $owner->id]);
//
//      $asDebuteurSplits = $mouad->membership->splitsAsDebuteur()->where('status','unpaid')->get();
//      $asCrediteurSplits = $mouad->membership->splitsAsCrediteur()->where('status','unpaid')->get();
//
//
//
//
//
//
//
//      foreach ($asCrediteurSplits as $split) {
//          $exist = $owner->splitsAsCrediteur()->where(['debuteur_id',$split->debuteur_id])->first();
//          if ($exist) {
//              $exist->part += $split->part;
//              $exist->save();
//              $split->delete();
//          } else {
//              $split->crediteur_id = $owner->id;
//              $split->save();
//          }
//
//          $owner->balance += $split->part;
//      }
//
//      foreach ($asDebuteurSplits as $split) {
//          $exist = $owner->splitsAsDebuteur()->where(['crediteur_id',$split->crediteur_id])->first();
//
//          if ($exist) {
//              if($exist->part < $split->part){
//
//              } else {
//                  $exist->part -= $split->part;
//                  $exist->save();
//
//              }
//
//          }
//


    public function editReputation(Membership $member)
    {
        if ($member->balance<0){
            $member->user->reputation -= 1;
        } else {
            $member->user->reputation += 1;
        }
        $member->user->save();
    }


}
