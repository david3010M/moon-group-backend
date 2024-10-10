<?php

namespace App\Http\Controllers;

use App\Models\GroupMenu;
use App\Models\OptionMenu;
use App\Http\Requests\StoreOptionMenuRequest;
use App\Http\Requests\UpdateOptionMenuRequest;
use Illuminate\Http\Request;

class OptionMenuController extends Controller
{
    public function index()
    {
        return response()->json(OptionMenu::all());
    }

    public function store(Request $request)
    {
        //
    }

    public function show(int $id)
    {
        //
    }

    public function update(Request $request, int $id)
    {
        //
    }

    public function destroy(int $id)
    {
        //
    }
}
