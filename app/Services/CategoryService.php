<?php

namespace App\Services;

use App\Models\Category;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

final class CategoryService
{
  public function index(string|null $name = null, string|null $description = null, int|null $parent_id = null): LengthAwarePaginator
  {
    $query = Category::query()->select("uuid", "name", "description", "parent_id", "is_active");

    if ($name)
      $query->where('name', 'like', '%' . $name . '%');

    if ($parent_id)
      $query->where('parent_id', $parent_id);

    return $query->paginate();
  }

  public function create(string $name, string|null $description = null, int|null $parent_id = null): Category
  {
    $category = Category::query()->create([
      'name' => $name,
      'description' => $description,
      'parent_id' => $parent_id,
    ]);

    if (!$category)
      throw new Exception("Error creating category");

    return $category;
  }

  public function show(String $uuid): Category
  {
    $category = Category::query()->select("name", "description", "parent_id", "is_active")->where('uuid', $uuid)->first();

    if (!$category)
      throw new Exception("Category not found");

    return $category;
  }

  public function update(String $uuid, string $name, string|null $description = null, int|null $parent_id = null)
  {
    $category = Category::query()
      ->where('uuid', $uuid)
      ->update([
        'name' => $name,
        'description' => $description,
        'parent_id' => $parent_id,
      ]);

    if (!$category)
      throw new Exception("Error while updating category");
  }

  public function destroy(String $uuid): string
  {
    $category = Category::query()->select("id", "is_active")->where('uuid', $uuid)->first();

    if (!$category)
      throw new Exception("Category not found");

    if ($category->is_active) {
      $category->is_active = false;
      $category->save();

      return "Category deactivated successfully";
    }

    $category->delete();
    return "Category deleted successfully";
  }
}
