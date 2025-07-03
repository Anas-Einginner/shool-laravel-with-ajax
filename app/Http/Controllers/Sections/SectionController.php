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
        return view('dashboard.sections.index');
    }

  function getdata(Request $request)
{
    // ترتيب الشعب من الأعلى إلى الأسفل (id تنازلي)
    $sections = Section::query()
        ->orderByDesc('id')
        ->get();

    $activeSectionId = null;
    $nextInactiveSectionId = null;

    // الخطوة الأولى: تحديد أعلى شعبة active
    foreach ($sections as $section) {
        if ($section->status == 'active') {
            $activeSectionId = $section->id;
            break;
        }
    }

    // الخطوة الثانية: تحديد أول inactive أسفل الـ active الأعلى
    if ($activeSectionId) {
        $foundActive = false;
        foreach ($sections as $section) {
            if ($section->id == $activeSectionId) {
                $foundActive = true;
                continue;
            }
            if ($foundActive && $section->status == 'inactive') {
                $nextInactiveSectionId = $section->id;
                break;
            }
        }
    } else {
        // لو ما في أي شعبة active، خلي أول inactive يظهر عنده switch
        foreach ($sections as $section) {
            if ($section->status == 'inactive') {
                $nextInactiveSectionId = $section->id;
                break;
            }
        }
    }

    return DataTables::of($sections)
        ->addIndexColumn()
        ->addColumn('name', function ($qur) {
            return 'الشعبة ' . ' ' . $qur->name;
        })
        ->addColumn('action', function ($qur) use ($activeSectionId, $nextInactiveSectionId) {
            if ($activeSectionId && $qur->id == $activeSectionId) {
                // switch OFF لإيقاف الشعبة المفعّلة
                return '
                    <div data-id="' . $qur->id . '" class="form-check form-switch active-section-sw">
                        <input data-status="inactive" class="form-check-input" type="checkbox" role="switch" checked>
                    </div>';
            }

            if ($nextInactiveSectionId && $qur->id == $nextInactiveSectionId) {
                // switch ON لتفعيل الشعبة التالية
                return '
                    <div data-id="' . $qur->id . '" class="form-check form-switch active-section-sw">
                        <input data-status="active" class="form-check-input" type="checkbox" role="switch">
                    </div>';
            }

            return '-';
        })
        ->addColumn('status', function ($qur) {
            return $qur->status == 'active' ? 'مفعل' : 'غير مفعل';
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
            $lastSections = Section::query()->orderBy('name', 'desc')->limit($limit)->get();
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