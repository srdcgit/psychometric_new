<?php
namespace App\Http\Controllers;

use App\Models\CareerPath;
use App\Models\Section;
use Illuminate\Http\Request;

class CareerPathController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections    = Section::all();
        $careerpaths = CareerPath::with('section')->paginate(10);
        return view('admin.careerpath.index', compact('sections', 'careerpaths'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        return view('admin.careerpath.create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'name'       => 'required|string',
        ]);

        CareerPath::create([
            'name'       => $request->name,
            'section_id' => $request->section_id,
        ]);

        return redirect()->route('careerpath.index')->with('success', 'Career created successfully!');

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
        return view('admin.careerpath.edit', compact('career', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $career = CareerPath::findOrFail($id);

        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'name'       => 'required|string',
        ]);

        $career->update([
            'name'       => $request->name,
            'section_id' => $request->section_id,
        ]);

        return redirect()->route('careerpath.index')->with('success', 'Career updated successfully.');
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
