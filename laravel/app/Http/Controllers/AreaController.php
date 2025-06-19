<?php

namespace App\Http\Controllers;
use App\Models\Subarea;
use App\Models\Area;

use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
$area = Area::with('subareas')->get();
        return view('ShowAreas', compact('area'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('AddAreas');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
$request->validate([
            'name' => 'required|string|max:255',
        ]);

        Area::create([
            'name' => $request->name,
        ]);

        return redirect()->route('areas.index')->with('success', 'تم إضافة المنطقة بنجاح.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Area $area)
    {
        return view('Editearea', compact('area'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        /**
     * حفظ تعديل المنطقة.
     */
    public function update(Request $request, Area $area)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $area->update([
            'name' => $request->name,
        ]);

        return redirect()->route('areas.index')->with('success', 'تم تعديل المنطقة بنجاح.');
    }

    /**
     * حذف منطقة وأفرعها.
     */
    public function destroy(Area $area)
    {
        // حذف الأفرع التابعة أولاً
        $area->subareas()->delete();

        // حذف المنطقة
        $area->delete();

        return redirect()->route('areas.index')->with('success', 'تم حذف المنطقة وأفرعها.');
    }
}
