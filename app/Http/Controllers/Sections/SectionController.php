<?php

namespace App\Http\Controllers\Sections;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SectionController extends Controller
{

    function index()
    {
        $section = Section::query()->where('status', 'inactive')->get();
        // dd($section);
        return view('dashboard.sections.index');
    }

    function getdata(Request $request)
    {
        $grades = Section::query();
        return DataTables::of($grades)
            ->addIndexColumn()
            ->addColumn('name', function ($qur) {


                return 'الشعبة ' . ' ' . $qur->name;
            })
            ->addColumn('action', function ($qur) {
                $section = Section::query()->where('status', 'active')->orderBy('id', 'desc')->first();
                $sectiondisable = Section::query()->where('status', 'inactive')->first();
                if ($section->id == $qur->id) {
                    return ' <div data-id="' . $qur->id . '" class="form-check form-switch active-section-sw">
                                 <input data-status="inactive" class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                               </div>';
                }

                    if (@$sectiondisable->id == $qur->id) {
                        return ' <div data-status="active" data-id="' . $qur->id . '" class="form-check form-switch active-section-sw">
                                 <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                               </div>';
                    }



                return '-';
            })
            ->addColumn('status', function ($qur) {
                if ($qur->status == 'active') {
                    return 'مفعل';
                }
                return 'غير مفعل';
            })
            ->make(true);
    }

    function add(Request $request)
    {
        //dd($request->all());
       
        $newcount = (int)$request->count_section;
        $currentCount = Section::count();
        if ($newcount > $currentCount) {
            // dd($newcount  - $currentCount);
            for ($i = $currentCount + 1; $i <= $newcount; $i++) {
                Section::create([
                    'name' => $i,
                    'status' => 'active',
                ]);
            }


            $sectionInAcive = Section::query()->where('status', 'inactive')->get();
            foreach ($sectionInAcive as $s) {
                $s->update([
                    'status' => 'active',
                ]);
            }
        } elseif ($newcount < $currentCount) {
            $limit = $currentCount - $newcount;
            $lastSections = Section::query()->orderBy('id', 'desc')->limit($limit)->get();
            // dd($lastSections);

            foreach ($lastSections as $l) {
                $l->update([
                    'status' => 'inactive',
                ]);
            }
        } elseif ($newcount == $currentCount) {
            $sectionInAcive = Section::query()->where('status', 'inactive')->get();
            foreach ($sectionInAcive as $e) {
                $e->update([
                    'status' => 'active',
                ]);
            }
        }



        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }

    function changestatus(Request $request)
    {
        $section = Section::query()->findOrFail($request->id);

        if ($request->status == 'active') {
            $section->update([
                'status' => 'active'
            ]);
        } else {
            $section->update([
                'status' => 'inactive'
            ]);
        }



        return response()->json([
            'success' => 'تمت العملية بنجاح'
        ]);
    }
}
