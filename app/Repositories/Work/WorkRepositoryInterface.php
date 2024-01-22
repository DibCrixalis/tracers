<?php

namespace App\Repositories\Work;

interface WorkRepositoryInterface
{
    public function create(array $data);

    public function update(string $continueStudyId, array $data);

    public function findAll();

    public function findById(string $continueStudyId);

    public function findByUserId(string $continueStudyId);

    public function delete(string $userId);
}
