<?php

namespace App\Http\Controllers\DasboardTeachers\Lectures;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class LecturesController extends Controller
{
    function index()
    {
        return view('dashboard.dashboard_teachers.lectures.index');
    }

    function getdata(Request $request)
    {
        $user = Auth::user()->teacher;
        $grades = Lecture::query()->where('teacher_id', $user->id);

        return DataTables::of($grades)
            ->filter(function ($qur) use ($request) {
                if ($request->get('title')) {
                    // like %...% , %.. , ..%
                    $qur->where('title', 'like', '%' .  $request->get('title') . '%');
                }

                if ($request->get('desc')) {
                    $qur->where('desc', 'like', '%' .  $request->get('desc') . '%');
                }
            })
            ->addIndexColumn()

            ->addColumn('link', function ($qur) {
                return '<a class="btn btn-info btn-sm" target="_blank" href="' . $qur->link . '">رابط المحاضرة</a>';
            })
            ->addColumn('action', function ($qur) {
                $data_attr = ' ';
                $data_attr .= 'data-id="' . $qur->id . '" ';
                $data_attr .= 'data-title="' . $qur->title . '" ';
                $data_attr .= 'data-desc="' . $qur->desc . '" ';
                $data_attr .= 'data-link="' . $qur->link . '" ';

                $action = '';
                $action .= '<div class="d-flex align-items-center gap-3 fs-6">';

                $action .= '<a ' . $data_attr . ' data-bs-toggle="modal" data-bs-target="#update-modal" class="text-warning update_btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill "></i></a>';

                $action .= '     <a data-id="' . $qur->id . '"  data-url="' . route('dash.teacher.lecture.delete') . '" class="text-danger delete-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>';

                $action .= '</div>';

                return $action;
            })
            ->rawColumns(['status', 'action', 'gender', 'link'])
            ->make(true);
    }

    function add(Request $request)
    {
        $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'desc'  => ['required', 'string', 'min:5'],
            'link'   => ['required', 'url'],
        ]);
        $subject = Subject::query()->where('teacher_id', auth()->user()->teacher->id)->first();
        Lecture::create([
            'title' => $request->title,
            'desc' => $request->desc,
            'subject_id' => $subject->id,
            'teacher_id' => auth()->user()->teacher->id,
            'link' => $request->link,
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }
    function update(Request $request)
    {
     

        $request->validate([
            'id'     => ['required', 'exists:lectures,id'],
            'title'   => ['required', 'string', 'max:255'],
            'desc'  => ['required', 'string', 'min:5'],
            'link'   => ['required', 'url'],
        ]);

          $lecture = Lecture::query()->findOrFail($request->id);

        $lecture->update([
            'title' => $request->title,
            'desc' => $request->desc,
            'link' => $request->link,
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }
    function delete(Request $request)
    {
        $lecture = Lecture::where('id', $request->id)
            ->where('teacher_id', auth()->user()->teacher->id)
            ->first();
        $lecture->delete();

        return response()->json([
            'success' => 'تم حذف المحاضرة بنجاح.'
        ]);
    }
}
