<?php

namespace App\Http\Controllers;

use App\Http\Requests\IndexProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Image;
use App\Models\Project;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Imagick;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

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

    /**
     * @OA\Post (
     *     path="/moon-group-backend/public/api/project",
     *     tags={"Project"},
     *     summary="Create a project",
     *     description="Create a project",
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(@OA\MediaType(mediaType="multipart/form-data", @OA\Schema(ref="#/components/schemas/StoreProjectRequest"))),
     *     @OA\Response(response=201, description="Project created successfully"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=422, description="Validation error", @OA\JsonContent(ref="#/components/schemas/ValidationError"))
     * )
     */
    public function store(StoreProjectRequest $request)
    {
        $data= $request->validated();
        $data = [
            'titleEn' => $data['titleEn'] ?? " ",
            'introductionEn' => $data['introductionEn'] ?? " ",
            'descriptionEn' => $data['descriptionEn'] ?? " ",
            ...$data
        ];

        $project = Project::create($data);

        // === IMÁGENES DEL GALERÍA ===
        $images = $request->file('images') ?? [];
        foreach ($images as $image) {
            try {
                $imagick = new \Imagick($image->getPathname());

                // Normalizar orientación (equivalente a autoOrientImage en entornos antiguos)
                $orientation = $imagick->getImageOrientation();
                switch ($orientation) {
                    case \Imagick::ORIENTATION_BOTTOMRIGHT: // 180°
                        $imagick->rotateImage(new \ImagickPixel('none'), 180);
                        break;
                    case \Imagick::ORIENTATION_RIGHTTOP: // 90° CW
                        $imagick->rotateImage(new \ImagickPixel('none'), 90);
                        break;
                    case \Imagick::ORIENTATION_LEFTBOTTOM: // 90° CCW
                        $imagick->rotateImage(new \ImagickPixel('none'), -90);
                        break;
                }
                $imagick->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
                $imagick->stripImage();

                // Convertir a WebP
                $imagick->setImageFormat('webp');
                $imagick->setImageCompressionQuality(60);

                // Guardar en tmp y luego en storage
                $tempFile = tempnam(sys_get_temp_dir(), 'webp_');
                $imagick->writeImage($tempFile);
                $imagick->clear();
                $imagick->destroy();

                $basename = str_replace(' ', '_', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
                $filename = $project->id . '_' . $basename . '.webp';

                $path = \Storage::disk('public')->putFileAs('project/' . $project->id, new \Illuminate\Http\File($tempFile), $filename);
                $routeImage = \Storage::disk('public')->url($path);

                Image::create([
                    'route' => $routeImage,
                    'project_id' => $project->id,
                ]);

                @unlink($tempFile);
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Error al procesar el archivo: ' . $e->getMessage()], 500);
            }
        }

        // === HEADER IMAGE ===
        $headerFile = $request->file('headerImage');
        if (!$headerFile) {
            $images = $project->images;
            if ($images->isNotEmpty()) {
                $project->headerImage = $images->first()->route;
            }
        } else {
            try {
                $imagick = new \Imagick($headerFile->getPathname());

                $orientation = $imagick->getImageOrientation();
                switch ($orientation) {
                    case \Imagick::ORIENTATION_BOTTOMRIGHT:
                        $imagick->rotateImage(new \ImagickPixel('none'), 180);
                        break;
                    case \Imagick::ORIENTATION_RIGHTTOP:
                        $imagick->rotateImage(new \ImagickPixel('none'), 90);
                        break;
                    case \Imagick::ORIENTATION_LEFTBOTTOM:
                        $imagick->rotateImage(new \ImagickPixel('none'), -90);
                        break;
                }
                $imagick->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
                $imagick->stripImage();

                $imagick->setImageFormat('webp');
                $imagick->setImageCompressionQuality(60);

                $tempFile = tempnam(sys_get_temp_dir(), 'webp_');
                $imagick->writeImage($tempFile);
                $imagick->clear();
                $imagick->destroy();

                $basename = str_replace(' ', '_', pathinfo($headerFile->getClientOriginalName(), PATHINFO_FILENAME));
                $filename = $project->id . '_' . $basename . '.webp';

                $path = \Storage::disk('public')->putFileAs('project/' . $project->id, new \Illuminate\Http\File($tempFile), $filename);
                $project->headerImage = \Storage::disk('public')->url($path);

                @unlink($tempFile);
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Error al procesar el headerImage: ' . $e->getMessage()], 500);
            }
        }

        $project->save();

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
        return response()->json(new ProjectResource($project));
    }

    /**
     * @OA\Post (
     *     path="/moon-group-backend/public/api/project/update/{id}",
     *     tags={"Project"},
     *     summary="Update a project",
     *     description="Update a project",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(parameter="id", name="id", in="path", required=true, description="Project id", @OA\Schema(type="integer")),
     *     @OA\RequestBody(@OA\MediaType(mediaType="multipart/form-data", @OA\Schema(ref="#/components/schemas/UpdateProjectRequest"))),
     *     @OA\Response(response=200, description="Project updated successfully"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=404, description="Project not found", @OA\JsonContent( @OA\Property(property="message", type="string", example="Projecto no encontrado")))
     * )
     */
    public function update(UpdateProjectRequest $request, int $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(['message' => 'Proyecto no encontrado'], 404);
        }

        $data = [
            'title' => $request->input('title', $project->title),
            'titleEn' => $request->titleEn ?? " ",
            'date' => $request->input('date', $project->date),
            'introduction' => $request->input('introduction', $project->introduction),
            'introductionEn' => $request->introductionEn ?? " ",
            'description' => $request->input('description', $project->description),
            'descriptionEn' => $request->descriptionEn ?? " ",
        ];
        $project->update($data);

        // === NUEVAS IMÁGENES DE GALERÍA (si vienen) ===
        $images = $request->file('images') ?? [];
        foreach ($images as $image) {
            try {
                $imagick = new \Imagick($image->getPathname());

                // Normalizar orientación (compat con entornos sin autoOrientImage)
                $orientation = $imagick->getImageOrientation();
                switch ($orientation) {
                    case \Imagick::ORIENTATION_BOTTOMRIGHT: // 180°
                        $imagick->rotateImage(new \ImagickPixel('none'), 180);
                        break;
                    case \Imagick::ORIENTATION_RIGHTTOP: // 90° CW
                        $imagick->rotateImage(new \ImagickPixel('none'), 90);
                        break;
                    case \Imagick::ORIENTATION_LEFTBOTTOM: // 90° CCW
                        $imagick->rotateImage(new \ImagickPixel('none'), -90);
                        break;
                }
                $imagick->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
                $imagick->stripImage();

                // Convertir a WebP
                $imagick->setImageFormat('webp');
                $imagick->setImageCompressionQuality(60);

                // Guardar en tmp y luego en storage público
                $tempFile = tempnam(sys_get_temp_dir(), 'webp_');
                $imagick->writeImage($tempFile);
                $imagick->clear();
                $imagick->destroy();

                $basename = str_replace(' ', '_', pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME));
                $filename = $project->id . '_' . $basename . '.webp';

                $path = \Storage::disk('public')->putFileAs('project/' . $project->id, new \Illuminate\Http\File($tempFile), $filename);
                $routeImage = \Storage::disk('public')->url($path); // <- sin concatenar dominio

                Image::create([
                    'route' => $routeImage,
                    'project_id' => $project->id,
                ]);

                @unlink($tempFile);
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Error al procesar el archivo: ' . $e->getMessage()], 500);
            }
        }

        // === HEADER IMAGE ===
        $headerFile = $request->file('headerImage');
        if (!$headerFile && empty($project->headerImage)) {
            $gallery = $project->images()->orderBy('id')->get();
            if ($gallery->isNotEmpty()) {
                $project->headerImage = $gallery->first()->route; // ya es URL completa (Storage::url)
            }
        } elseif ($headerFile) {
            try {
                $imagick = new \Imagick($headerFile->getPathname());

                $orientation = $imagick->getImageOrientation();
                switch ($orientation) {
                    case \Imagick::ORIENTATION_BOTTOMRIGHT:
                        $imagick->rotateImage(new \ImagickPixel('none'), 180);
                        break;
                    case \Imagick::ORIENTATION_RIGHTTOP:
                        $imagick->rotateImage(new \ImagickPixel('none'), 90);
                        break;
                    case \Imagick::ORIENTATION_LEFTBOTTOM:
                        $imagick->rotateImage(new \ImagickPixel('none'), -90);
                        break;
                }
                $imagick->setImageOrientation(\Imagick::ORIENTATION_TOPLEFT);
                $imagick->stripImage();

                $imagick->setImageFormat('webp');
                $imagick->setImageCompressionQuality(60);

                $tempFile = tempnam(sys_get_temp_dir(), 'webp_');
                $imagick->writeImage($tempFile);
                $imagick->clear();
                $imagick->destroy();

                $basename = str_replace(' ', '_', pathinfo($headerFile->getClientOriginalName(), PATHINFO_FILENAME));
                $filename = $project->id . '_' . $basename . '.webp';

                $path = \Storage::disk('public')->putFileAs('project/' . $project->id, new \Illuminate\Http\File($tempFile), $filename);
                $project->headerImage = \Storage::disk('public')->url($path); // <- sin concatenar dominio

                @unlink($tempFile);
            } catch (\Throwable $e) {
                return response()->json(['error' => 'Error al procesar el headerImage: ' . $e->getMessage()], 500);
            }
        }

        $project->save();

        return response()->json(['message' => 'Project updated successfully']);
    }


    /**
     * @OA\Delete (
     *     path="/moon-group-backend/public/api/image/{id}",
     *     tags={"Image"},
     *     summary="Delete an image",
     *     description="Delete an image",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(parameter="id", name="id", in="path", required=true, description="Image id", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Image deleted successfully"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=404, description="Image not found", @OA\JsonContent( @OA\Property(property="message", type="string", example="Imagen no encontrada")))
     * )
     */
    public function deleteImage(int $id)
    {
        $image = Image::find($id);
        if (!$image) return response()->json(['message' => 'Imagen no encontrada'], 404);
        $image->delete();
        return response()->json(['message' => 'Imagen eliminada correctamente']);
    }

    /**
     * @OA\Delete (
     *     path="/moon-group-backend/public/api/project/{id}",
     *     tags={"Project"},
     *     summary="Delete a project",
     *     description="Delete a project",
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(parameter="id", name="id", in="path", required=true, description="Project id", @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Project deleted successfully"),
     *     @OA\Response(response=401, description="Unauthenticated", @OA\JsonContent(ref="#/components/schemas/Unauthenticated")),
     *     @OA\Response(response=404, description="Project not found", @OA\JsonContent( @OA\Property(property="message", type="string", example="Projecto no encontrado")))
     * )
     */
    public function destroy(int $id)
    {
        $project = Project::find($id);
        if (!$project) return response()->json(['message' => 'Projecto no encontrado'], 404);
        $project->delete();
        return response()->json(['message' => 'Projecto eliminado correctamente']);
    }
}
