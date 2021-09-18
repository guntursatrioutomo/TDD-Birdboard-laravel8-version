<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{   
    public function index()
    {
        $projects = \auth()->user()->projects;
        return \view('projects.index', \compact('projects'));
    }

    public function show(Project $project)
    {

        if(\auth()->id() != $project->owner_id){
            \abort(403);
        }
        return \view('projects.show',\compact('project'));

    }

    public function store()
    {
        
        $attributes = \request()->validate([
            'title' => 'required',
            'descriptions' => 'required', 
        ]);

        \auth()->user()->projects()->create($attributes);

        return \redirect('/projects');
    }
}
