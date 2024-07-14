<?php

namespace Modules\Backend\Http\Controller;

use App\Http\Controllers\Controller;
use App\Models\material;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Modules\Backend\Http\Data\DataType;

class MaterialController extends Controller
{
    public function index()
    {
        $title = "materials";
        $types = config('backendconfig.material');
        $colors = config('backendconfig.color');
        $materials = material::where('status', DataType::NORMAL_DATA_TYPE)->get();
        return view('backend::material.index', [
            'title' => $title,
            'materials' => $materials,
            'types' => $types,
            'colors' => $colors
        ]);
    }

    public function Create(Request $request)
    {
        // dd($request);
        $material = new material();
        $material->name = $request->input('name');
        $material->color = $request->input('color');
        $material->type = $request->input('type');
        $material->description = $request->input('description');
        $material->status = DataType::NORMAL_DATA_TYPE;
        $material->save();

        return redirect()->route('admin-material-index')->with('success', 'material updated successfully');
    }

    public function edit($id)
    {
        $material = material::find($id);
        return response()->json($material);
    }

    public function update(Request $request, $id)
    {
        $material = material::find($id);
        $material->name = $request->input('name');
        $material->color = $request->input('color');
        $material->type = $request->input('type');
        $material->description = $request->input('description');
        $material->save();

        return redirect()->route('admin-material-index')->with('success', 'material updated successfully');
    }

    public function deleted($id)
    {
        $material = material::find($id);
        $material->status = DataType::DELETED_DATA_TYPE;
        $material->save();

        return response()->json(['success' => 'Material updated successfully.']);
    }
}
