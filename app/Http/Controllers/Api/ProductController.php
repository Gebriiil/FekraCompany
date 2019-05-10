<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use App\Http\Controllers\Api\Auth\ApiResponseHelper;
use App\Http\Resources\ProductResource;
use App\Http\Resources\WhishlistResource;
use App\Product;
use App\Favorit;

class ProductController extends Controller
{
	use ApiResponseHelper;
	// show user products=======================
    public function myproducts()
	{
		$user = $this->userauth();
		if(isset($user->products)){
			$my_product= ProductResource::collection($user->products);
			return $this->setCode(200)->setData($my_product)->send();
		}else{
			return $this->setCode(400)->setError($user)->send();
		}
	}
	//store products=============================
	public function store(Request $request)
	{

		$products=$request->only(['title','desc']);
		try{
			$user=auth()->userOrFail();
		} catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response(['error'=>$e->getMessage()]);
		}

		$product=$user->products()->create($products);

		$photos=$request->photos;
		foreach($photos as $photo){       

            $image=image_upload($photo);
            $image=['image'=>$image];
		    $product->images()->create($image);

        }
		$my_product= new ProductResource($product);
		return $this->setCode(200)->setData($my_product)->send();
		
		
	}
	//update products============================
	public function update(Request $request,$id)
	{
		$products=$request->only(['title','desc']);
		try{
			$user=auth()->userOrFail();
		} catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response(['error'=>$e->getMessage()]);
		}

		if($product=$user->products()->find($id)){

			$product->update($products);	
			$photos=$request->photos;
			foreach($photos as $photo){       

	            $image=image_upload($photo);
	            $image=['image'=>$image];
			    $product->images()->update($image);

	        }
			$my_product= new ProductResource($product);
			return $this->setCode(200)->setData($my_product)->send();
		}else{
			return $this->setCode(400)->setError(['error'=>'nothing to update'])->send();
		}
		
		
	}

	//show one product==========================
	public function show($id)
	{
		if($msg=logoin_validata()){
			return $msg;
		}
		if($product=Product::find($id)){
			$my_product= new ProductResource($product);
			return $this->setCode(200)->setData($my_product)->send();
		}else{
			return $this->setCode(400)->setError(['error'=>'no data'])->send();
		}
	}

	//delete product==============================
	public function delete($id)
	{
		if($msg=logoin_validata()){
			return $msg;
		}
		
		if(Product::destroy($id)){
			
			return $this->setCode(200)->setSuccess(['message'=>'deleted'])->send();
		}else
			return $this->setCode(400)->setError(['error'=>'nothing to delete'])->send();
	}

	//Whislist ==================]

	public function addToWhishlist($id) {

		try{
			$user=auth()->userOrFail();
		} catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response(['error'=>$e->getMessage()]);
		}

		$exists = Favorit::where(['user_id' => $user->id, 'product_id' => $id])->exists();

		$wishlist = null;

		if ($exists) {

			Favorit::where(['user_id' => $user->id, 'product_id' => $id])->delete();

			
			return $this->setCode(200)->setSuccess(['message'=>'disliked'])->send();

		} else {
			$wishlist = Favorit::create(['user_id' => $user->id, 'product_id' => $id]);
			
			return $this->setCode(200)->setSuccess(['message'=>'liked'])->send();
		}

	}

	//MyWhishlist=========================
	public function MyWhishlist()
	{

		try{
			$user=auth()->userOrFail();
		} catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response(['error'=>$e->getMessage()]);
		}

		$whishlists=$user->favorits;
		$whishlists=  WhishlistResource::collection($whishlists);
		return $this->setCode(200)->setSuccess($whishlists)->send();
	}

	//
	public function logout() {

		try{
			$user=auth()->userOrFail();
		} catch(\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e){
			return response(['error'=>$e->getMessage()]);
		}
		$user->logout();
		return $this->setCode(200)->setSuccess(['logout'])->send();

	}
}
