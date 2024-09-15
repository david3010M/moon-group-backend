<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get (
     *     path="/moon-group-backend/public/api/user",
     *     tags={"User"},
     *     summary="Get list of users",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(name="names", in="query", description="Filter by names", required=false, @OA\Schema(type="string") ),
     *     @OA\Parameter(name="typeuser_id", in="query", description="Filter by type user id", required=false, @OA\Schema(type="integer") ),
     *     @OA\Parameter(name="page", in="query", description="Page number", required=false, @OA\Schema(type="integer") ),
     *     @OA\Parameter(name="per_page", in="query", description="Items per page", required=false, @OA\Schema(type="integer") ),
     *     @OA\Parameter(name="all", in="query", description="Get all items", required=false, @OA\Schema(type="boolean") ),
     *     @OA\Response(response=200, description="List of users", @OA\JsonContent( type="array", @OA\Items(ref="#/components/schemas/User") ) ),
     *     @OA\Response(response=401, description="Unauthorized", @OA\JsonContent( ref="#/components/schemas/Unauthenticated" ) ),
     * )
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
