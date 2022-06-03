<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Models\User;
use App\Http\Resources\User as UserResource;
use App\Utils\ExternalData as ExternalData; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
   
class UsersController extends BaseController
{
    public function index()
    {
        $users = User::all();
        return $this->sendResponse(UserResource::collection($users), 'Usuarios consultados.');
    }
    
    public function store(Request $request)
    {  
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => [
                'required', 'string', 'min:3', 'max:255',
            ],
            'email' => [
                'required', 'string', 'min:5', 'unique:users', 'email', 'max:255'
            ],
            'password' => [
                'required', 'string', 'min:8',
            ],
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $input["password"] = Hash::make($input["password"]);

        $user = User::create($input);
        return $this->sendResponse(new UserResource($user), 'Usuario creado.');
    }
   
    public function show($id)
    {
        $user = User::find($id);
        if (is_null($user)) {
            return $this->sendError('Usuario no existe.');
        }
        return $this->sendResponse(new UserResource($user), 'Datos del usuario.');
    }
    
    public function update(Request $request, User $user)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
           'name' => 'required|string|min:3',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }

        $user->update($input);
        
        return $this->sendResponse(new UserResource($user), 'Usuario actualizado.');
    }
   
    public function destroy(User $user)
    {
        $user->delete();
        return $this->sendResponse([], 'Usuario eliminado.');
    }
}