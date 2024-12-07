<?php

namespace App\Http\Controllers;

use App\Http\Requests\Theme\StoreRequest;
use App\Http\Requests\Theme\UpdateRequest;
use App\Http\Resources\Theme\ThemeResource;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ThemeController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        Theme::create($data);

        return Redirect::route('branches.show', $data['branch_id']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme)
    {
        $theme = ThemeResource::make($theme)->resolve();
        return Inertia::render('Theme/Edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Theme $theme)
    {
        $data = $request->validated();
        $theme->update($data);
        return Redirect::route('branches.show', $theme->branch_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();
        return Redirect::route('branches.show', $theme->branch_id);
    }
}
