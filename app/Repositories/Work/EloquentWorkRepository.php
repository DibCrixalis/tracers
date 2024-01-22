<?php

namespace App\Repositories\Work;

use App\Models\User;
use App\Models\Work;
use Illuminate\Support\Facades\Auth;

class EloquentWorkRepository implements WorkRepositoryInterface
{
    public function create(array $data)
    {
        return Work::create($data);
    }

    public function update(string $workId, array $data)
    {
        $work = $this->findById($workId);

        if ($work) {
            $work->update($data);
            return $work->fresh();
        }

        return null;
    }


    public function findAll()
    {
        return Work::all();
    }

    public function findById(string $workId)
    {
        return Work::find($workId);
    }

    public function findByUserId(string $userId)
    {
        return Work::where('user_id', $userId)->get();
    }

    public function delete(string $workId)
    {
        $work = $this->findById($workId);

        if ($work) {
            $work->delete();
            return true;
        }

        return false;
    }
}
