<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request, CategoryService $service)
    {
        try {
            $payload = $request->all();

            $categories = $service->index($payload['name'] ?? null, $payload['description'] ?? null, $payload['parent_id'] ?? null);

            return response()->json($categories, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function store(StoreCategoryRequest $request, CategoryService $service)
    {
        try {
            $payload = $request->validated();

            $service->create($payload['name'], $payload['description'] ?? null, $payload['parent_id'] ?? null);

            return response()->json([
                'message' => 'Category created successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function show(String $uuid, CategoryService $service)
    {
        try {
            $category = $service->show($uuid);

            return response()->json($category, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function update(String $uuid, UpdateCategoryRequest $request, CategoryService $service)
    {
        try {
            $payload = $request->validated();

            $service->update($uuid, $payload['name'], $payload['description'] ?? null, $payload['parent_id'] ?? null);

            return response()->json([
                'message' => 'Category updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    public function destroy(String $uuid, CategoryService $service)
    {
        try {
            $message = $service->destroy($uuid);

            return response()->json([
                'message' => $message,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }
}
