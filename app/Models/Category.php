<?php

namespace App\Models;

use App\Models\Base\Category as BaseCategory;
use Ramsey\Uuid\Nonstandard\Uuid;

class Category extends BaseCategory
{
	protected $fillable = [
		'name',
		'description',
		'is_active',
		'parent_id'
	];

	protected static function booted()
	{
		static::creating(function ($category) {
			$category->uuid = (string) Uuid::uuid6();
		});
	}
}
