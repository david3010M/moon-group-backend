<?php

namespace App\Http\Controllers;

use App\Models\GroupMenu;
use App\Http\Requests\StoreGroupMenuRequest;
use App\Http\Requests\UpdateGroupMenuRequest;
use Illuminate\Http\Request;

class GroupMenuController extends Controller
{
    public function index()
    {
        return GroupMenu::with('optionMenus')->get();
    }

    public function store(Request $request)
    {

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
