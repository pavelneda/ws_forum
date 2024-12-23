<?php

namespace App\Http\Controllers;

use App\Http\Requests\Branch\StoreRequest;
use App\Http\Requests\Branch\UpdateRequest;
use App\Http\Resources\Branch\BranchResource;
use App\Http\Resources\Branch\BranchWithChildrenResource;
use App\Http\Resources\Section\SectionResource;
use App\Models\Branch;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        $sections = SectionResource::collection($sections)->resolve();

        return Inertia::render('Branch/Create' , compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        Branch::firstOrCreate($data);
        return Redirect::route('sections.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        $branch = BranchWithChildrenResource::make($branch)->resolve();
        return Inertia::render('Branch/Show', compact('branch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        $sections = Section::all();
        $sections = SectionResource::collection($sections)->resolve();
        $branch = BranchResource::make($branch)->resolve();

        return Inertia::render('Branch/Edit' , compact('sections', 'branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Branch $branch)
    {
        $data = $request->validated();
        $branch->update($data);
        return Redirect::route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        Gate::authorize('delete', $branch);
        $branch->delete();
        return Redirect::back();
    }

    public function themeCreate(Branch $branch)
    {
        $branch = BranchResource::make($branch)->resolve();
        return Inertia::render('Branch/Theme/Create', compact('branch'));
    }
}
