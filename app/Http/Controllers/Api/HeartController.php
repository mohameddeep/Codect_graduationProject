<?php

namespace App\Http\Controllers\Api;

use App\Models\Heartrate;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HeartController extends Controller
{
    use GeneralTrait;


    public function index(){
        try{
            $hearts=Heartrate::get();
            return $this->returnData('data',$hearts,'success');

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }
    }
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'value' => 'required',

        ]);

        if ($validator->fails()) {

            return $this->response(null,$validator->errors(),'400');
        }
        Heartrate::create([
            'user_id'=>Auth::user()->id,
            'value'=>$request->value,

        ]);

        return $this->returnSuccessMessage('inserted successfully');
    }

    public function show($id){
        try{
            $heart=Heartrate::find($id);
            if(!$heart){
                return $this->returnError(201,'heart rate not found');
            }else{
            return $this->returnData('data',$heart);
            }

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }
    }
    public function update(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'value' => 'required',

        ]);

        if ($validator->fails()) {

            return $this->response(null,$validator->errors(),'400');
        }
        try{
            $heart=Heartrate::find($id);
            if(!$heart){
                return $this->returnError(201,'heart rate not found');
            }else{
                $heart->update([
                    'user_id'=>Auth::user()->id,
                    'value'=>$request->value,
                ]);
                return $this->returnSuccessMessage('updated successfully');
                    }

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }

    }
    public function destroy($id){
        try{
            $heart=Heartrate::find($id);
            if(!$heart){
                return $this->returnError(201,'heart rate not found');
            }else{

                $heart->delete();

                return $this->returnSuccessMessage('deleted successfully');
                    }

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }

    }
}
