<?php

namespace App\Http\Controllers;

use App\Models\Split;
use Illuminate\Http\Request;

class SplitController extends Controller
{
    //
    public function marquerPayee(Request $request){
        //validation after
        $owe = Split::query()->findOrFail($request->owe_id);
        $owe->status = 'paid';
        $owe->save();
        $owe->debuteur->balance += $owe->part;
        $owe->debuteur->save();
        $owe->crediteur->balance -= $owe->part;
        $owe->crediteur->save();
        return redirect()->back();
    }
}
