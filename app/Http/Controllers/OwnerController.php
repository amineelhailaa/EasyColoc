<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Colocation;
use App\Models\Membership;
use App\Models\Split;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $membership = auth()->user()->membership;
        $myBalance = $membership->balance;
        $colocation = $membership->colocation;
        $year = $request->get("year");
        $month = $request->get("month");
        //expenses
//        dd($year, $month);
        if($year && $month){
            $expenses = $colocation->expenses()->with('membership.user','category')
                ->whereYear('date', $year)->whereMonth('date', $month)
                ->latest('date')->get();
//            dd($expenses, $year, $month);
        } else {
            $expenses= $colocation->expenses()->with('membership.user','category')
                ->latest()->limit(5)->get();
        }

        $totalSpent = $colocation->expenses()->sum('amount');
        $totalExpenses = $colocation->expenses()->count();

        //members
        $members = $colocation->memberships()->with('user')->where('status','active')->where('user_id','!=',auth()->id())->get();
        $totalMembers = $members->count()+1;

        //categories
        $categories = $colocation->categories ?? collect(); //fr count
        $totalCategories = $categories->count();

        $owes = $colocation->splits()->where('status','unpaid')->get();
        //adding reputation
        $reputation = auth()->user()->reputation;

        return view('colocation.owner.dashboard',compact(
            'membership',
            'reputation',
            'myBalance',
            'colocation',
            'expenses',
            'totalSpent',
            'totalExpenses',
            'totalMembers',
            'members',
            'totalCategories',
            'categories',
            'owes',
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    //manage categories
    public function destroy(Category $category)
    {
        $colocation = auth()->user()->membership->colocation;
        $colocation->categories()->findOrFail($category->id);
        $category->delete();
        return redirect()->back();
    }

    //store categories
    public function store(Request $request)
    {
        $membership = auth()->user()->membership;
        $colocation = $membership->colocation;
        $request->validate([
            'name' => 'required|string',
        ]);
        $colocation->categories()->create([
            'name' => $request->name,
        ]);

        return redirect()->back();
    }


    public function annulerColocation(Request $request){
       $owner=$request->user()->membership;
       $owner->colocation->update([
       'status','inactive']);
       $owner->colocation->memberships()->update(['status'=>'inactive ']);
       return redirect()->back();
    }

    public function KickMember(Membership $member)
    {
        $owner = auth()->user()->membership;
        if($member->colocation->id != $owner->colocation->id || $owner->id === $member->id || $member->status === 'inactive'){
            abort(404);
        }
        if ($member->balance<0){
            $member->user->reputation -= 1;
        } else {
            $member->user->reputation += 1;
        }
        $this->kickEdits($member,$owner);
        $member->update(['status' => 'inactive',
            'left_at'=>now()
        ]);
        return redirect()->back();
    }





    // my functions


    public function kickEdits(Membership $member, Membership $owner)
    {
       $colocation = $owner->colocation;


      $members =  $owner->colocation->memberships()->where('status','active')->wherenotIn('id',[$owner->id,$member->id])->get();

      foreach($members as $m){

          $net = $m->splitsAsCrediteur()->where('debuteur_id',$owner->id)->where('status','=','unpaid')->sum('part')
              - $owner->splitsAsCrediteur()->where('debuteur_id',$m->id)->where('status','=','unpaid')->sum('part')
              +$m->splitsAsCrediteur()->where('debuteur_id',$member->id)->where('status','=','unpaid')->sum('part')
              - $member->splitsAsCrediteur()->where('debuteur_id',$m->id)->where('status','=','unpaid')->sum('part');

          $this->deleteSplitsBetweenTwo($member,$m);
          $this->deleteSplitsBetweenTwo($owner,$m);

          if($net != 0){
              if($net > 0){
                  $id1 = $owner->id;
                  $id2 = $m->id;
              } else if($net<0) {
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

      $this->deleteSplitsBetweenTwo($owner,$member);


      foreach ($members as $n) {
          $n->balance = $n->splitsAsCrediteur()->where('status','=','unpaid')->sum('part') - $n->splitsAsDebuteur()->where('status','=','unpaid')->sum('part');
          $n->save();
      }
      $owner->balance= $owner->splitsAsCrediteur()->where('status','=','unpaid')->sum('part') - $owner->splitsAsDebuteur()->where('status','=','unpaid')->sum('part');
      $owner->save();











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
      }
//
//
//
//
//      return redirect()->back();


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



}
