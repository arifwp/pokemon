<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Pokemon;

class PokemonController extends Controller
{
    public function catchPokemon(Request $request) {
        $validator = Validator::make($request->all(), [
            'pokemon_id' => 'required',
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 422);
        }

        $probability = rand(1,100);
        if($probability <= 50){
            $newName = $request->name . "-" . $this->generateFibonacci(10);;
            return response()->json([
                "message" => "Succed rename",
                "new_name"=> $newName
            ]);
        } else {
            return response()->json([
                "message" => "Failed rename",
                "new_name"=> null
            ]);
        }
    
    }

    public function releasePokemon() {
        $primeNumber = $this->generatePrimeNumber();
        if($primeNumber != null){
            return response()->json([
                "prime_number" => $primeNumber
            ]);
        } else {
            return response()->json([
                "prime_number" => null
            ]);
        }
        
    }

    private function generateFibonacci($n){
        return $n == 0 ? 0 : ($n == 1 ? 1 : $this->generateFibonacci($n - 1) + $this->generateFibonacci($n - 2));
    }

    private function generatePrimeNumber(){
        $probability = rand(1,100);
        if ($probability == 1)
        return null;
        for ($i = 2; $i <= $probability/2; $i++){
            if ($probability % $i == 0)
                return null;
        }
        return $probability;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pokemon_id' => 'required',
            'name' => 'required',
            'img' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 422);
        }

        $pokemon = Pokemon::create([
            'pokemon_id'=> $request->pokemon_id,
            'name'=> $request->name,
            'img' => $request->img
        ]);

        return response()->json([
            'message' => 'Successfully insert pokemon',
            'data' => $pokemon
        ]);
    }


}
