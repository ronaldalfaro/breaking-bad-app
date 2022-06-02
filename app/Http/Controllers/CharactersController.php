<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Character;
use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\UpdateCharacterRequest;

class CharactersController extends Controller
{
    protected $BREAKING_BAD_API_URL = "https://www.breakingbadapi.com/api/characters";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $characters = Character::all();

        return view('characters.index', compact('characters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('characters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCharacterRequest $request)
    {
        $requestData = $this->retrieveData($request);

        if($request->validated()){
            Character::create($requestData);
        }
        
        return redirect()->route('characters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Character $character)
    {
        return view('characters.show', compact('character'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Character $character)
    {
        return view('characters.edit', compact('character'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCharacterRequest $request, Character $character)
    {

        $character->update($request->validated());

        return redirect()->route('characters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Character $character)
    {
         $character->delete();

        return redirect()->route('characters.index');
    }

    public function home()
    {
        $characters = Character::all();

        return view('characters.home', compact('characters'));
    }

    private function retrieveData(StoreCharacterRequest $request){
        $response = Http::get($this->BREAKING_BAD_API_URL, ['name' => $request->name]);
        $requestData = $request->all();
        if($response->successful()){
            $charactersArray = $response->json($key = null);
            if(is_array($charactersArray) && !empty($charactersArray)){
                $firstResult = $response[0];
                          
                $requestData["name"] = $firstResult['name'];
                $requestData = array_merge($requestData, ['nickname' => $firstResult['nickname'], 'img' => $firstResult['img'], 'category' => $firstResult['category']]);
            }else{
                $requestData = array_merge($requestData, ['nickname' => "No hay datos", 'img' => "No hay datos", 'category' => "No hay datos"]);
            }
            
        }

        return $requestData;
    }
}
