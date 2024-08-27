<?php

namespace App\Http\Controllers\Api;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class SkillController extends Controller
{
    public function index()
    {
        $skills=Skill::all();
        return response()->json(['skills'=>$skills],201);
    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'name'=>'required|string',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $skill=new Skill();
        $clean_name=app('purifier')->purify($request->input('name'));
        $skill->create(['name'=>$clean_name]);
        return response()->json(['message'=>'skill add successfully'],200);
    }

    public function update(Request $request, Skill $skill)
    {
        $validator = FacadesValidator::make($request->all(),[
            'name'=>'required|string',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $clean_name=app('purifier')->purify($request->input('name'));
        $skill->update(['name'=>$clean_name]);
        return response()->json(['message'=>'skill update successfully'],200);
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();
        return response()->json(['message'=>'skill delete successfully'],200);
    }
}
