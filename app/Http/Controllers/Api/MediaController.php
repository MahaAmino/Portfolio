<?php

namespace App\Http\Controllers\Api;

use App\Models\Media;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class MediaController extends Controller
{
    public function index()
    {
        $media=Media::all();
        return response()->json(['Media'=>$media],201);
    }
    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'path'=>'required|string',
            'icon'=>'required|file|mimes:svg',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $media=new Media();
        $clean_path=app('purifier')->purify($request->input('path'));
        if($request->hasFile('icon')){
            $icon=$request['icon'];
            $iconName=time().".".$icon->getClientOriginalExtension();
            $icon->move('./assets/imgs',$iconName);
            $data['icon']=$iconName;
        }
        $media->create(['path'=>$clean_path,'icon'=>$iconName]);
        return response()->json(['message'=>'Media add successfully'],200);
    }
    public function update(Request $request, Media $media)
    {
        $validator = FacadesValidator::make($request->all(),[
            'path'=>'required|string',
            'icon'=>'file|mimes:svg',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
            $clean_path=app('purifier')->purify($request->input('path'));
            $iconName=$media->icon;
            if($request->hasFile('icon')){
                $icon=$request['icon'];
                $iconName=time().".".$icon->getClientOriginalExtension();
                $icon->move('./assets/imgs',$iconName);
                $data['icon']=$iconName;
            }
        $media->update(['path'=>$clean_path,'icon'=>$iconName]);
        return response()->json(['message'=>'Media update successfully'],200);
    }
    public function destroy(Media $media)
    {
        $media->delete();
        return response()->json(['message'=>'Media delete successfully'],200);
    }
}
