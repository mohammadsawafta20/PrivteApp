<?php

namespace App\Http\Controllers;
use App\Models\Modules\Vendors\Models\Vendors;
use Illuminate\Http\Request;

class EditVendorController extends Controller
{
    public function edit($id)
    {
        $vendor = Vendors::findOrFail($id);
        return view('editvendor', compact('vendor'));
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendors::findOrFail($id);

        $request->validate([
            'store_request_id' => 'nullable|integer',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'user_id' => 'required|integer',
            'store_name' => 'required|string|max:255',
            'location' => 'nullable|string',
            'is_approved' => 'required|boolean',
            'payment_method' => 'nullable|string',
        ]);

        $vendor->update($request->all());

        return redirect()->route('Addnewvender')->with('success', 'تم تعديل المتجر بنجاح');
    }

    public function destroy($id)
    {
        Vendors::destroy($id);
        return redirect()->route('Addnewvender')->with('success', 'تم حذف المتجر بنجاح');
    }
}
