<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdvertisingGuideController extends Controller
{
    public function index()
    {
        return view('advertising-guide.index');
    }

    public function points()
    {
        $ads = Advertisement::where('status', 'active')
            ->select('id', 'street_name', 'lat', 'lng', 'type', 'height', 'size', 'description')
            ->get();
        return response()->json($ads);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'street_name' => 'required|string|max:255',
            'lat'         => 'required|numeric|between:-90,90',
            'lng'         => 'required|numeric|between:-180,180',
            'type'        => 'required|string|max:100',
            'height'      => 'nullable|numeric|min:0',
            'size'        => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = auth()->id();
        $ad = Advertisement::create($validated);

        Log::info('Advertisement created', ['id' => $ad->id, 'user' => auth()->id()]);

        return response()->json($ad);
    }

    public function update(Request $request, Advertisement $ad)
    {
        $validated = $request->validate([
            'street_name' => 'required|string|max:255',
            'lat'         => 'required|numeric|between:-90,90',
            'lng'         => 'required|numeric|between:-180,180',
            'type'        => 'required|string|max:100',
            'height'      => 'nullable|numeric|min:0',
            'size'        => 'nullable|string|max:100',
            'description' => 'nullable|string|max:1000',
        ]);

        $ad->update($validated);
        return response()->json($ad);
    }

    public function destroy(Advertisement $ad)
    {
        $ad->update(['status' => 'inactive']);
        return response()->json(['message' => 'done']);
    }
}
