<?php

namespace App\Http\Controllers;

use App\Models\Wine;
use Illuminate\Http\Request;

class WineController extends Controller
{
    public function index()
    {
        return auth()->user()->wines;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'winery' => 'required|string',
            'variety' => 'required|string',
            'vintage' => 'required|integer',
            'country' => 'required|string',
        ]);

        $wine = auth()->user()
            ->wines()
            ->create($request->only(['name', 'winery', 'variety','vintage','country']));


        return response()->json($wine, 201);
    }

    public function find($id)
    {
        $wine = auth()->user()->wines()->findOrFail($id);

        return response()->json($wine);
    }

    public function update(Request $request, $id)
    {
        $wine = auth()->user()->wines()->findOrFail($id);

        $wine->update($request->only(['name', 'winery', 'variety','vintage','country']));

        return response()->json($wine);
    }

    public function destroy($id)
    {
        $wine = auth()->user()->wines()->findOrFail($id);
        $wine->delete();

        return response()->json(['message' => 'Wine deleted']);
    }
}
