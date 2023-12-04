<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\AdminMeal;


class AdminMeadController extends ApiController
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
            'breakfast' => 'required|integer',
            'lunch' => 'required|integer',
            'dinner' => 'required|integer',
            'price' => 'required',
            'status' => 'required|integer',
            'created_by' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            // dd($data);
            $meal = AdminMeal::create($data);
            return response()->json($this->sendResponse1($meal, 'Admin Meal Created Successfully'));
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
            $grade = AdminMeal::find($id);
            return response()->json($this->sendResponse1($grade, 'Admin Meal Show Successfully'));
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
            'grade_id' => 'required|integer',
            'breakfast' => 'required|integer',
            'lunch' => 'required|integer',
            'dinner' => 'required|integer',
            'price' => 'required',
            'status' => 'required|integer',
            'updated_by' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $admin_meal = AdminMeal::find($id);
            $admin_meal->update($data);
            return response()->json($this->sendResponse1($admin_meal, 'Admin Meal Updated Successfully'));
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
        try {
            // $data = $request->all();
            $admin_meal = AdminMeal::find($id);
            if (!$admin_meal) {
                # code...
                throw new \Exception("Admin Meal not found");

            }
            AdminMeal::destroy($id);
            $grade = [];
            return response()->json($this->sendResponse1($grade, 'Admin Meal Deleted Successfully'));

        } catch (\Exception $e) {
            //throw $th;
            return response()->json($this->sendError1($e->getMessage(), 'error'));

        }
    }
}
