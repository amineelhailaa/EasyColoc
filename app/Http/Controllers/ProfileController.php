<?php

namespace App\Http\Controllers;

use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('profile.update',['user'=>auth()->user()]);
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
        //
    }

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
    public function update(ProfileUpdateRequest $request)
    {
//        dd($request);
        $data = ['name' => $request->name, 'email' => $request->email];
        if ($request->hasFile('avatar')) {
            ImageUploadService::delete(auth()->user()->avatar);
            $data['avatar'] = ImageUploadService::upload($request->file('avatar'), 'avatars');
        }
        auth()->user()->update($data);
        return redirect()->route('profile.view');
    }

    public function updatePassword(PasswordUpdateRequest $request){
        auth()->user()->update(['password' => Hash::make($request->password)]);
        return redirect()->route('profile.view');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
