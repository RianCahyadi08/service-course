<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chapter;
use App\Models\Lesson;
use Illuminate\Support\Facades\Validator;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lesson = Lesson::query();

        $key = $request->query('key');

        $lesson->when($key, function($query) use ($key) {
            return $query->where('name', 'like', "%{$key}%");
        });

        $chapter_id = $request->query('chapter_id');

        $lesson->when($chapter_id, function($query) use ($chapter_id) {
            return $query->where('chapter_id', $chapter_id);
        });

        return response()->json([
           'status' =>'success',
            'data' => $lesson->paginate(10)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' =>'required|string',
            'video_url' => 'required|url',
            'chapter_id' =>'required|exists:chapters,id'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
               'status' => 'error',
               'message' => $validator->errors()
            ], 400);
        }

        $lesson = Lesson::create($data);

        return response()->json([
           'status' => 'success',
           'message' => 'The lessons has been created successfully',
            'data' => $lesson
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json([
               'status' => 'error',
               'message' => 'Lesson not found'
            ], 404);
        }

        return response()->json([
           'status' => 'success',
            'data' => $lesson
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' =>'string',
            'video_url' => 'url',
            'chapter_id' => 'exists:chapters,id'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
               'status' => 'error',
               'message' => $validator->errors()
            ], 400);
        }

        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json([
               'status' => 'error',
               'message' => 'Lesson not found'
            ], 404);
        }

        $lesson->update($data);

        return response()->json([
           'status' => 'success',
           'message' => 'The lesson has been updated successfully',
            'data' => $lesson
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return response()->json([
               'status' => 'error',
               'message' => 'Lesson not found'
            ], 404);
        }

        $lesson->delete();

        return response()->json([
           'status' => 'success',
           'message' => 'The lesson has been deleted successfully'
        ], 200);
    }
}
