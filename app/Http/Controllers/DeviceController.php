<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;
use Validator;


class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Device::all();
        if($data){
            return response()->json($data, 200);
        }else{
            $data = ["error" => "data not found"];
            return response()->json($data, 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = array(
            "user_id" => "required",
            "name" => "required"
        );

        $validator = Validator::make($request->all(),$rule);

        if($validator->fails())
        {
            return response()->json($validator->errors(), 401);
        }
       
        $device = new Device;
        $device->name = $request->name;
        $device->user_id = $request->user_id;
       
        $result = $device->save();
        $result = "";
        if($result)
        {
            $data = ['result' => 'data has been saved'];
            return response()->json($data, 200);
        }else{
            return ['result' => 'operation failed'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Device::find($id);
        if($data){
            return response()->json($data, 200);
        }else{
            $data = ["error" => "data not found"];
            return response()->json($data, 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $device = Device::find($id);
       
       if($device)
       {
            $device->name = $request->name;
            $device->user_id = $request->user_id;       
            $result = $device->save();
            
            if($result)
            {
                $data =  ['result' => 'data has been updated'];
                return response()->json($data, 200);

            }else{
                return ['error' => 'operation failed'];
            }
        }else{
                $data = ["error" => "data not found"];
                return response()->json($data, 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $device = Device::find($id);
        if($device)
        {        
            $result = $device->delete();
            if($result)
            {
                return ['result' => 'data has been deleted'];

            }else{
                return ['result' => 'operation failed'];
            }
    
        }else{
            $data = ["error" => "data not found"];
            return response()->json($data, 404);
        }
    }
}
