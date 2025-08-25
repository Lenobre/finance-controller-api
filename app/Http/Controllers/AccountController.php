<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, AccountService $service)
    {
        try {
            $payload = $request->all();

            $accounts = $service->index($payload['name'] ?? null, $payload['balance'] ?? 0);

            return response()->json($accounts, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAccountRequest $request, AccountService $service)
    {
        try {
            $payload = $request->validated();

            $service->create($payload['name'] ?? null, $payload['description'] ?? null, $payload['balance'] ?? 0);

            return response()->json([
                'message' => 'Account created successfully'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $uuid, AccountService $service)
    {
        try {
            $account = $service->show($uuid);

            return response()->json($account, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $uuid, UpdateAccountRequest $request, AccountService $service)
    {
        try {
            $payload = $request->validated();

            $service->update($uuid, $payload['name'], $payload['description'] ?? null, $payload['balance'] ?? 0);

            return response()->json([
                'message' => 'Account updated successfully',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $uuid, AccountService $service)
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
