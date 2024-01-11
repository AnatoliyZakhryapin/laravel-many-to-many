<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $request->all();

        $query = Project::limit(20);
       
        if (isset($data['title'])) {
            $query = $query->where('title', 'like', "%{$data['title']}%")->limit(20);
        }

        // $projects=Project::all();
        $projects=$query->get();
       return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::orderBy('name', 'ASC')->get();
       return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     * 
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');
        
        $project = Project::create($data);
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {   $types = Type::orderBy('name', 'ASC')->get();
        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {

        
        $data = $request->all();
        $data['slug'] = Str::slug($data['title'], '-');

        $project->update($data);
        return redirect()->route('admin.projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     * 
     */
    public function destroy(Project $project)
    {
       $project->delete();

       return redirect()->route('admin.projects.index');
    }
}
