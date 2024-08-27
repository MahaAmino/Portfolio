<?php

namespace App\Http\Controllers\Api;

use App\Models\Educate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class EducateController extends Controller
{
    public function index()
    {
        $education=Educate::all();
        return response(['education'=>$education],200);
    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'title'=>'required|string',
            'start'=>'required|integer',
            'end'=>'integer',
            'company'=>'required|string',
            'description'=>'required|string',
            ]);
        if($validator->fails()){
            return response($validator->messages(), 200);
        }
        $education=new Educate();
        $clean_data=[];
        foreach($request->all() as $content=>$value){
            $clean_data[$content]=app('purifier')->purify($value);}
        $education->create($clean_data);
        return response()->json(["success"=>"education add successfully"],200);
    }

    public function show(Educate $educate)
    {
        $education=Educate::where('id', $educate->id)->first();
        return response()->json(['thisEducationIs'=>$education],200);
    }

    public function update(Request $request, Educate $educate)
    {
        $validator = FacadesValidator::make($request->all(),[
            'title'=>'required|string',
            'start'=>'required|integer',
            'end'=>'integer',
            'company'=>'required|string',
            'description'=>'required|string',
            ]);
        if($validator->fails()){
            return response($validator->messages(), 200);
        }
        $clean_data=[];
        foreach($request->all() as $content=>$value){
            $clean_data[$content]=app('purifier')->purify($value);}
        $educate->update($clean_data);
        return response()->json(["success"=>"education updated successfully"],200);
    }
    public function destroy(Educate $educate)
    {
        $educate->delete();
        return response()->json(["success"=>"educate deleted successfully"],200);
    }
}
