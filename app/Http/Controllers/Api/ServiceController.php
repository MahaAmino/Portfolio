<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ServiceController extends Controller
{
    public function index()
    {
        $services=Service::all();
        return response()->json(['Services'=>$services],201);
    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'title'=>'required|string',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $service=new Service();
        $clean_title=app('purifier')->purify($request->input('title'));
        $service->create(['title'=>$clean_title]);
        return response()->json(['message'=>'Service add successfully'],200);
    }

    public function update(Request $request, Service $service)
    {
        $validator = FacadesValidator::make($request->all(),[
            'title'=>'required|string',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $clean_title=app('purifier')->purify($request->input('title'));
        $service->update(['title'=>$clean_title]);
        return response()->json(['message'=>'Service update successfully'],200);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json(['message'=>'Service delete successfully'],200);
    }
}
