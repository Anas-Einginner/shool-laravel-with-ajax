<?php

namespace App\Http\Controllers\Grades;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\GradeSection;
use App\Models\Section;
use App\Models\Stage;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class GradeController extends Controller
{
    function index()
    {
        return view('dashboard.grades.index');
    }

    function getdata(Request $request)
    {
        $grades = Grade::query()->orderByRaw("status = 'active' DESC");
        return DataTables::of($grades)
            ->addIndexColumn()
            ->addColumn('action', function ($qur) {
                if($qur->status == 'active'){
                    return ' <div data-bs-toggle="modal" data-grade-id="'. $qur->id .'" data-grade="'.  $qur->tag  .'" data-bs-target="#sectionModal" class="d-flex align-items-center gap-3 fs-6 btn-add-section">
                    <a href="javascript:;" class="text-success" data-bs-toggle="tooltip" data-bs-placement="bottom" ><i class="fadeIn animated bx bx-message-square-add"></i></a>
                  </div>';
                }

                return '-' ;

            })
            ->addColumn('stage', function ($qur) {
                return $qur->stage->name;
            })
            ->addColumn('status', function ($qur) {
                        if($qur->status == 'active'){
                            return 'مفعل' ;
                        }
                        return 'غير مفعل' ;
            })
            ->make(true);
    }


    function add(Request $request)
    {
        //  dd($request->all());
        $request->validate([
            'name' => 'required',
            'tag' => 'required',
            'stage' => 'required',
            'status' => 'required'
        ], [
            'name.required' => 'حقل الاسم مطلوب ',
            'status.required' => 'حقل الحالة مطلوب ',
            'stage.required' => 'حقل المرحلة مطلوب ',
            'tag.required' => 'حقل المرحلة مطلوب ',
        ]);

        $stage_id = Stage::getIdByTag($request->stage);
        $status = Grade::getStatusByCode($request->status); // ac , inac
        $grade = Grade::query()->where('tag', $request->tag)->first();

        $grade->update([
            'name' => $request->name,
            'tag' => $request->tag,
            'stage_id' => $stage_id,
            'status' => $status,
        ]);

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }


    function getactive() {

        $actives = Grade::query()->where('status' , 'active')->pluck('tag');

        return response()->json([
            'tags' => $actives
        ]);

    }


    function getactivestage() {

        $actives = Stage::query()->where('status' , 'active')->pluck('tag');

        return response()->json([
            'tags' => $actives
        ]);

    }

    function addsection(Request $request) {
        // dd($request->all());
        $section = Section::query()->where('name' , $request->section)->first();
        $grade= Grade::query()->where('tag' , $request->gradetag)->first();

      // section id  1
      // grade id 2

      if($request->status == '1'){
        $status =  'active' ;
      }else{
        $status = 'inactive' ;
      }
         GradeSection::query()->updateOrCreate([
            'grade_id' => $grade->id,
            'section_id' => $section->id ,
         ] , [
            'status' => $status,

         ]);

         return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);

    }

    function getactivesection(Request $request) {
       // dd($request->all());
        $actives = GradeSection::query()->where('status' , 'active')->where('grade_id' , $request->gradeId)->get()->pluck('section.name');

       // dd($actives);
        return response()->json([
            'names' => $actives
        ]);
    }

    function changemaster(Request $request) {

        $stage = Stage::query()->where('tag' , $request->tag)->first();
        $gradesActive = Grade::query()->where('stage_id' , $stage->id)->where('status' , 'active')->get();
        //dd($gradesActive);

        if($request->status == 1){
            $stage->update([
                'status' => 'active'
            ]);
        }else{

            $stage->update([
                'status' => 'inactive'
            ]);

            foreach($gradesActive as $g){
                $g->update([
                    'status' => 'inactive' ,
                ]);
            }
        }

        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

}
