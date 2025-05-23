<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $sections = Section::where('uploaded_by', $user->id)->with('domain')->paginate(10);
        return view('admin.section.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $domains = Domain::all();
        return view('admin.section.create', compact('domains'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'domain_id' => 'required|exists:domains,id',
            'keytraits' => 'nullable|string',
            'enjoys' => 'nullable|string',
            'idealenvironments' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        Section::create([
            'name' => $request->name,
            'domain_id' => $request->domain_id,
            'keytraits' => $request->keytraits,
            'enjoys' => $request->enjoys,
            'idealenvironments' => $request->idealenvironments,
            'description' => $request->description,
            'uploaded_by' => Auth::id(),
        ]);

        return redirect()->route('section.index')->with('success', 'Section created successfully.');
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
        $section = Section::findOrFail($id);
        $domains = Domain::all();
        return view('admin.section.edit', compact('section', 'domains'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $section = Section::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'domain_id' => 'required|exists:domains,id',
            'keytraits' => 'nullable|string',
            'enjoys' => 'nullable|string',
            'idealenvironments' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $section->update($request->all());

        return redirect()->route('section.index')->with('success', 'Section updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = Section::findOrFail($id);
        $section->delete();

        return redirect()->route('section.index')->with('success', 'Section deleted successfully.');
    }
}
