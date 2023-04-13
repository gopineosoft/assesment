<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Validator;
use Exception;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //get all employee with department details, 10 at one page
            $users = User::with('department')->latest()->paginate(10);
            return [
                'status'=>true,
                'data'=>$users
            ];
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>500]); 
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
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:200|unique:users,email',
            'password' => 'required|min:6|max:15',
            'department_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors(),'code'=>500]); 
        }
        try {
            $data = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "password" => $request->password,
                "department_id" => $request->department_id
            ]);
            $response=[
                'code'=> 200,
                'status'=>true,
                'data'=>$data
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>500]); 
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
                'data'=>User::find($id)
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>500]); 
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
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|email|unique:users,email,'.$id,
            'password' => 'nullable|min:6|max:15',
            'department_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors(),'code'=>500]); 
        }

        try {
            $user = User::find($id);
            if(!empty($request['password'])){
		    	$request['password'] = \Hash::make($request['password']);
		    }
            $user->update(['name'=>$request->name,"email"=>$request->email,"password"=>$request->password,"department_id"=>$request->department_id]);
            $response=[
                'code'     => 200,
                'status'=>true,
                'data'=>'updated'
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>500]); 
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
        try {
            User::destroy($id);
            $response=[
                'code'     => 200,
                'status'=>true,
                'data'=>[]
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>500]); 
        }
    }
}
