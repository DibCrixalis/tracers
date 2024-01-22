<?php

namespace App\Repositories\Entrepreneurship;

use App\Models\Entrepreneurship;
use Illuminate\Support\Facades\Auth;

class EloquentEntrepreneurshipRepository implements EntrepreneurshipRepositoryInterface
{
    public function create(array $data)
    {
        return Entrepreneurship::create($data);
    }

    public function update(string $entrepreneurshipId, array $data)
    {
        $entrepreneurship = $this->findById($entrepreneurshipId);

        if ($entrepreneurship) {
            $entrepreneurship->update($data);
            return $entrepreneurship->fresh();
        }

        return null;
    }


    public function findAll()
    {
        return Entrepreneurship::all();
    }

    public function findById(string $entrepreneurshipId)
    {
        return Entrepreneurship::find($entrepreneurshipId);
    }

    public function findByUserId(string $userId)
    {
        return Entrepreneurship::where('user_id', $userId)->get();
    }

    public function delete(string $entrepreneurshipId)
    {
        $entrepreneurship = $this->findById($entrepreneurshipId);

        if ($entrepreneurship) {
            $entrepreneurship->delete();
            return true;
        }

        return false;
    }
}
