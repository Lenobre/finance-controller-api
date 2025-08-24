<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $id
 * @property string $uuid
 * @property string $name
 * @property string|null $description
 * @property int|null $parent_id
 * @property bool $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property \App\Models\Category|null $category
 * @property Collection|\App\Models\Category[] $categories
 *
 * @package App\Models\Base
 */
class Category extends Model
{
	protected $table = 'categories';

	protected $casts = [
		'parent_id' => 'int',
		'is_active' => 'bool'
	];

	public function category()
	{
		return $this->belongsTo(\App\Models\Category::class, 'parent_id');
	}

	public function categories()
	{
		return $this->hasMany(\App\Models\Category::class, 'parent_id');
	}
}
