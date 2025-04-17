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
}
