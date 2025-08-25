<?php

namespace App\Services;

use App\Models\Account;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;

final class AccountService
{
  public function index(string|null $name = null, float $balance = 0): LengthAwarePaginator
  {
    $query = Account::query()->select("uuid", "name", "description", "balance", "is_active");

    if ($name)
      $query->where('name', 'like', '%' . $name . '%');

    if ($balance)
      $query->where('balance', '>=', $balance);

    return $query->paginate();
  }

  public function create(string $name, string|null $description = null, float $balance = 0): Account
  {
    $account = Account::query()->create([
      'name' => $name,
      'description' => $description,
      'balance' => $balance ?? 0,
    ]);

    if (!$account)
      throw new Exception("Error creating account");

    return $account;
  }

  public function show(String $uuid): Account
  {
    $account = Account::query()->select("name", "description", "balance", "is_active")->where('uuid', $uuid)->first();

    if (!$account)
      throw new Exception("Account not found");

    return $account;
  }

  public function update(String $uuid, string $name, string|null $description = null, float $balance = 0)
  {
    $account = Account::query()
      ->where('uuid', $uuid)
      ->update([
        'name' => $name,
        'description' => $description,
        'balance' => $balance,
      ]);

    if (!$account)
      throw new Exception("Error while updating account");
  }

  public function destroy(String $uuid): string
  {
    $account = Account::query()->select("id", "is_active")->where('uuid', $uuid)->first();

    if (!$account)
      throw new Exception("Account not found");

    if ($account->is_active) {
      $account->is_active = false;
      $account->save();

      return "Account deactivated successfully";
    }

    $account->delete();
    return "Account deleted successfully";
  }
}
