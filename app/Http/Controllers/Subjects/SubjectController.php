<?php

namespace App\Http\Controllers\Subjects;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\Lecture;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubjectController extends Controller
{
    function index()
    {
        $teachers = Teacher::all()->where('status','active');
        $grades = Grade::all()->where('status','active');
        return view('dashboard.subjects.index', compact('teachers', 'grades'));
    }

    function getdata(Request $request)
    {
        $grades = Subject::query();

        return DataTables::of($grades)
            ->addIndexColumn()
            ->addColumn('teacher', function ($qur) {
                return $qur->teacher->name;
            })
            ->addColumn('grade', function ($qur) {
                return $qur->grade->name;
            })
            ->addColumn('book', function ($qur) {
                return '    <a href="' . route('dash.subject.download', $qur->book) . '" class="btn btn-primary btn-sm"
                            >
                            كتاب "' . $qur->title . '"  ' . $qur->grade->name . '
                        </a>';
            })
            ->addColumn('lectures', function ($qur) {
                return '    <a href="' . route('dash.subject.lectures', $qur->id) . '" class="btn btn-primary btn-sm"
                            >عرض جميع المحاضرات</a>';
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

                $action .= '<a ' . $data_attr . ' data-bs-toggle="modal" data-bs-target="#update-modal" class="text-warning update_btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Edit info" aria-label="Edit"><i class="bi bi-pencil-fill "></i></a>';

                $action .= '     <a data-id="' . $qur->id . '"  data-url="' . route('dash.subject.delete') . '" class="text-danger delete-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="" data-bs-original-title="Delete" aria-label="Delete"><i class="bi bi-trash-fill"></i></a>';

                $action .= '</div>';

                return $action;
            })
            ->rawColumns(['action', 'book', 'lectures'])
            ->make(true);
    }

    function add(Request $request)
    {


        $request->validate([
            'title'   => ['required', 'string', 'max:255'],
            'teacher'  => ['required', 'exists:teachers,id'],
            'grade'  => ['required',  'exists:grades,id'],
            'book'   => ['required', 'mimes:pdf', 'max:5120'],
        ],  [
            'title.required' => 'عنوان المادة مطلوب.',
            'title.string' => 'عنوان المادة يجب أن يكون نصاً.',
            'teacher.required' => 'يرجى اختيار المدرس.',
            'teacher.exists' => 'المعلم المحدد غير موجود.',
            'book.required' => 'يرجى رفع كتاب المادة.',
            'book.mimes' => 'يجب أن يكون الكتاب بصيغة PDF فقط.',
            'book.max' => 'أقصى حجم للكتاب هو 5 ميجابايت.',
            'grade.required' => 'يرجى إدخال المرحلة الدراسية.',
            'grade.string' => 'المرحلة الدراسية يجب أن تكون نصاً.',
        ]);


        $name = 'LearnSchool_' . time() . '_' . rand() . '.' . $request->file('book')->getClientOriginalExtension();
        $request->file('book')->move(public_path('uploads\books'), $name);

        $grade = Grade::query()->where('tag', $request->grade)->first();

        Subject::create([
            'title' => $request->title,
            'teacher_id' => $request->teacher,
            'grade_id' => $grade->id,
            'book' => $name,
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    function download($filename)
    {
        $path = public_path('uploads/books/' . $filename);

        return response()->download($path);
    }

    function lectures($id)
    {
        $subject = Subject::query()->findOrFail($id);
        return view('dashboard.subjects.lectures', compact('subject'));
    }

    function getdataLectures(Request $request)
    {
        //dd($request->all());
        $grades = Lecture::query()->where('subject_id', $request->id);
        //dd($grades);
        return DataTables::of($grades)
            ->filter(function ($qur) use ($request) {
                if ($request->get('title')) {
                    // like %...% , %.. , ..%
                    $qur->where('title', 'like', '%' .  $request->get('title') . '%');
                }
                if ($request->get('desc')) {
                    // like %...% , %.. , ..%
                    $qur->where('desc', 'like', '%' .  $request->get('desc') . '%');
                }
            })
            ->addIndexColumn()
            ->addColumn('subject', function ($qur) {
                return $qur->subject->title;
            })
            ->addColumn('teacher', function ($qur) {
                return $qur->teacher->name;
            })
            ->addColumn('link', function ($qur) {
                return '<a class="btn btn-info btn-sm" target="_blank" href="' . $qur->link . '">رابط المحاضرة</a>';
            })
            ->rawColumns(['link'])
            ->make(true);
    }
    function delete(Request $request)
    {
        $subject = Subject::find($request->id);
        $subject->delete();

        return response()->json([
            'success' => 'تم حذف المادة بنجاح.'
        ]);
    }


    /*
    function update(Request $request)
    {
        $teacher = Teacher::query()->findOrFail($request->id);
        $user = User::query()->findOrFail($teacher->user_id);

        $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'  => ['required', Rule::unique('teachers', 'phone')->ignore($request->id)],
            'qual'   => ['required', 'in:d,b,m,dr'],
            'status'   => ['required', 'in:active,inactive'],
            'spec'   => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:m,fm'],
            'date_of_birth' => ['required', 'date', 'before:hire_date'],
            'hire_date' => ['required', 'date', 'after:date_of_birth'],
        ], [
            'name.required'     => 'الاسم مطلوب.',
            'name.string'       => 'الاسم يجب أن يكون نصاً.',
            'name.max'          => 'الاسم لا يجب أن يتجاوز 255 حرفاً.',

            'email.required'    => 'البريد الإلكتروني مطلوب.',
            'email.email'       => 'يرجى إدخال بريد إلكتروني صحيح.',
            'email.max'         => 'البريد الإلكتروني طويل جداً.',
            'email.unique'      => 'هذا البريد الإلكتروني مستخدم مسبقاً.',

            'phone.required'    => 'رقم الهاتف مطلوب.',
            'phone.regex'       => 'صيغة رقم الهاتف غير صحيحة.',
            'phone.unique'      => 'رقم الهاتف مستخدم مسبقاً.',

            'qual.required'     => 'المؤهل العلمي مطلوب.',
            'qual.in'       => 'القيمة المدخلة للمؤهل العلمي غير صالحة .',

            'spec.required'     => 'التخصص مطلوب.',
            'spec.string'       => 'التخصص يجب أن يكون نصاً.',

            'gender.required'   => 'الجنس مطلوب.',
            'gender.in'         => 'القيمة المدخلة للجنس غير صالحة.',

            'date_of_birth.required'  => 'تاريخ الميلاد مطلوب.',
            'date_of_birth.date'      => 'صيغة تاريخ الميلاد غير صحيحة.',
            'date_of_birth.before'    => 'تاريخ الميلاد يجب أن يكون قبل تاريخ التعيين.',

            'hire_date.required'  => 'تاريخ التعيين مطلوب.',
            'hire_date.date'      => 'صيغة تاريخ التعيين غير صحيحة.',
            'hire_date.after'     => 'تاريخ التعيين يجب أن يكون بعد تاريخ الميلاد.',
        ]);

        $user->update([
            'email' => $request->email,
        ]);

        $teacher->update([
            'name' => $request->name,
            'qual' => $request->qual,
            'spec' => $request->spec,
            'gender' => $request->gender,
            'status' => $request->status,
            'phone' => $request->phone,
            'hire_date' => $request->hire_date,
            'date_of_birth' => $request->date_of_birth,
            'user_id' =>  $user->id
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    function delete(Request $request)
    {

        $teacher = Teacher::query()->findOrFail($request->id);
        if ($teacher) {
            $teacher->update([
                'status' => 'inactive',
            ]);
        }
        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }


    function active(Request $request) {
        $teacher = Teacher::query()->findOrFail($request->id);
        if ($teacher) {
            $teacher->update([
                'status' => 'active',
            ]);
        }
        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }*/
}
