<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Address;
use Validator;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $phone = Address::with('user')->latest()->paginate(10);
            $response=[
                'code'     => 200,
                'status'=>true,
                'data'=>$phone
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>406]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|numeric|exists:users,id',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors(),'code'=>406]);
        }
        try {
            $contact = Address::create([
                "address"=>$request->address,
                "user_id"=>$request->user_id
            ]);
            $response=[
                'code'     => 200,
                'status'=>true,
                'data'=>$contact
            ];
            return response()->json($response, 200);
           
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>406]);
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
        try {
            $response=[
                'code'     => 200,
                'status'=>true,
                'data'=>Address::with('user')->find($id)
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>406]);
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
        $validator = Validator::make($request->all(), [
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors(),'code'=>406]);
        }
        try {
            $phone = Address::find($id);
		   	$phone->update(['address'=>$request->address]);
            $response=[
                'code'     => 200,
                'status'=>true,
                'data'=>$phone,
                'message'=>'Updated successfully'
            ];
            return response()->json($response, 200);
            
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>406]);
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
        Address::destroy($id);
        $response=[
            'code'     => 200,
            'status'=>true,
            'data'=>[],
            'message'=>'Deleted successfullyy'
        ];
        return response()->json($response, 200);
    }
}
