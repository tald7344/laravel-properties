<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PropertyFavoriteController extends Controller
{
    public function store(Request $request, Property $property): JsonResponse
    {
        abort_unless($property->status === 'published', 404);

        $request->user()->favoriteProperties()->syncWithoutDetaching([$property->id]);

        return response()->json(['favorited' => true]);
    }

    public function destroy(Request $request, Property $property): JsonResponse
    {
        abort_unless($property->status === 'published', 404);

        $request->user()->favoriteProperties()->detach($property->id);

        return response()->json(['favorited' => false]);
    }
}
