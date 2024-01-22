<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Repositories\Work\WorkRepositoryInterface;

class WorkController extends Controller
{
    private $workRepository;

    /**
     * Create a new AuthController instance.
     *
     * @param WorkRepositoryInterface $workRepository
     * @return void
     */

    public function __construct(WorkRepositoryInterface $workRepository)
    {
        $this->workRepository = $workRepository;
    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $request->validate([
            'waiting_for_job' => 'required|string',
            'location' => 'required|string',
            'workplace_name' => 'required|string',
            'position' => 'required|string',
            'num_of_employees' => 'required|string',
            'company_type' => 'required|string',
            'employment_duration' => 'required|numeric',
            'change_job_reason' => 'required|string',
            'working_hours' => 'required|numeric',
            'income_amount' => 'required|numeric',
        ]);

        try {
            $work = $this->workRepository->create([
                'user_id' => $user->id,
                'waiting_for_job' => $request->waiting_for_job,
                'location' =>  $request->location,
                'workplace_name' =>  $request->workplace_name,
                'position' =>  $request->position,
                'num_of_employees' =>  $request->num_of_employees,
                'company_type' =>  $request->company_type,
                'employment_duration' => $request->employment_duration,
                'change_job_reason' =>  $request->change_job_reason,
                'working_hours' =>  $request->working_hours,
                'income_amount' =>  $request->income_amount,
            ]);

            return response()->json(['message' => 'Work successfully created', 'Work' => $work], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create Work', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $workId)
    {
        $request->validate([
            'waiting_for_job' => 'required|string',
            'location' => 'required|string',
            'workplace_name' => 'required|string',
            'position' => 'required|string',
            'num_of_employees' => 'required|string',
            'company_type' => 'required|string',
            'employment_duration' => 'required|numeric',
            'change_job_reason' => 'required|string',
            'working_hours' => 'required|numeric',
            'income_amount' => 'required|numeric',
        ]);

        $work = $this->workRepository->findById($workId);

        if (!$work) {
            return response()->json(['message' => 'Work not found'], 404);
        }

        try {
            $updatedwork = $this->workRepository->update($workId, [
                'waiting_for_job' => $request->waiting_for_job,
                'location' =>  $request->location,
                'workplace_name' =>  $request->workplace_name,
                'position' =>  $request->position,
                'num_of_employees' =>  $request->num_of_employees,
                'company_type' =>  $request->company_type,
                'employment_duration' => $request->employment_duration,
                'change_job_reason' =>  $request->change_job_reason,
                'working_hours' =>  $request->working_hours,
                'income_amount' =>  $request->income_amount,
            ]);

            return response()->json(['message' => 'Work successfully updated', 'work' => $updatedwork], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update Work', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $workId)
    {
        $work = $this->workRepository->findById($workId);

        if (!$work) {
            return response()->json(['message' => 'Work not found'], 404);
        }

        return response()->json(['Work' => $work], 200);
    }

    public function index()
    {
        $work = $this->workRepository->findAll();

        return response()->json(['Work' => $work], 200);
    }

    public function findByUserId($user_id)
    {
        try {
            $work = $this->workRepository->findByUserId($user_id);

            return response()->json(['Work' => $work], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve Work', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $workId)
    {
        $work = $this->workRepository->findById($workId);

        if (!$work) {
            return response()->json(['message' => 'Work not found'], 404);
        }

        try {
            $this->workRepository->delete($workId);

            return response()->json(['message' => 'Work successfully deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete Work', 'error' => $e->getMessage()], 500);
        }
    }
}
