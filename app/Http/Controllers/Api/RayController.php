<?php

namespace App\Http\Controllers\Api;

use App\Models\Xray;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RayController extends Controller
{
    use GeneralTrait;


    public function index(){
        try{
            $patients=Xray::all();
            return $this->returnData('data',$patients,'success');

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'rayphoto' => 'required|file',
        ]);

        if ($validator->fails()) {

            return $this->response(null,$validator->errors(),'400');
        }
        $ray='';
        if($request->hasFile('rayphoto')){
            $ray=$this->saveImage($request->rayphoto,'rays');
        }
        Xray::create([
            'user_id'=>Auth::user()->id,
            'name'=>$request->name,
            'rayphoto'=>$ray,
        ]);

        return $this->returnSuccessMessage('inserted successfully');
    }

    public function show($id){
        try{
            $ray=Xray::find($id);
            if(!$ray){
                return $this->returnError(201,'ray not found');
            }else{
            return $this->returnData('data',$ray);
            }

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'rayphoto' => 'required|file',
        ]);

        if ($validator->fails()) {

            return $this->response(null,$validator->errors(),'400');
        }
        try{
            $ray=Xray::find($id);
            if(!$ray){
                return $this->returnError(201,'ray not found');
            }else{
                $ray_photo='';
                if($request->hasFile('rayphoto')){
                $ray_photo=$this->saveImage($request->rayphoto,'rays');
                    }
                $ray->update([
                    'user_id'=>Auth::user()->id,
                    'name' => $request->name,
                    'rayphoto' =>$ray_photo,
                ]);
                return $this->returnSuccessMessage('updated successfully');
                    }

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }

    }
    public function destroy($id){
        try{
            $ray=Xray::find($id);
            if(!$ray){
                return $this->returnError(201,'ray not found');
            }else{
                //$manager->malls()->delete();
                $ray->delete();

                return $this->returnSuccessMessage('deleted successfully');
                    }

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }

    }
}
