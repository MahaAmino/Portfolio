<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class JobController extends Controller
{
    public function index()
    { $jobs=Job::all();
        return response(['jobs'=>$jobs],200);
    }

    public function store(Request $request)
    {   $validator = FacadesValidator::make($request->all(),[
        'title'=>'required|string',
        'from'=>'required|date',
        'to'=>'required|date',
        'company'=>'required|string',
        'description'=>'required|string',
        ]);
    if($validator->fails()){
        return response($validator->messages(), 200);
    }
    $job=new Job();
    $clean_data=[];
    foreach($request->all() as $content=>$value){
        $clean_data[$content]=app('purifier')->purify($value);}
    $job->create($clean_data);
    return response()->json(["success"=>"job add successfully"],200);
    }

    public function show(Job $job)
    {
        $thisJob=Job::where('id', $job->id)->get();
        return response()->json(['this job is'=>$thisJob],201);
    }

    public function update(Request $request, Job $job)
    {
        $validator = FacadesValidator::make($request->all(),[
            'title'=>'required|string',
            'from'=>'required|date',
            'to'=>'required|date',
            'company'=>'required|string',
            'description'=>'required|string',
            ]);
        if($validator->fails()){
            return response($validator->messages(), 200);
        }
        $clean_data=[];
        foreach($request->all() as $content=>$value){
            $clean_data[$content]=app('purifier')->purify($value);}
        $job->update($clean_data);
        return response()->json(["success"=>"job update successfully"],200);
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return response()->json(["success"=>"job deleted successfully"],200);
    }
}
