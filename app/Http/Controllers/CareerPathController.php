<?php
namespace App\Http\Controllers;

use App\Models\CareerPath;
use App\Models\Section;
use App\Models\Career;
use Illuminate\Http\Request;

class CareerPathController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections    = Section::all();
        $careerpaths = CareerPath::with(['section', 'careers'])->paginate(10);
        return view('admin.careerpath.index', compact('sections', 'careerpaths'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = \App\Models\Section::all();
        $careers = \App\Models\Career::all();
        $career_categories = \App\Models\CareerCategory::all();
        return view('admin.careerpath.create', compact('sections', 'careers', 'career_categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        //dd($request->all());
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'careers'    => 'required|array',
            // 'careers.*'  => 'exists:careers,id',
        ]);

        $careerPath = CareerPath::create([
            'section_id' => $request->section_id,
        ]);

        // Attach selected careers
        $careerPath->careers()->attach($request->careers);

        // dd($careerPath);

        return redirect()->route('careerpath.index')->with('success', 'Career Path created successfully!');
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
        $career   = CareerPath::findOrFail($id);
        $sections = Section::all();
        $careers = \App\Models\Career::all();
        $career_categories = \App\Models\CareerCategory::all();
        return view('admin.careerpath.edit', compact('career', 'sections', 'careers', 'career_categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $career = CareerPath::findOrFail($id);

        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'careers'    => 'required|array',
        ]);

        $career->update([
            'section_id' => $request->section_id,
        ]);

        // Sync selected careers
        $career->careers()->sync($request->careers);

        return redirect()->route('careerpath.index')->with('success', 'Career Path updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $career = CareerPath::findOrFail($id);
        $career->delete();

        return redirect()->route('careerpath.index')->with('success', 'Career deleted successfully.');
    }
}
