<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Complaint\ComplaintResource;
use App\Models\Branch;
use App\Models\Compliant;
use App\Models\Message;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Compliant::all();
        $complaints = ComplaintResource::collection($complaints)->resolve();
        return Inertia::render('Admin/Complaint/Index', compact('complaints'));
    }
}
