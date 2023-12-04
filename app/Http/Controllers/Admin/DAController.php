<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\DA;

class DAController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'grade_id' => 'required|integer',
            'city_tier_id' => 'required|integer',
            'status' => 'required|integer',
            'created_by' => 'required|integer',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $data['price'] = json_encode($request->price);
            // dd($data);
            $da = DA::create($data);
            $da->price = json_decode($da->price);
            return response()->json($this->sendResponse1($da, 'Admin DA Created Successfully'));
            // $this->Success('Grade Created Successfully', 'success', $grade);

        } catch (\Exception $e) {
            return response()->json($this->sendError1($e->getMessage(), 'error'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $da = DA::find($id);
            $da->price = json_decode($da->price);
            return response()->json($this->sendResponse1($da, 'Admin DA Show Successfully'));
            // $this->Success('Grade Created Successfully', 'success', $grade);

        } catch (\Exception $e) {
            return response()->json($this->sendError1($e->getMessage(), 'error'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'grade_id' => 'required|integer',
            'city_tier_id' => 'required|integer',
            'status' => 'required|integer',
            'created_by' => 'required|integer',
            'price' => 'required'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $da = DA::find($id);

            if ($da->price) {
                # code...
                json_encode($da->price);
            }
            // dd($da);
            $da->update($data);
            // dd($da);
            // $da->price = json_decode($da->price);

            return response()->json($this->sendResponse1($da, 'Admin DA Updated Successfully'));
            // $this->Success('Grade Created Successfully', 'success', $city);

        } catch (\Exception $e) {
            //throw $th;
            return response()->json($this->sendError1($e->getMessage(), 'error'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            // $data = $request->all();
            $da = DA::find($id);
            if (!$da) {
                # code...
                throw new \Exception("Admin DA not found");

            }
            DA::destroy($id);
            $da = [];
            return response()->json($this->sendResponse1($da, 'Admin DA Deleted Successfully'));

        } catch (\Exception $e) {
            //throw $th;
            return response()->json($this->sendError1($e->getMessage(), 'error'));

        }
    }
}
