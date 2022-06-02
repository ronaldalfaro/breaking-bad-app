<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UpdatePasswordRequest;

class PasswordController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return view('password.edit', compact('id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(UpdatePasswordRequest $request, int $id)
    {
        $requestData = $request->all();
        $user = User::findOrFail($id);

        if($request->validated() && isset($user)){
            $requestData["password"] = Hash::make($requestData["password"]);
            $user->update($requestData);
        }

        return redirect()->route('users.index');
    }
}
