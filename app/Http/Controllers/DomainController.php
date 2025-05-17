<?php

namespace App\Http\Controllers;

use App\Models\Domain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $domains = Domain::where('uploaded_by', $user->id)->paginate(10);
        return view('admin.domain.index', compact('domains'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.domain.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:domains,name',
            'description' => 'nullable|string',
            'scoring_type' => 'nullable|string',
        ]);

        Domain::create([
            'name' =>$request->name,
            'description' =>$request->description,
            'scoring_type' =>$request->scoring_type,
            'uploaded_by' => Auth::user()->id,
        ]);

        return redirect()->route('domain.index')->with('success', 'Domain created successfully!');
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
        $domain = Domain::findOrFail($id);
        return view('admin.domain.edit', compact('domain'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $domain = Domain::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:domains,name,' . $domain->id,
            'description' => 'nullable|string',
            'scoring_type' => 'nullable|string',
        ]);

        $domain->update($request->all());

        return redirect()->route('domain.index')->with('success', 'Domain updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $domain = Domain::findOrFail($id);
        $domain->delete();

        return redirect()->route('domain.index')->with('success', 'Domain deleted successfully!');
    }
}
