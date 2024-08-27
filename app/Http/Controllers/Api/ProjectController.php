<?php

namespace App\Http\Controllers\Api;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects=Project::all();
        return response(['projects'=>$projects],200);
    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'title'=>'required|string',
            'description'=>'required|string',
            'media'=>'required|array',
            'media.*'=>'file|mimes:jpeg,jpg,png,gif,mp4,mov,ogg,qt',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $project=new Project();
        $filepath=[];
        foreach($request['media'] as $media){
            $media1=$media;
            $mediaName=time().".".$media1->getClientOriginalExtension();
            $media1->move('./assets/imgs',$mediaName);
            $filepath[]=$mediaName;
        }
        $pathMedia=implode(',',$filepath);
        $clean_title=app('purifier')->purify($request->input('title'));
        $clean_description=app('purifier')->purify($request->input('description'));
        $project->create(
            [   'title'=>$clean_title,
                'description'=>$clean_description,
                'media'=>$pathMedia,
            ]);
            return response()->json(["success"=>"project add successfully"],200);
    }

    public function show(Project $project)
    {
        $this_project_is=Project::where('id', $project->id)->first();
        return response()->json(['this project is'=>$this_project_is],201);
    }

    public function update(Request $request, Project $project)
    {
        $validator = FacadesValidator::make($request->all(),[
            'title'=>'required|string',
            'description'=>'required|string',
            'media'=>'array',
            'media.*'=>'file|mimes:jpeg,jpg,png,gif,mp4,mov,ogg,qt',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $pathMedia=$project->media;
        $filepath=[];
        if($request->hasFile('media')){
            foreach($request['media'] as $media){
                $media1=$media;
                $mediaName=time().".".$media1->getClientOriginalExtension();
                $media1->move('./assets/imgs',$mediaName);
                $filepath[]=$mediaName;
            }
            $pathMedia=implode(',',$filepath);
        }
        $clean_title=app('purifier')->purify($request->input('title'));
        $clean_description=app('purifier')->purify($request->input('description'));
        $project->update(
            [   'title'=>$clean_title,
                'description'=>$clean_description,
                'media'=>$pathMedia,
            ]);
            return response()->json(["success"=>"project update successfully"],200);
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->json(['message'=>'project delete successfully'],200);
    }
}
