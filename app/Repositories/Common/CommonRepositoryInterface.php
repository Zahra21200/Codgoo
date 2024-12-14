<?php

namespace App\Repositories\Common;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Database\Eloquent\Model;

interface CommonRepositoryInterface
{
    public function index(Request $request);
    public function store(Request $request);
    public function update(int $id, array $request);
    public function delete(int $id): bool;
    public function show(int $id, array $relations = []);
    // public function respond($data, bool $success = true);
}
