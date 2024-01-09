<?php

namespace App\Repositories\Surveys;

use App\Models\Survey;
use Illuminate\Support\Collection;

class EloquentSurveyRepository implements SurveyRepositoryInterface
{
    public function getAll(): Collection
    {
        return Survey::all();
    }

    public function getById(string $id)
    {
        return Survey::findOrFail($id);
    }

    public function create(array $data)
    {
        return Survey::create($data);
    }

    public function update(string $id, array $data)
    {
        $survey = Survey::findOrFail($id);
        $survey->update($data);

        return $survey;
    }

    public function delete(string $id)
    {
        $survey = Survey::findOrFail($id);
        $survey->delete();
    }
}
