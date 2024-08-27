<?php

namespace App\Http\Controllers\Api;

use App\Models\Certificate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates=Certificate::all();
        return response(['certificates'=>$certificates],200);
    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'title'=>'required|string',
            'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048|required',
            ]);
        if($validator->fails()){
                return response($validator->messages(), 200);
        }
        $clean_title=app('purifier')->purify($request->input('title'));
        $certificate=new Certificate();
        if($request->hasFile('image')){
            $img=$request['image'];
            $imgName=time().".".$img->getClientOriginalExtension();
            $img->move('./assets/imgs',$imgName);
            $data['image']=$imgName;
        }
        $certificate->create(
            [   'title'=>$clean_title,
                'image'=>$imgName,
            ]);
            return response()->json(["success"=>"certificate add successfully"],200);
    }

    public function show(Certificate $certificate)
    {
        $certificate=Certificate::where('id', $certificate->id)->first();
        return response()->json(['this certificate is'=>$certificate],200);
    }

    public function update(Request $request, Certificate $certificate)
    { $validator = FacadesValidator::make($request->all(),[
            'title'=>'required|string',
            'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            ]);
        if($validator->fails()){return response($validator->messages(), 200);}
        $clean_title=app('purifier')->purify($request->input('title'));
        $imgName=$certificate->image;
        if($request->hasFile('image')){
            $img=$request['image'];
            $imgName=time().".".$img->getClientOriginalExtension();
            $img->move('./assets/imgs',$imgName);
            $data['image']=$imgName;
        }
        $certificate->update([
                'title'=>$clean_title,
                'image'=>$imgName,
            ]);
        return response()->json(["success"=>"certificate update successfully"],200);
    }

    public function destroy(Certificate $certificate)
    {
        $certificate->delete();
        return response()->json(["success"=>"certificate delete successfully"],200);
    }
}
