<?php

namespace App\Http\Controllers\Api;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class ProfileController extends Controller
{
    public function index()
    {
        $profile=Profile::all();
        $users = User::select('name', 'email')->get();
        return response(['profile'=>$profile,'user'=>$users],200);
    }
    public function store(Request $request)
    {
        $validator = FacadesValidator::make($request->all(),[
            'phone'=>'required|max:50|string',
            'about_me'=>'required|string',
            'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048|required',
            'address'=>'required|string',
            'career'=>'required|array',
            ]);
            if($validator->fails()){
                return response($validator->messages(), 200);
            }
        $profile=new Profile();
        if($request->hasFile('image')){
            $img=$request['image'];
            $imgName=time().".".$img->getClientOriginalExtension();
            $img->move('./assets/imgs',$imgName);
            $data['image']=$imgName;
        }
        $career=implode(',',$request['career']);
        $clean_phone=app('purifier')->purify($request->input('phone'));
        $clean_address=app('purifier')->purify($request->input('address'));
        $clean_career=app('purifier')->purify($career);
        $clean_about_me=app('purifier')->purify($request->input('about_me'));
        $profile->create(
            [   'phone'=>$clean_phone,
                'address'=>$clean_address,
                'image'=>$imgName,
                'career'=>$clean_career,
                'about_me'=>$clean_about_me,
            ]);
            return response()->json(["success"=>"profile add successfully"],200);
    }
    public function update(Request $request, Profile $profile)
    {
        $validator = FacadesValidator::make($request->all(),[
            'phone'=>'required|max:50|string',
            'about_me'=>'required|string',
            'image'=>'image|mimes:jpeg,jpg,png,gif|max:2048|nullable',
            'address'=>'required|string',
            'career'=>'required|array',
            ]);
        if($validator->fails()){return response($validator->messages(), 200);}
        $imgName=$profile->image;
        if($request->hasFile('image')){
            $img=$request['image'];
            $imgName=time().".".$img->getClientOriginalExtension();
            $img->move('./assets/imgs',$imgName);
            $data['image']=$imgName;
        }
        $career=implode(',',$request['career']);
        $clean_phone=app('purifier')->purify($request->input('phone'));
        $clean_address=app('purifier')->purify($request->input('address'));
        $clean_career=app('purifier')->purify($career);
        $clean_about_me=app('purifier')->purify($request->input('about_me'));
        $profile->update(
            [   'phone'=>$clean_phone,
                'address'=>$clean_address,
                'image'=>$imgName,
                'career'=>$clean_career,
                'about_me'=>$clean_about_me,
            ]);
        return response()->json(["success"=>"profile update successfully"],200);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response()->json(["success"=>"profile deleted successfully"],200);
    }
}
