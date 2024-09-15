<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return Contact::all();
    }

    public function store(StoreContactRequest $request)
    {
        Contact::create($request->validated());
        return response()->json(['message' => 'Message sent successfully']);
    }

    public function show(int $id)
    {
        //
    }

    public function update(UpdateContactRequest $request, int $id)
    {
        //
    }

    public function destroy(int $id)
    {
        //
    }
}
