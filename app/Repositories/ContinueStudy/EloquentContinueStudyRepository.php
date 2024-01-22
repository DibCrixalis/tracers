<?php

namespace App\Repositories\ContinueStudy;

use App\Models\ContinueStudy;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EloquentContinueStudyRepository implements ContinueStudyRepositoryInterface
{
    public function create(array $data)
    {
        return ContinueStudy::create($data);
    }

    public function update(string $continueStudyId, array $data)
    {
        $continueStudy = $this->findById($continueStudyId);

        if ($continueStudy) {
            $continueStudy->update($data);
            return $continueStudy->fresh();
        }

        return null;
    }


    public function findAll()
    {
        return ContinueStudy::all();
    }

    public function findById(string $continueStudyId)
    {
        return ContinueStudy::find($continueStudyId);
    }

    public function findByUserId(string $userId)
    {
        return ContinueStudy::where('user_id', $userId)->get();
    }

    public function delete(string $continueStudyId)
    {
        $continueStudy = $this->findById($continueStudyId);

        if ($continueStudy) {
            $continueStudy->delete();
            return true;
        }

        return false;
    }
}