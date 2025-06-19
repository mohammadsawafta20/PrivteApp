<?php

namespace App\Http\Controllers;
use App\Models\Subarea;
use App\Models\Area;
use Illuminate\Http\Request;

class SubareaController extends Controller
{// عرض قائمة الفروع (اختياري)
    public function index()
    {
        $subareas = Subarea::with('area')->get();
        return view('subareasshow', compact('subareas'));
    }

    // عرض نموذج إنشاء فرع جديد
    public function create(Request $request)
    {
        $area_id = $request->get('area_id');
        $areas = Area::all();
        return view('subareascreate', compact('areas', 'area_id'));
    }

    // تخزين فرع جديد
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'area_id'  => 'required|exists:areas,id',
            'delivery_price'=> 'nullable|numeric|min:0',
        ]);

        Subarea::create([
            'name'    => $request->name,
            'area_id' => $request->area_id,
            'delivery_price'   => $request->delivery_price,
        ]);

        return redirect()->route('areas.index')->with('success', '✅ تمت إضافة الفرع بنجاح.');
    }

    // عرض نموذج تعديل فرع
    public function edit($id)
    {
        $subarea = Subarea::findOrFail($id);
        $areas = Area::all();
        return view('editesub', compact('subarea', 'areas'));
    }

    // تحديث بيانات الفرع
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'area_id'  => 'required|exists:areas,id',
            'delivery_price'    => 'nullable|numeric|min:0',
        ]);

        $subarea = Subarea::findOrFail($id);
        $subarea->update([
            'name'    => $request->name,
            'area_id' => $request->area_id,
            'delivery_price'   => $request->delivery_price,
        ]);

        return redirect()->route('areas.index')->with('success', '✅ تم تعديل الفرع بنجاح.');
    }

    // حذف فرع
    public function destroy($id)
    {
        $subarea = Subarea::findOrFail($id);
        $subarea->delete();

        return redirect()->route('areas.index')->with('success', '🗑️ تم حذف الفرع.');
    }
}
