<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Message;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index()
    {
        $stats = [
            [
                'title' => 'Branches',
                'count' => Branch::all()->count(),
            ],
            [
                'title' => 'Users',
                'count' => User::all()->count(),
            ],
            [
                'title' => 'Messages',
                'count' => Message::all()->count(),
            ],
            [
                'title' => 'Themes',
                'count' => Theme::all()->count(),
            ],
        ];
        return Inertia::render('Admin/Main/Index', compact('stats'));
    }
}
