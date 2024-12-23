<?php

namespace App\Http\Controllers;

use App\Http\Requests\Section\StoreRequest;
use App\Http\Requests\Section\UpdateRequest;
use App\Http\Resources\Branch\BranchResource;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\Section\SectionWithBranchesResource;
use App\Models\Branch;
use App\Models\Section;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::with('branches')->get();
        $sections = SectionWithBranchesResource::collection($sections)->resolve();

        return Inertia::render('Section/Index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Section::class);
        return Inertia::render('Section/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        Gate::authorize('create', Section::class);

        $data = $request->validated();
        Section::firstOrCreate($data);

        return Redirect::route('sections.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        return Inertia::render('Section/Edit', compact('section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Section $section)
    {
        $data = $request->validated();
        $section->update($data);

        return Redirect::route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return Redirect::back();
    }

    public function sectionBranches(Section $section)
    {
        return BranchResource::collection($section->branches)->resolve();
    }
    public function sectionBranchesExcept(Section $section, Branch $branch)
    {
        $branches = $section->branches()->whereNot('id', $branch->id)->get();
        return BranchResource::collection($branches)->resolve();
    }
}
