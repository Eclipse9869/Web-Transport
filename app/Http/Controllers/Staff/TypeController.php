<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    //
    public function index()
    {
        $type = Type::orderBy('created_at', 'desc')->get();
        return view('staff.type.data-type', compact('type'));
    }
    // Add
    public function store(Request $request)
    {
        $type = Type::create([
            'name' => $request->name,
        ]);
        return response()->json($type);
    }
    public function show($id)
    {
        $type = Type::findOrFail($id);
        return response()->json($type);
    }
    public function update(Request $request, $id)
    {
        $type = Type::findOrFail($id);
        $type->update($request->all());
        return response()->json($type);
    }
    public function destroy($id)
    {
        $type = Type::findOrFail($id);
        $type->delete();
        return response()->json(['success' => 'Type deleted successfully']);
    }
}
