<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Course;
use App\Models\Mentor;

class CourseController extends Controller
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
        $rules = [
            'name' => 'required|string',
            'thumbnail' => 'string|url',
            'type' => 'required|in:free,premium',
            'status' => 'required|in:draft,published',
            'price' => 'numeric',
            'level' => 'required|in:all-level,beginner,intermediate,advance',
            'description' => 'string',
            'is_certificate' => 'required|boolean',
            'mentor_id' => 'required|exists:mentors,id'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ], 400);
        }

        $course = Course::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $course,
            'message' => 'Course created successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
