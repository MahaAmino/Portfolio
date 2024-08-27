<?php

namespace App\Http\Controllers\Api;

use App\Models\Resume;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ResumeController extends Controller
{
    public function index(Resume $resume)
    {
        $resume=Resume::where('id', $resume->id)->first();
        $pdfName=$resume->path;
        $file_path = public_path('/assets/documents/'.$pdfName);
    return response()->download($file_path,$pdfName);
    }
    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'path'=>'required|mimes:pdf|max:10000',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $resume=new Resume();
        if($request->hasFile('path')){
            $pdf=$request['path'];
            $pdfName=time().".".$pdf->getClientOriginalExtension();
            $pdf->move('./assets/documents',$pdfName);
            $data['path']=$pdfName;
        }
        $resume->create(['path'=>$pdfName]);
        return response()->json(["message"=>'store resume is ok'],200);
    }
    public function update(Request $request, Resume $resume)
    {
        $validator = FacadesValidator::make($request->all(),[
            'path'=>'mimes:pdf|max:10000',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $pdfName=$resume->path;
            if($request->hasFile('path')){
                $pdf=$request['path'];
                $pdfName=time().".".$pdf->getClientOriginalExtension();
                $pdf->move('./assets/documents',$pdfName);
                $data['path']=$pdfName;
            }
        $resume->update(['path'=>$pdfName]);
        return response()->json(["message"=>'update resume is ok'],200);
    }
    public function destroy(Resume $resume)
    {
        $resume->delete();
        return response()->json(['message'=>'resume delete successfully'],200);
    }
}
