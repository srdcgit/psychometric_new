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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        CareerCategory::create($request->all());

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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $career = CareerCategory::find($id);
        $career->update($request->all());
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
