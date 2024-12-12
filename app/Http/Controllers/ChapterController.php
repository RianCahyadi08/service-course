<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Chapter;
use App\Models\Course;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $chapters = Chapter::query();

        $key = $request->query('key');

        $chapters->when($key, function($query) use ($key) {
            return $query->where('name', 'like', "%{$key}%");
        });

        $course_id = $request->query('course_id');
        $chapters->when($course_id, function($query) use ($course_id) {
            return $query->where('course_id', $course_id);
        });

        return response()->json([
            'status' => 'success',
            'data' => $chapters->paginate(10)
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
            'course_id' => 'required|exists:courses,id'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
               'status' => 'error',
                'error' => $validator->errors()
            ], 400);
        }

        $chapter = Chapter::create($data);

        return response()->json([
            'status' => 'success',
            'data' => $chapter,
           'message' => 'Chapter created successfully'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json([
               'status' => 'error',
               'message' => 'Chapter not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $chapter
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'name' => 'string',
            'course_id' => 'exists:courses,id'
        ];

        $data = $request->all();

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return response()->json([
               'status' => 'error',
                'error' => $validator->errors()
            ], 400);
        }

        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json([
               'status' => 'error',
               'message' => 'Chapter not found'
            ], 404);
        }

        $chapter->fill($data);
        $chapter->save();

        return response()->json([
            'status' => 'success',
            'data' => $chapter,
           'message' => 'Chapter updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $chapter = Chapter::find($id);

        if (!$chapter) {
            return response()->json([
               'status' => 'error',
               'message' => 'Chapter not found'
            ], 404);
        }

        $chapter->delete();

        return response()->json([
            'status' => 'success',
           'message' => 'Chapter deleted successfully'
        ], 200);
    }
}
