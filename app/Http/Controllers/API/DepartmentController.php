<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Validator;
use Exception;


class DepartmentController extends Controller
{
  
    public function index()
    {
        try {
            $department = Department::latest()->paginate(10);
            return [
                'status'=>true,
                'data'=>$department
            ];
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
            'name' => 'required|string|max:100|unique:departments,name',
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors(),'code'=>406]); 
        }
        try {
            
            $data = Department::create(['name'=>$request->name]);
            
            $response=[
                'code'     => 200,
                'status'=>true,
                'data'=>$data
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
                'data'=>Department::find($id)
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
            'name'    => 'required|string|max:100|unique:departments,name,'.$id,
        ]);
        if ($validator->fails()) {
            return response()->json(['message'=>$validator->errors(),'code'=>406]); 
        }
        try {
            $department = Department::find($id);
		   	$department->update(['name'=>$request->name]);
            $response=[
                'code'     => 200,
                'status'=>true,
                'data'=>'updated'
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
        try {
            Department::destroy($id);
            $response=[
                'code'     => 200,
                'status'=>true,
                'data'=>'Deleted'
            ];
            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json(['message'=>'Somethng went wrong','code'=>406]); 
        }

    }
}
