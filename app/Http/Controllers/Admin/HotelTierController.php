<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\HotelTier;

class HotelTierController extends ApiController
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
            'city_tier_id' => 'required|integer',
            'status' => 'required|integer',
            'created_by' => 'required|integer',
            'price' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $data['price'] = json_encode($request->price);
            // dd($data);
            $hotel = HotelTier::create($data);
            $hotel->price = json_decode($hotel->price);

            return response()->json($this->sendResponse1($hotel, 'Admin Hotel Tier Created Successfully'));
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
            $hotel = HotelTier::find($id);
            $hotel->price = json_decode($hotel->price);
            return response()->json($this->sendResponse1($hotel, 'Admin Hotel Tier Show Successfully'));
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
            'price' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response(['error' => $validator->errors()]);
        }

        try {
            $data = $request->all();
            $hotel = HotelTier::find($id);

            if ($hotel->price) {
                # code...
                json_encode($hotel->price);
            }
            // dd($hotel);
            $hotel->update($data);
            // dd($hotel);
            // $hotel->price = json_decode($hotel->price);

            return response()->json($this->sendResponse1($hotel, 'Admin Hotel Tier Updated Successfully'));
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
            $hotel = HotelTier::find($id);
            if (!$hotel) {
                # code...
                throw new \Exception("Admin Hotel Tier not found");

            }
            HotelTier::destroy($id);
            $hotel = [];
            return response()->json($this->sendResponse1($hotel, 'Admin Hotel Tier Deleted Successfully'));

        } catch (\Exception $e) {
            //throw $th;
            return response()->json($this->sendError1($e->getMessage(), 'error'));

        }
    }
}
