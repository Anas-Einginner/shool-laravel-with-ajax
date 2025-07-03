<?php

namespace App\Http\Controllers\DasboardTeachers\Quizzs;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Quizz;
use App\Models\Subject;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuizzController extends Controller
{

    function index()
    {
        return view('dashboard.dashboard_teachers.quizzes.view');
    }



    function getdata(Request $request)
    {
        $grades = Quizz::query();

        return DataTables::of($grades)
            ->filter(function ($qur) use ($request) {
                if ($request->get('name')) {
                    // like %...% , %.. , ..%
                    $qur->where('name', 'like', '%' .  $request->get('name') . '%');
                }

                if ($request->get('phone')) {
                    $qur->where('phone', 'like', '%' .  $request->get('phone') . '%');
                }


                if ($request->get('email')) {
                    $qur->where('users.email', 'like', '%' . $request->get('email') . '%');
                }
            })
            ->addIndexColumn()
             ->addColumn('time', function ($qur) {
              return $qur->time . ' ' . 'دقيقة' ;
            })
             ->addColumn('start', function ($qur) {

               return Carbon::parse($qur->start)->format('d-m-Y h:i A');
                //return '5';
            })
            ->addColumn('end', function ($qur) {

               return Carbon::parse($qur->end)->format('d-m-Y h:i A');
                //return '5';
            })
            ->addColumn('score', function ($qur) {
                return $qur->questions->sum('grade');
            })
            ->addColumn('count_q', function ($qur) {
              $q  = Question::query()->where('quizz_id' , $qur->id)->count();
                return $q;
            })
            ->addColumn('action', function ($qur) {
                $data_attr = ' ';
                /* $data_attr .= 'data-id="' . $qur->id . '" ';
                $data_attr .= 'data-name="' . $qur->name . '" ';
                $data_attr .= 'data-email="' . $qur->user->email . '" ';
                $data_attr .= 'data-phone="' . $qur->phone . '" ';
                $data_attr .= 'data-qual="' . $qur->qual . '" ';
                $data_attr .= 'data-spec="' . $qur->spec . '" ';
                $data_attr .= 'data-gender="' . $qur->gender . '" ';
                $data_attr .= 'data-status="' . $qur->status . '" ';
                $data_attr .= 'data-date-of-birth="' . $qur->date_of_birth . '" ';
                $data_attr .= 'data-hire-date="' . $qur->hire_date .  '" ';*/

                $action = '';
                $action .= '<div class="d-flex align-items-center gap-3 fs-6">';

                $action .= '<a  href="' .  route('dash.teacher.quizz.edit', $qur->id) . '" class="text-warning"  data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill "></i></a>';

                $action .= '     <a data-id="' . $qur->id . '"  data-url="' . route('dash.teacher.quizz.delete') . '" class="text-danger delete-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>';
                $action .= '</div>';

                return $action;
            })
            ->rawColumns(['status', 'action', 'gender'])
            ->make(true);
    }

    function create()
    {
        return view('dashboard.dashboard_teachers.quizzes.index');
    }

    function add(Request $request)
    {
        //  dd($request->all());
         $teacher = auth()->user()->teacher;
        $subject = Subject::query()->where('teacher_id', $teacher ->id)->first();
        $qiuzz = Quizz::create([
            'title' => $request->title,
            'time' => $request->duration,
            'start' => $request->start_time,
            'end' => $request->end_time,
            'subject_id' => $subject->id,
        ]);

        foreach ($request->questions as $question) {
            // questions
            $q = $qiuzz->questions()->create([
                'text' => $question['text'],
                'type' => $question['type'],
                'grade' => $question['grade'],
            ]);

            if ($question['type'] === 'msq') {
                foreach ($question['options'] as $optionText) {
                    $q->options()->create([
                        'text' => $optionText,
                    ]);
                }
                $correctOptionIndex = $question['correct_option'] - 1;
                $correctOption = $q->options()->skip($correctOptionIndex)->first();

                if ($correctOption) {
                    $q->correctAnswer()->create([
                        'option_id' => $correctOption->id,
                        'correct_value' => null,
                    ]);
                }
            } elseif ($question['type'] === 'tf') {
                $q->correctAnswer()->create([
                    'option_id' => null,
                    'correct_value' => $question['correct_tf'],
                ]);
            }
        }


        return redirect()->back();
    }

    function edit($id)
    {
        $quizz = Quizz::with('questions.options', 'questions.correctAnswer')->findOrFail($id);
        return view('dashboard.dashboard_teachers.quizzes.edit',  compact('quizz'));
    }

    function update(Request $request, $id)
    {
        //dd($request->all());
        $quizz = Quizz::query()->findOrFail($id);
        $quizz->update([
            'title' => $request->title,
            'time' => $request->duration,
            'start' => $request->start_time,
            'end' => $request->end_time,
        ]);

        $questionData = $request->questions;

        foreach ($questionData as $q) {
            if (isset($q['id'])) {
                $question = Question::find($q['id']);
                if (!$question) continue;
                $question->update([
                    'text' => $q['text'],
                    'type' => $q['type'],
                    'grade' => $q['grade'],
                ]);

                if ($q['type'] === 'msq') {
                    $question->options()->delete();
                    if (isset($q['options']) && is_array($q['options'])) {
                        foreach ($q['options'] as $option) {
                            $question->options()->create([
                                'text' => $option,
                            ]);
                        }
                    }

                    $correctOptionIndex = $q['correct_option'];
                    $option = $question->options()->skip($correctOptionIndex - 1)->first();

                    if ($option) {
                        $question->correctAnswer()->updateOrCreate([
                            'question_id' => $question->id
                        ], [
                            'option_id' => $option->id,
                            'correct_value' => null,
                        ]);
                    }
                } elseif ($q['type'] === 'tf') {
                    $question->options()->delete();
                    $question->correctAnswer()->updateOrCreate([
                        'question_id' => $question->id

                    ], [
                        'option_id' => null,
                        'correct_value' => $q['correct_tf']
                    ]);
                }
            } else {
                $question = $quizz->questions()->create([
                    'text' => $q['text'],
                    'type' => $q['type'],
                    'grade' => $q['grade'],
                ]);

                if ($q['type'] === 'msq') {
                    if (isset($q['options']) && is_array($q['options'])) {
                        foreach ($q['options'] as $option) {
                            $question->options()->create([
                                'text' => $option,
                            ]);
                        }
                    }


                    $correctOptionIndex = $q['correct_option'];
                    $option = $question->options()->skip($correctOptionIndex - 1)->first();

                    if ($option) {
                        $question->correctAnswer()->create(['option_id' => $option->id]);
                    }
                } elseif ($q['type'] === 'tf') {
                    $question->correctAnswer()->create(['correct_value' => $q['correct_tf']]);
                }
            }
        }

        return redirect()->route('dash.teacher.quizz.index');
    }
    function delete(Request $request)
    {
        $quizz = Quizz::find($request->id);
        $quizz->delete();

        return response()->json([
            'success' => 'تم حذف المادة بنجاح.'
        ]);
    }

}
