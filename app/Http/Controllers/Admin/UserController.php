<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\StoreRequest;
use App\Http\Requests\User\ToggleRolesRequest;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\Section\SectionResource;
use App\Http\Resources\User\UserResource;
use App\Models\Role;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $roles = RoleResource::collection(Role::all())->resolve();
        $users = UserResource::collection(User::all())->resolve();
        return Inertia::render('Admin/User/Index', compact('roles', 'users'));
    }

    public function toggleRoles(ToggleRolesRequest $request, User $user)
    {
        $data = $request->validated();
        $user->roles()->toggle($data);

        return UserResource::make($user)->resolve();
    }

}
