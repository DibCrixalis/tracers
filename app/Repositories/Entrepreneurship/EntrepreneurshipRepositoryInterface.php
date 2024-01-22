<?php

namespace App\Repositories\Entrepreneurship;

interface EntrepreneurshipRepositoryInterface
{
    public function create(array $data);

    public function update(string $continueStudyId, array $data);

    public function findAll();

    public function findById(string $continueStudyId);

    public function findByUserId(string $continueStudyId);

    public function delete(string $userId);
}
