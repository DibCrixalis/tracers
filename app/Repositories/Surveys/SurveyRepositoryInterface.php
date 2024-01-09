<?php

namespace App\Repositories\Surveys;

use Illuminate\Support\Collection;

interface SurveyRepositoryInterface
{
    public function getAll(): Collection;

    public function getById(string $id);

    public function create(array $data);

    public function update(string $id, array $data);

    public function delete(string $id);
}
