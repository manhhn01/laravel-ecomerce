<?php

namespace App\Http\Controllers;

use App\Models\Color;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index(Request $request)
    {
        return Color::simplePaginate($request->query('perpage', 30));
    }

    public function store(Request $request)
    {
        return Color::create($request->all());
    }

    public function show(Color $color)
    {
        return $color;
    }

    public function update(Request $request, Color $color)
    {
        $color->update($request->all());
        return $color;
    }

    public function destroy(Color $color)
    {
        $color->delete();
        return response()->json(['message' => 'Xóa thành công']);
    }
}
