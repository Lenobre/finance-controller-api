<?php

namespace App\Models;

use App\Models\Base\Account as BaseAccount;
use Ramsey\Uuid\Nonstandard\Uuid;

class Account extends BaseAccount
{
	protected $fillable = [
		'uuid',
		'name',
		'description',
		'balance',
		'is_active'
	];

	protected static function booted()
	{
		static::creating(function ($category) {
			$category->uuid = (string) Uuid::uuid6();
		});
	}
}
