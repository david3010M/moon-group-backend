<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Image;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    /**
     * @OA\Get (
     *     path="/moon-group-backend/public/api/project",
     *     tags={"Project"},
     *     summary="Get all projects",
     *     description="Get all projects",
     *     @OA\Parameter(parameter="all", name="all", in="query", required=false, description="Get all projects", @OA\Schema(type="boolean")),
     *     @OA\Parameter(parameter="page", name="page", in="query", required=false, description="Page number", @OA\Schema(type="integer")),
     *     @OA\Parameter(parameter="per_page", name="per_page", in="query", required=false, description="Items per page", @OA\Schema(type="integer")),
     *     @OA\Parameter(parameter="sort", name="sort", in="query", required=false, description="Sort by column", @OA\Schema(type="string")),
     *     @OA\Parameter(parameter="direction", name="direction", in="query", required=false, description="Sort direction", @OA\Schema(type="string", enum={"asc", "desc"})),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/ProjectCollection")),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError"))
     * )
     */
    public function index(IndexProjectRequest $request)
    {
        return $this->getFilteredResults(
            Project::class,
            $request,
            Project::filters,
            Project::sorts,
            ProjectResource::class
        );
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());

        $images = $request->file('images') ?? [];
        foreach ($images as $image) {
            $filename = $project->id . '_' . str_replace(' ', '_', $image->getClientOriginalName());
            $path = $image->storeAs('project/' . $project->id, $filename, 'public');
            $routeImage = 'https://develop.garzasoft.com/moon-group-backend/storage/app/public/' . $path;
            Image::create([
                'route' => $routeImage,
                'project_id' => $project->id,
            ]);
        }

        $image = $request->file('headerImage');
        if (!$image) {
            $images = $project->images;
            $project->headerImage = $images[0]->route;
        } else {
            $filename = 'header_' . $project->id . '_' . str_replace(' ', '_', $image->getClientOriginalName());
            $path = $image->storeAs('project/' . $project->id, $filename, 'public');
            $routeImage = 'https://develop.garzasoft.com/moon-group-backend/storage/app/public/' . $path;
            $project->headerImage = $routeImage;
            $project->save();
        }

        return response()->json(['message' => 'Project created successfully'], 201);
    }

    /**
     * @OA\Get (
     *     path="/moon-group-backend/public/api/project/{id}",
     *     tags={"Project"},
     *     summary="Get project by id",
     *     description="Get project by id",
     *     @OA\Parameter(parameter="id", name="id", in="path", required=true, description="Project id", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/ProjectResource")),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=404, description="Project not found", @OA\JsonContent( @OA\Property(property="message", type="string", example="Projecto no encontrado")))
     * )
     */
    public function show(int $id)
    {
        $project = Project::find($id);
        if (!$project) return response()->json(['message' => 'Projecto no encontrado'], 404);
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, int $id)
    {
        //
    }

    public function destroy(int $id)
    {
        //
    }
}
