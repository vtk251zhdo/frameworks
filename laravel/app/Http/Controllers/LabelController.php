<?php

namespace App\Http\Controllers;

use App\Models\Label;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Label::all());
    }

    public function show(int $id): JsonResponse
    {
        $label = Label::find($id);

        if (!$label) {
            return response()->json(['message' => 'Label not found'], 404);
        }

        return response()->json($label);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        $label = Label::create($data);

        return response()->json($label, 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $label = Label::find($id);

        if (!$label) {
            return response()->json(['message' => 'Label not found'], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean',
        ]);

        $label->update($data);

        return response()->json($label);
    }

    public function destroy(int $id): JsonResponse
    {
        $label = Label::find($id);

        if (!$label) {
            return response()->json(['message' => 'Label not found'], 404);
        }

        $label->delete();

        return response()->json(null, 204);
    }
}
