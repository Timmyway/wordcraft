<?php

namespace App\Http\Controllers;

use App\Models\IrregularVerb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IrregularVerbController extends Controller
{

    public function indexPage(Request $request)
    {
        // Pass filter parameters to the view
        return Inertia::render('IrregularVerbs/VerbList');
    }

    /**
     * Get all irregular verbs
     */
    public function list(Request $request): JsonResponse
    {
        // Get the 'per_page' and 'page' query parameters with defaults
        $perPage = $request->input('per_page', 10); // Default to 10 items per page
        $page = $request->input('page', 1); // Default to the first page

        // Retrieve paginated results
        $verbs = IrregularVerb::paginate($perPage);

        return response()->json($verbs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'verb' => 'required|string|max:255',
            'past_simple' => 'required|string|max:255',
            'past_participle' => 'required|string|max:255',
        ]);

        $verb = IrregularVerb::create($request->all());
        return response()->json($verb, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(IrregularVerb $irregularVerb): JsonResponse
    {
        return response()->json($irregularVerb);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IrregularVerb $irregularVerb): JsonResponse
    {
        $request->validate([
            'verb' => 'string|max:255',
            'past_simple' => 'string|max:255',
            'past_participle' => 'string|max:255',
        ]);

        $irregularVerb->update($request->all());
        return response()->json($irregularVerb);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IrregularVerb $irregularVerb): JsonResponse
    {
        $irregularVerb->delete();
        return response()->json(null, 204);
    }
}
