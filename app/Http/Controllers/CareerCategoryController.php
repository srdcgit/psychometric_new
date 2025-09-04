<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CareerCategory;

class CareerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $careercategories = CareerCategory::paginate(10);
        return view('admin.careercategory.index', compact('careercategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.careercategory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'hook' => 'nullable|string',
            'what_is_it' => 'nullable|string',
            'example_roles' => 'nullable|string',
            'subjects' => 'nullable|string',
            'core_apptitudes_to_highlight' => 'nullable|string',
            'value_and_personality_edge' => 'nullable|string',
            'why_it_could_fit_you' => 'nullable|string',
            'early_actions' => 'nullable|string',
            'india_study_pathways' => 'nullable|string',
            'future_trends' => 'nullable|string',
        ]);

        CareerCategory::create(
            collect($validated)->only([
                'name',
                'hook',
                'what_is_it',
                'example_roles',
                'subjects',
                'core_apptitudes_to_highlight',
                'value_and_personality_edge',
                'why_it_could_fit_you',
                'early_actions',
                'india_study_pathways',
                'future_trends',
            ])->toArray()
        );

        return redirect()->route('careercategory.index')->with('success', 'Career Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $career = CareerCategory::find($id);
        return view('admin.careercategory.show', compact('career'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $career = CareerCategory::find($id);
        return view('admin.careercategory.edit', compact('career'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'hook' => 'nullable|string',
            'what_is_it' => 'nullable|string',
            'example_roles' => 'nullable|string',
            'subjects' => 'nullable|string',
            'core_apptitudes_to_highlight' => 'nullable|string',
            'value_and_personality_edge' => 'nullable|string',
            'why_it_could_fit_you' => 'nullable|string',
            'early_actions' => 'nullable|string',
            'india_study_pathways' => 'nullable|string',
            'future_trends' => 'nullable|string',
        ]);

        $career = CareerCategory::find($id);
        $career->update(
            collect($validated)->only([
                'name',
                'hook',
                'what_is_it',
                'example_roles',
                'subjects',
                'core_apptitudes_to_highlight',
                'value_and_personality_edge',
                'why_it_could_fit_you',
                'early_actions',
                'india_study_pathways',
                'future_trends',
            ])->toArray()
        );
        return redirect()->route('careercategory.index')->with('success', 'Career Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $career = CareerCategory::find($id);
        $career->delete();
        return redirect()->route('careercategory.index')->with('success', 'Career Category deleted successfully');
    }
}
