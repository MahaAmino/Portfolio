<?php

namespace App\Http\Controllers\Api;

use App\Models\Information;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class InformationController extends Controller
{
    public function index()
    {
        $Information=Information::all();
        return response()->json(['Information'=>$Information],201);
    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'path'=>'required|string',
            'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048|required',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $Information=new Information();
        if($request->hasFile('image')){
            $img=$request['image'];
            $imgName=time().".".$img->getClientOriginalExtension();
            $img->move('./assets/imgs',$imgName);
            $data['image']=$imgName;
        }
        $clean_path=app('purifier')->purify($request->input('path'));
        $Information->create(['path'=>$clean_path,
        'image'=>$imgName,]);
        return response()->json(['message'=>'Information information add successfully'],200);
    }
    public function update(Request $request, Information $Information)
    {
        $validator = FacadesValidator::make($request->all(),[
            'path'=>'required|string',
            'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
            $imgName=$Information->image;
            if($request->hasFile('image')){
                $img=$request['image'];
                $imgName=time().".".$img->getClientOriginalExtension();
                $img->move('./assets/imgs',$imgName);
                $data['image']=$imgName;
            }
        $clean_path=app('purifier')->purify($request->input('path'));
        $Information->update(['path'=>$clean_path,'image'=>$imgName]);
        return response()->json(['message'=>'special information update successfully'],200);
    }

    public function destroy(Information $Information)
    {
        $Information->delete();
        return response()->json(['message'=>'Special information delete successfully'],200);
    }
}
