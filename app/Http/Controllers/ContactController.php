<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;

class ContactController extends Controller
{
    /**
     * @OA\Get (
     *     path="/moon-group-backend/public/api/contact",
     *     tags={"Contact"},
     *     summary="Get all contact messages",
     *     description="Get all contact messages",
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Contact"))),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError"))
     * )
     */
    public function index()
    {
        return Contact::all();
    }

    /**
     * @OA\Post (
     *     path="/moon-group-backend/public/api/contact",
     *     tags={"Contact"},
     *     summary="Send a message",
     *     description="Send a message",
     *     @OA\RequestBody( required=true, description="Pass contact details", @OA\JsonContent(ref="#/components/schemas/StoreContactRequest")),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(type="object", @OA\Property(property="message", type="string", example="Message sent successfully"))),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError"))
     * )
     */
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
