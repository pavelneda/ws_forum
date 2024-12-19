<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Section\SectionResource;
use App\Models\Role;
use App\Models\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        $roles = RoleResource::collection(Role::all())->resolve();
        return Inertia::render('Admin/Role/Index', compact('roles'));
    }

    public function create()
    {
        $sections = Section::all();
        $sections = SectionResource::collection($sections)->resolve();

        return Inertia::render('Admin/Role/Create', compact('sections'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $code = $data['title'];

        if ($data['branch_id']){
            $code .= '.' . $data['section_id'] . '.' .$data['branch_id'];
        } else if ($data['section_id']){
            $code .= '.' . $data['section_id'];
        }

        Role::firstOrCreate([
            'title' => $data['title'],
            'code' => $code,
        ]);

        return redirect()->route('admin.roles.index');
    }
}
