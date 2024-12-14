<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImageCourse;
use Illuminate\Support\Facades\Validator;

class ImageCourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $imageCourses = ImageCourse::query();

        return response()->json([
            'status' => 'success',
            'data' => $imageCourses->paginate(10)
        ], 200);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'course_id' =>'required|exists:courses,id',
            'image' => 'required|url'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
               'status' => 'error',
               'message' => $validator->errors()->first()
            ], 422);
        }

        $imageCourse = ImageCourse::create($data);

        return response()->json([
           'status' => 'success',
           'message' => 'Image uploaded successfully',
           'data' => $imageCourse
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $imageCourse = ImageCourse::find($id);

        if (!$imageCourse) {
            return response()->json([
               'status' => 'error',
               'message' => 'Image not found'
            ], 404);
        }

        return response()->json([
           'status' => 'success',
           'data' => $imageCourse
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'course_id' =>'exists:courses,id',
            'image' => 'url'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
               'status' => 'error',
               'message' => $validator->errors()->first()
            ], 422);
        }

        $imageCourse = ImageCourse::find($id);

        if (!$imageCourse) {
            return response()->json([
               'status' => 'error',
               'message' => 'Image not found'
            ], 404);
        }

        $imageCourse->update($data);

        return response()->json([
           'status' => 'success',
           'message' => 'Image updated successfully',
           'data' => $imageCourse
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $imageCourse = ImageCourse::find($id);

        if (!$imageCourse) {
            return response()->json([
               'status' => 'error',
               'message' => 'Image not found'
            ], 404);
        }

        $imageCourse->delete();

        return response()->json([
           'status' => 'success',
           'message' => 'Image deleted successfully'
        ], 200);
    }
}
