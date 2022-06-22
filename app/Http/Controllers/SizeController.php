<?php

namespace App\Http\Controllers;

use App\Models\Size;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        return Size::simplePaginate($request->query('perpage', 30));
    }

    public function store(Request $request)
    {
        return Size::create($request->all());
    }

    public function show(Size $size)
    {
        return $size;
    }

    public function update(Request $request, Size $size)
    {
        $size->update($request->all());
        return $size;
    }

    public function destroy(Size $size)
    {
        $size->delete();
        return response()->json(['message'=> 'Xóa thành công']);
    }
}
