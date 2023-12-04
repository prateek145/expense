<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Travel;

class TravelController extends ApiController
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
           //code...
           $validator = Validator::make($request->all(), [
            'grade_id' => 'required|integer',
            'travel' => 'required',
            'status' => 'required|integer',
            'created_by' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            // dd($data);
            $travel = Travel::create($data);

            return response()->json($this->sendResponse1($travel, 'Admin Travel Created Successfully'));
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
            $tavel = Travel::find($id);
            return response()->json($this->sendResponse1($tavel, 'Admin Travel Show Successfully'));
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
            'travel' => 'required',
            'status' => 'required|integer',
            'updated_by' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $travel = Travel::find($id);
            $travel->update($data);
            return response()->json($this->sendResponse1($travel, 'Admin Travel Updated Successfully'));
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
            $travel = Travel::find($id);
            if (!$travel) {
                # code...
                throw new \Exception("Admin Travel not found");

            }
            Travel::destroy($id);
            $grade = [];
            return response()->json($this->sendResponse1($grade, 'Admin Travel Deleted Successfully'));

        } catch (\Exception $e) {
            //throw $th;
            return response()->json($this->sendError1($e->getMessage(), 'error'));

        }
    }
}
