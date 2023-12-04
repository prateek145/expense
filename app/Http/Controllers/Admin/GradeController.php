<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin\Grade;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;

class GradeController extends ApiController
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //code...
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:grades',
            'status' => 'required|integer',
            'created_by' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $grade = Grade::create($data);
            return response()->json($this->sendResponse1($grade, 'Grade Created Successfully'));
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
            $grade = Grade::find($id);
            return response()->json($this->sendResponse1($grade, 'Grade Show Successfully'));
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
        //code...
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required|integer',
            'updated_by' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $grade = Grade::find($id);
            $grade->update($data);
            return response()->json($this->sendResponse1($grade, 'Grade Updated Successfully'));
            // $this->Success('Grade Created Successfully', 'success', $grade);

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
        //code...
        try {
            // $data = $request->all();
            $grade = Grade::find($id);
            if (!$grade) {
                # code...
                throw new \Exception("Admin Meal not found");

            }
            Grade::destroy($id);
            $grade = [];
            return response()->json($this->sendResponse1($grade, 'Grade Deleted Successfully'));

        } catch (\Exception $e) {
            //throw $th;
            return response()->json($this->sendError1($e->getMessage(), 'error'));

        }
    }
}
