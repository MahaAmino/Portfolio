<?php
namespace App\Http\Controllers\Api;

use App\Models\Contact_me;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ContactMeController extends Controller
{
    public function index()
    {
        $information=Contact_me::all();
        return response(['information'=>$information],200);
    }

    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'your_name'=>'required|string',
            'your_email'=>'required|email|string',
            'your_message'=>'required|string',
            ]);
        if($validator->fails()){
            return response($validator->messages(), 200);
        }
        $message=new Contact_me();
        $clean_data=[];
        foreach($request->all() as $content=>$value){
            $clean_data[$content]=app('purifier')->purify($value);}
        $message->create($clean_data);
        return response()->json(["success"=>"message add successfully"],200);
    }

    public function show(Contact_me $message)
    {
        $message=Contact_me::where('id', $message->id)->first();
        return response()->json(['message'=>$message],200);
    }

    public function update(Request $request, Contact_me $message)
    {
        $validator = FacadesValidator::make($request->all(),[
            'your_name'=>'required|string',
            'your_email'=>'required|email|string',
            'your_message'=>'required|string',
            ]);
        if($validator->fails()){
            return response($validator->messages(), 200);
        }
        $clean_data=[];
        foreach($request->all() as $content=>$value){
            $clean_data[$content]=app('purifier')->purify($value);}
        $message->update($clean_data);
        return response()->json(["success"=>"message updated successfully"],200);
    }
    public function destroy(Contact_me $message)
    {
        $message->delete();
        return response()->json(["success"=>"message deleted successfully"],200);
    }
}
