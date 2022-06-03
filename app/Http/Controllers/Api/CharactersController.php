<?php
   
namespace App\Http\Controllers\Api;
   
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController as BaseController;
use Validator;
use App\Models\Character;
use App\Http\Resources\Character as CharacterResource;
   
class CharactersController extends BaseController
{
    public function index()
    {
        $characters = Character::all();
        return $this->sendResponse(CharacterResource::collection($characters), 'Posts fetched.');
    }
    
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string|min:3',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $character = Character::create($input);
        return $this->sendResponse(new CharacterResource($character), 'Personaje creado.');
    }
   
    public function show($id)
    {
        $character = Character::find($id);
        if (is_null($character)) {
            return $this->sendError('Personaje no existe.');
        }
        return $this->sendResponse(new CharacterResource($character), 'Datos del personaje.');
    }
    
    public function update(Request $request, Character $character)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
           'name' => 'required|string|min:3',
        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors());       
        }
        $character->title = $input['name'];
        //$character->description = $input['description'];
        $character->save();
        
        return $this->sendResponse(new CharacterResource($character), 'Personaje actualizado.');
    }
   
    public function destroy(Character $character)
    {
        $character->delete();
        return $this->sendResponse([], 'Personaje eliminado.');
    }
}