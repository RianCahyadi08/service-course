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
    public function index(Request $request)
    {
        $courses = Course::query();

        $key = $request->query('key');
        $status = $request->query('status');

        $courses->when($key, function($query) use ($key) {
            return $query->where('name', 'LIKE', '%'.strtolower($key).'%');
        });

        $courses->when($status, function($query) use ($status) {
            return $query->where('status', $status);
        });

        return response()->json([
            'status' => 'success',
            'data' => $courses->paginate(10)
        ], 200);
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
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
               'status' => 'error',
               'message' => 'Course not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $course
        ], 200);
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
        $rules = [
            'name' => 'string',
            'thumbnail' => 'string|url',
            'type' => 'in:free,premium',
            'status' => 'in:draft,published',
            'price' => 'numeric',
            'level' => 'in:all-level,beginner,intermediate,advance',
            'description' => 'string',
            'is_certificate' => 'boolean',
            'mentor_id' => 'exists:mentors,id'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'error' => $validator->errors()
            ], 400);
        }

        $course = Course::find($id);

        if (!$course) {
            return response()->json([
               'status' => 'error',
               'message' => 'Course not found'
            ], 404);
        }

        $course->fill($data);
        $course->save();

        return response()->json([
            'status' => 'success',
            'data' => $course,
           'message' => 'Course updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json([
               'status' => 'error',
               'message' => 'Course not found'
            ], 404);
        }

        $course->delete();

        return response()->json([
           'status' => 'success',
           'message' => 'Course deleted successfully'
        ], 200);
    }
}
