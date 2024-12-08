<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Mentor;

class MentorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mentors = Mentor::orderBy('name', 'asc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $mentors
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'profile_url' => 'required|url',
            'email' => 'required|email',
            'profession' => 'required|string',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ], 400);
        }

        $mentor = Mentor::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $mentor,
            'message' => 'Mentor created successfully'
        ], 200);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json([
               'status' => 'error',
               'message' => 'Mentor not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $mentor
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'required|string',
            'profile_url' => 'required|url',
            'email' => 'required|email',
            'profession' => 'required|string',
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ], 400);
        }

        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json([
               'status' => 'error',
               'message' => 'Mentor not found'
            ], 404);
        }

        $mentor->fill($data);
        $mentor->save();

        return response()->json([
            'status' => 'success',
            'data' => $mentor,
            'message' => 'Mentor updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mentor = Mentor::find($id);

        if (!$mentor) {
            return response()->json([
               'status' => 'error',
               'message' => 'Mentor not found'
            ], 404);
        }

        $mentor->delete();

        return response()->json([
           'status' => 'success',
           'message' => 'Mentor deleted successfully'
        ], 200);
    }
}
