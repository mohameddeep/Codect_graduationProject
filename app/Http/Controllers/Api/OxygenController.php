<?php

namespace App\Http\Controllers\Api;

use App\Models\Oxygen;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OxygenController extends Controller
{
    use GeneralTrait;


    public function index(){
        try{
            $Oxygens=Oxygen::get();
            return $this->returnData('data',$Oxygens,'success');

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
        Oxygen::create([
            'user_id'=>Auth::user()->id,
            'value'=>$request->value,

        ]);

        return $this->returnSuccessMessage('inserted successfully');
    }

    public function show($id){
        try{
            $Oxygen=Oxygen::find($id);
            if(!$Oxygen){
                return $this->returnError(201,'Oxygen not found');
            }else{
            return $this->returnData('data',$Oxygen);
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
            $Oxygen=Oxygen::find($id);
            if(!$Oxygen){
                return $this->returnError(201,'Oxygen not found');
            }else{
                $Oxygen->update([
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
            $Oxygen=Oxygen::find($id);
            if(!$Oxygen){
                return $this->returnError(201,'Oxygen not found');
            }else{

                $Oxygen->delete();

                return $this->returnSuccessMessage('deleted successfully');
                    }

        }catch(\Exception $e){
            return $this->returnError(201,$e->getMessage());

        }

    }
}
