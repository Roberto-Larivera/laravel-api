<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Project;
use App\Models\Type;
use App\Models\Technology;
use App\Models\User;

class PageController extends Controller
{
    public function dashboard()
    {
        $countProjects = Project::count();
        $countTypes = Type::count();
        $countTechnologies = Technology::count();
        $countUsers = User::count();
        return view('admin.dashboard',[
            'countProjects' => $countProjects,
            'countUsers' => $countUsers,
            'countTypes' => $countTypes,
            'countTechnologies' => $countTechnologies,
        ]);
    }
}
