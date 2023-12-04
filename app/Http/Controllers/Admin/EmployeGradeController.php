<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\EmployeGrade;

class EmployeGradeController extends ApiController
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
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'grade_id' => 'required|integer',
            'employe_id' => 'required|integer',
            'hod_id' => 'required|array',
            'created_by' => 'required|integer',
            'status' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $data['hod_id'] = json_encode($request->hod_id);
            // dd($data);
            $hotel = EmployeGrade::create($data);
            $hotel->hod_id = json_decode($hotel->hod_id);
            return response()->json($this->sendResponse1($hotel, 'Admin Employe Grade Created Successfully'));
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
            $e_grade = EmployeGrade::find($id);
            $e_grade->hod_id = json_decode($e_grade->hod_id);
            return response()->json($this->sendResponse1($e_grade, 'Admin Employe Grade Show Successfully'));
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
            'employe_id' => 'required|integer',
            'hod_id' => 'required|array',
            'updated_by' => 'required|integer',
            'status' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $e_grade = EmployeGrade::find($id);

            if ($e_grade->hod_id) {
                # code...
                json_encode($e_grade->hod_id);
            }
            $e_grade->update($data);

            return response()->json($this->sendResponse1($e_grade, 'Admin Employe Grade Updated Successfully'));
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
            $e_grade = EmployeGrade::find($id);
            if (!$e_grade) {
                # code...
                throw new \Exception("Admin Employe Grade not found");

            }
            EmployeGrade::destroy($id);
            $e_grade = [];
            return response()->json($this->sendResponse1($e_grade, 'Admin Employe Grade Deleted Successfully'));

        } catch (\Exception $e) {
            //throw $th;
            return response()->json($this->sendError1($e->getMessage(), 'error'));

        }
    }
}
