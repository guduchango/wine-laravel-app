<?php

namespace App\Http\Controllers;

use App\Models\Wine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WineController extends Controller
{
    public function index()
    {
        return auth()->user()->wines;
    }

    public function store(Request $request)
    {
        $request->validate($this->getValidateRules());

        $wine = auth()->user()
            ->wines()
            ->create($request->only(
                $this->getFields()
            ));

        return response()->json($wine, 201);
    }

    public function find($id)
    {
        $user = auth()->user();
        Log::info("id {$id} user_id {$user->id}");
        $wine = Wine::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        return response()->json($wine);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->getValidateRules());

        $wine = auth()->user()->wines()->findOrFail($id);

        $wine->update($request->only(
            $this->getFields()
        ));

        return response()->json($wine);
    }

    public function destroy($id)
    {
        $wine = auth()->user()->wines()->findOrFail($id);

        $wine->delete();

        return response()->json(['message' => 'Wine deleted']);
    }

    protected function getValidateRules(){
        return [
            'name' => 'required|string',
            'variety' => 'required|string',
            'vintage' => 'required|integer',
            'alcohol' => 'required|numeric',
            'price' => 'required|numeric',
            'color' => 'required|string',
            'aroma' => 'required|string',
            'sweetness' => 'required|string',
            'acidity' => 'required|string',
            'tannin' => 'required|string',
            'body' => 'required|string',
            'persistence' => 'required|string',
            'score' => 'required|string',
            'tasted_day' => 'required'
        ];
    }

    protected function getFields(){
        return [
            'name',
            'variety',
            'vintage',
            'alcohol',
            'price',
            'color',
            'aroma',
            'sweetness',
            'acidity',
            'tannin',
            'body',
            'persistence',
            'score',
            'tasted_day'
        ];
    }
}
