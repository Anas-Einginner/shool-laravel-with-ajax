<?php

namespace App\Http\Controllers\Lectures;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LectureController extends Controller
{
  function index()
    {
        $subjects = Subject::all();
        $teachers = Teacher::all();
        return view('dashboard.lectures.index'  , compact('subjects' , 'teachers'));
    }

    function getdata(Request $request)
    {

        $grades = Lecture::query();

        return DataTables::of($grades)
            ->filter(function ($qur) use ($request) {
              /*  if($request->get('name')){
                    // like %...% , %.. , ..%
                 $qur->where('name' , 'like' , '%' .  $request->get('name') . '%');
                }

                if($request->get('phone' )){
                 $qur->where('phone' , 'like' , '%' .  $request->get('phone') . '%');
                }*/

            })
            ->addIndexColumn()
            ->addColumn('subject', function ($qur) {
                return $qur->subject->title;
            })
            ->addColumn('teacher', function ($qur) {
                return $qur->teacher->name;
            })
            ->addColumn('link', function ($qur) {
                return '<a class="btn btn-info btn-sm" target="_blank" href="'. $qur->link .'">رابط المحاضرة</a>';
            })
            ->addColumn('action', function ($qur) {
                $data_attr = ' ';
                /*$data_attr .= 'data-id="' . $qur->id . '" ';
                $data_attr .= 'data-name="' . $qur->name . '" ';
                $data_attr .= 'data-email="' . $qur->user->email . '" ';
                $data_attr .= 'data-phone="' . $qur->phone . '" ';
                $data_attr .= 'data-qual="' . $qur->qual . '" ';
                $data_attr .= 'data-spec="' . $qur->spec . '" ';
                $data_attr .= 'data-gender="' . $qur->gender . '" ';
                $data_attr .= 'data-status="' . $qur->status . '" ';
                $data_attr .= 'data-date-of-birth="' . $qur->date_of_birth . '" ';
                $data_attr .= 'data-hire-date="' . $qur->hire_date .  '" ';
*/
                $action = '';
                $action .= '<div class="d-flex align-items-center gap-3 fs-6">';

                $action .= '<a ' . $data_attr . ' data-bs-toggle="modal" data-bs-target="#update-modal" class="text-warning update_btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill "></i></a>';

                    $action .= '     <a data-id="' . $qur->id . '"  data-url="' . route('dash.teacher.delete') . '" class="text-danger delete-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>';

                $action .= '</div>';

                return $action;
            })
            ->rawColumns(['status', 'action', 'gender' , 'link'])
            ->make(true);
    }

      function add(Request $request)
    {
        $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'desc'  => ['required' , 'string' , 'min:20'],
            'subject'  => ['required' , 'exists:subjects,id'],
            'teacher'   => ['required' , 'exists:teachers,id'],
            'link'   => ['required' , 'url'],
        ]);

        Lecture::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'subject_id' => $request->subject,
            'teacher_id' => $request->teacher,
            'link' => $request->link,
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }
}