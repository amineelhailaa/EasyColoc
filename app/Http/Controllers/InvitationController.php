<?php

namespace App\Http\Controllers;

use App\Mail\InvitationMail;
use App\Models\Invitation;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class InvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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
    public function store(Request $request)
    {
        //request will have only the email of the participant
        //illcreate token , create url and email and put this in database , hundle accepting in another query

        $token = Str::random(15);
        $data =  $request->validate(
            ['email'=> 'email|required']);



        // null with fn safe
        $colocation = auth()->user()->membership->colocation;
        Invitation::create([
            'token' => $token,
            'email' => $data['email'],
            'colocation_id' => $colocation->id,
        ]);
        $urlToSend = URL::temporarySignedRoute(
            'invitation.show', now()->addDays(1), ['token' => $token , 'email' => $data['email']]
        );
        //igot url now lets send thissh
        Mail::to($data['email'])->send(new InvitationMail($urlToSend));
        return redirect()->back();
    }

    public function accept(Request $request){
        $token = $request->token;
        $email = $request->email;
        $invitation = Invitation::where('token', $token)->where('email',$email)->firstOrFail();
        $invitation->update([
            'status' => 'accepted'
        ]);
        $colocation = $invitation->colocation;
        $colocation->memberships()->create([
            'status'=> 'active',
            'user_id'=> auth()->id(),
        ]);
       return redirect()->route('member.dashboard');

    }

    public  function decline(Request $request){
        $token = $request->token;
        $email = $request->email;
        $invitation = Invitation::where('token', $token)->where('email',$email)->firstOrFail();
        $invitation->update([
            'status' => 'rejected'
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $token)
    {
        $invitation = Invitation::where('token', $token)->where('status','pending')->firstOrFail();
        $colocation = $invitation->colocation;


        return view('invitation.show', ['token' => $token , 'email' => $request->email , 'colocation' => $colocation]);
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
    public function destroy(string $id)
    {
        //
    }
}
