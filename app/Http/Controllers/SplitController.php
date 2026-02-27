<?php

namespace App\Http\Controllers;

use App\Models\Split;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SplitController extends Controller
{
    //
    public function marquerPayee(Request $request){
        //validation after
        $membership= $request->user()->membership;
        $owe = Split::query()->where(function (Builder $query) use ($membership) {
            $query->where('crediteur_id',$membership->id)->orWhere('debuteur_id',$membership->id);
        })->findOrFail($request->owe_id);

//        if($owe->debuteur_id !== $membership->id){
//            abort(403);
//        } hta confirmer prof

        $owe->status = 'paid';
        $owe->save();
        $owe->debuteur->balance += $owe->part;
        $owe->debuteur->save();
        $owe->crediteur->balance -= $owe->part;
        $owe->crediteur->save();
        return redirect()->back();
    }
}
