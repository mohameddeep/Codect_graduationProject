<?php

namespace App\Http\Controllers\Api;

use App\Models\Pressure;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PressureController extends Controller
{
    use GeneralTrait;


    public function index(){
        try{
            $pressures=Pressure::get();
            return $this->returnData('data',$pressures,'success');

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
        Pressure::create([
            'user_id'=>Auth::user()->id,
            'value'=>$request->value,

        ]);

        return $this->returnSuccessMessage('inserted successfully');
    }

    public function show($id){
        try{
            $pressure=Pressure::find($id);
            if(!$pressure){
                return $this->returnError(201,'pressure not found');
            }else{
            return $this->returnData('data',$pressure);
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
            $pressure=Pressure::find($id);
            if(!$pressure){
                return $this->returnError(201,'pressure not found');
            }else{
                $pressure->update([
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
            $pressure=Pressure::find($id);
            if(!$pressure){
                return $this->returnError(201,'pressure not found');
            }else{

                $pressure->delete();

                return $this->returnSuccessMessage('deleted successfully');
                    }

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }

    }
}
