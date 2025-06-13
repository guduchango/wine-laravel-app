<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\Wine;


class WinePhotoController extends Controller
{
    public function store(Request $request, Wine $wine)
    {
        $request->validate([
            'photo' => 'required|image|max:2048', // hasta 2MB
        ]);

        $path = $request->file('photo')->store('wine_photos', 'public');

        $photo = $wine->photos()->create([
            'path' => $path,
        ]);

        return response()->json([
            'message' => 'Photo uploaded successfully.',
            'photo' => $photo,
        ], 201);
    }

    public function multiStore(Request $request, Wine $wine)
    {
        $request->validate([
            'photos.*' => 'required|image|max:2048',
        ]);

        $uploadedPhotos = [];

        foreach ($request->file('photos', []) as $photo) {
            $path = $photo->store('wine_photos', 'public');

            $photoModel = $wine->photos()->create([
                'path' => $path,
            ]);

            $uploadedPhotos[] = $photoModel;
        }

        return response()->json([
            'message' => 'Photos uploaded successfully.',
            'photos' => $uploadedPhotos,
        ], 201);
    }

    public function destroy(Request $request, int $id)
    {
        $photo = Photo::findOrFail($id);
        Storage::disk('public')->delete($photo->path);
        $photo->delete();

        return response()->json([
            'message' => 'Photo deleted successfully.',
        ]);
    }

    public function index(Wine $wine)
    {
        return response()->json($wine->photos);
    }
}
