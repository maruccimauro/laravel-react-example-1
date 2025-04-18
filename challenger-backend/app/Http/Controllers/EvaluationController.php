<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EvaluationController extends Controller
{

    //
    public function index()
    {
        $evaluations = Evaluation::with(['student', 'teacher'])->get();

        $data = $evaluations->map(function ($evaluation) {
            return [
                'id' => $evaluation->id,
                'score' => $evaluation->score,
                'specific_date' => $evaluation->specific_date,
                'student_id' => $evaluation->student_id,
                'techer_id' => $evaluation->teacher_id,
                'student_name' => $evaluation->student->name,
                'teacher_name' => $evaluation->teacher->name
            ];
        });

        return response()->json($data, 200);
    }



    public function store(Request $request)
    {

        // we manage the date
        try {
            $parsedDate = Carbon::parse($request->input('specific_date'));
            $formattedDate = $parsedDate->format('Y/m/d');
            $request->merge(['specific_date' => $formattedDate]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid date format.',
                'errors' => ['specific_date' => ['The date format is invalid.']]
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|numeric|exists:users,id',
            'teacher_id' => 'required|numeric|exists:users,id',
            'score' => 'required|numeric|min:1|max:10',
            'specific_date' => 'required|date'
        ]);

        //was there an error in the validation?
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Data validator error.',
                    'errors' => $validator->errors()
                ],
                422
            );
        }

        // is it a valid teacher id?
        $teacher = User::find($request->teacher_id);
        if ($teacher->role !== 'teacher') {
            return response()->json([
                'message' => 'Only teachers can upload a score'
            ], 403);
        }

        //Is the id the same teacher?
        $currentUser = Auth::user();
        if ($currentUser->id !== (int) $request->teacher_id) {
            return response()->json(['message' => 'You are not authorized to upload a score for another teacher.',], 403);
        }

        // the score is for one student?
        $student = User::find($request->student_id);
        if ($student->role !== 'student') {
            return response()->json(['message' => 'You shoul dont give a rating to a teacher, only to students.'], 403);
        }

        // we create the record
        Evaluation::create([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'score' => $request->score,
            'specific_date' => Carbon::createFromFormat('Y/m/d', $request->specific_date)->format('Y-m-d')
        ]);

        return response()->json(['message' => 'Evaluation score created successfully'], 201);
    }

    public function show($evaluation)
    {
        $evaluation = Evaluation::where('id', $evaluation)->with(['student', 'teacher'])->first();

        if (!$evaluation) {
            return response()->json(['message' => 'Evaluation not found.'], 404);
        }

        return response()->json($evaluation, 200);
    }

    public function update(Request $request, $evaluation)
    {
        $evaluation = Evaluation::find($evaluation);

        if (!$evaluation) {
            return response()->json(['message' => 'Evaluation not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'student_id' => 'required|numeric|exists:users,id',
            'teacher_id' => 'required|numeric|exists:users,id',
            'score' => 'required|numeric|min:1|max:10',
            'specific_date' => 'required|date'
        ]);

        //was there an error in the validation?
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'Data validator error.',
                    'errors' => $validator->errors()
                ],
                422
            );
        }


        // we manage the date
        try {
            $parsedDate = Carbon::parse($request->input('specific_date'));
            $formattedDate = $parsedDate->format('Y/m/d');
            $request->merge(['specific_date' => $formattedDate]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Invalid date format.',
                'errors' => ['specific_date' => ['The date format is invalid.']]
            ], 422);
        }


        // is it a valid teacher id?
        $teacher = User::find($evaluation->teacher_id);
        if ($teacher->role !== 'teacher') {
            return response()->json([
                'message' => 'Only teachers can upload a score'
            ], 403);
        }

        //Is the id the same teacher?
        $currentUser = Auth::user();
        if ($currentUser->id !== (int) $evaluation->teacher_id) {
            return response()->json(['message' => 'You are not authorized to upload a score for another teacher.',], 403);
        }

        $evaluation->update([
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id,
            'score' => $request->score,
            'specific_date' => Carbon::createFromFormat('Y/m/d', $request->specific_date)->format('Y-m-d')
        ]);


        return response()->json([
            'message' => 'Evaluation updated successfully',
            'evaluation' => $evaluation
        ], 200);
    }
}
