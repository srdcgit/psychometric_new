<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Career;
use App\Models\CareerCategory;
use App\Models\Section;
use App\Models\CareerPath;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::with('careerCategory')->paginate(10);
        return view('admin.career.index', compact('careers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $career_categories = CareerCategory::all();
        return view('admin.career.create', compact('career_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'career_category_id' => 'required|exists:career_categories,id',
            'name'       => 'required|string',
        ]);

        Career::create([
            'name'       => $request->name,
            'career_category_id' => $request->career_category_id,
        ]);

        return redirect()->route('career.index')->with('success', 'Career created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $career = Career::find($id);
        $career_categories = CareerCategory::all();
        return view('admin.career.edit', compact('career', 'career_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $career = Career::find($id);
        $career->name = $request->name;
        $career->career_category_id = $request->career_category_id;
        $career->save();
        return redirect()->route('career.index')->with('success', 'Career updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $career = Career::find($id);
        $career->delete();
        return redirect()->route('career.index')->with('success', 'Career deleted successfully');
    }
}
