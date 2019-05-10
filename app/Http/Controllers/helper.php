<?php
if (!function_exists('doLogin')) {
	function doLogin($user)
	    {
	        $jwt_token = null;
	        if (!$jwt_token = JWTAuth::fromUser($user)) {
	            return false;
	        }
	        return $jwt_token;
	    }
}

// if (!function_exists('image_name')){
// 	function image_name($file)
// 	{
// 		return md5 (microtime()) . '.' . $file->getClientOriginalExtension();
// 	}
// }
if (!function_exists('image_upload')){
	function image_upload($file,$image_name=null)
	{
		$image_name=md5 (microtime()) . '.' . $file->getClientOriginalExtension();
		 $file->move(public_path('upload'),$image_name);
		 return $image_name;
	}
}
if (!function_exists('image_upload')){
	function image_upload($file,$image_name=null)
	{
		$image_name=md5 (microtime()) . '.' . $file->getClientOriginalExtension();
		 $file->move(public_path('upload'),$image_name);
		 return $image_name;
	}
}
if (!function_exists('logoin_validata')){
	function logoin_validata()
	{
		try{
			$user=auth()->userOrFail();
		} catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response(['error'=>$e->getMessage()]);
		}
	}
}
?>