<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;

class AuthController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Datos ingresados son incorrectos', $validator->errors());       
        }

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        $success['access_token'] =  $user->createToken('auth_token')->plainTextToken; 
        $success['name'] =  $user->name;
        $success['token_type'] =  'Bearer';
   
        return $this->sendResponse($success, 'Usuario creado correctamente.');
        
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }

        $authUser = Auth::user();
        $success['access_token'] =  $authUser->createToken('auth_token')->plainTextToken; 
        $success['name'] =  $authUser->name;
        $success['token_type'] =  'Bearer';

        return $this->sendResponse($success, 'Usuario logueado correctamente');
    }

    public function logout(Request $request)
    {
        $authUser = $request->user();    
        if($authUser->currentAccessToken()){
            $authUser->currentAccessToken()->delete();

            $success['access_token'] = null;

            return $this->sendResponse($success, 'Sesión cerrada correctamente');
        }else{
            return $this->sendError('Unauthorized.', ['error'=>'Unauthorized']);
        }
    }
}
