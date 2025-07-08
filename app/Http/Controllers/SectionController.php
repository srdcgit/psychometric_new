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
        $sections = Section::where('uploaded_by', $user->id)->orderBy('id', 'desc')->with('domain')->paginate(10);
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
        $domainInput = $request->input('domain_id');
        $specialDomains = ['OCEAN', 'Work Values'];
        
        // If the domain is a special one, fetch its ID by name
        if (in_array($domainInput, $specialDomains)) {
            $domain = \App\Models\Domain::where('name', $domainInput)->first();
            if (!$domain) {
                return back()->withErrors(['domain_id' => 'Selected domain not found.']);
            }
            $domainId = $domain->id;
        } else {
            $domainId = $domainInput;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string',
            'domain_id' => 'required',
            'keytraits' => 'nullable|string',
            'enjoys' => 'nullable|string',
            'idealenvironments' => 'nullable|string',
            'description' => 'nullable|string',
            'low' => 'nullable|string',
            'mid' => 'nullable|string',
            'high' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'code' => $request->code,
            'domain_id' => $domainId,
            'description' => $request->description,
            'uploaded_by' => Auth::id(),
        ];

        if (in_array($domainInput, $specialDomains)) {
            $data['low'] = $request->low;
            $data['mid'] = $request->mid;
            $data['high'] = $request->high;
            $data['keytraits'] = null;
            $data['enjoys'] = null;
            $data['idealenvironments'] = null;
        } else {
            $data['low'] = null;
            $data['mid'] = null;
            $data['high'] = null;
            $data['keytraits'] = $request->keytraits;
            $data['enjoys'] = $request->enjoys;
            $data['idealenvironments'] = $request->idealenvironments;
        }

        Section::create($data);

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

        $domainInput = $request->input('domain_id');
        $specialDomains = ['OCEAN', 'Work Values'];

        // If the domain is a special one, fetch its ID by name
        if (in_array($domainInput, $specialDomains)) {
            $domain = \App\Models\Domain::where('name', $domainInput)->first();
            if (!$domain) {
                return back()->withErrors(['domain_id' => 'Selected domain not found.']);
            }
            $domainId = $domain->id;
        } else {
            $domainId = $domainInput;
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string',
            'domain_id' => 'required',
            'keytraits' => 'nullable|string',
            'enjoys' => 'nullable|string',
            'idealenvironments' => 'nullable|string',
            'description' => 'nullable|string',
            'low' => 'nullable|string',
            'mid' => 'nullable|string',
            'high' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'code' => $request->code,
            'domain_id' => $domainId,
            'description' => $request->description,
        ];

        if (in_array($domainInput, $specialDomains)) {
            $data['low'] = $request->low;
            $data['mid'] = $request->mid;
            $data['high'] = $request->high;
            $data['keytraits'] = null;
            $data['enjoys'] = null;
            $data['idealenvironments'] = null;
        } else {
            $data['low'] = null;
            $data['mid'] = null;
            $data['high'] = null;
            $data['keytraits'] = $request->keytraits;
            $data['enjoys'] = $request->enjoys;
            $data['idealenvironments'] = $request->idealenvironments;
        }

        $section->update($data);

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
