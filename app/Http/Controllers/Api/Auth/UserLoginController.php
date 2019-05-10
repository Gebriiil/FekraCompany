<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\User;
class UserLoginController extends Controller
{
    use ApiResponseHelper;

	public function login(Request $request)
	{
		$creds=$request->only(['email','password']);

		if (!$token=auth()->attempt($creds)) {
			return $this->setCode(400)->setError(['error'=>'Invalid Email or Password'])->send();
		}
		return $this->setCode(200)->setSuccess(['token'=>$token])->send();
	}

	public function register(Request $request)
	{
		// $rules = [
  //           'phone' => 'required|unique:users',
  //           'email' => 'required|unique:users',
  //           'password' => 'required|min:6',
  //       ];
        $data=$request->except('password','image');
        $image_name=image_upload($request->file);
        $data['image']=$image_name;
        $data['password']=bcrypt(request('password'));
        $user = User::create($data);
        $token = doLogin($user);
        return $this->setCode(200)->setSuccess(['token'=>$token])->send();
        // Validate Data
        // $validator = $request->validate( $rules);
        // if ($validator->fails()) {
            
        //         if ($validator->errors()->has('phone'))
        //             return $this->setCode(400)->setError($message)->send();
        //         elseif ($validator->errors()->has('email'))
        //             return $this->setCode(400)->setError($message)->send();
        //         elseif ($validator->errors()->has('password'))
        //             return $this->setCode(400)->setError($message)->send();
            
        // }
		
	}
	
	


}
