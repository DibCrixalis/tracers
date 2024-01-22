<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ContinueStudy\ContinueStudyRepositoryInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;



class ContinueStudyController extends Controller
{
    private $continueStudyRepository;

    /**
     * Create a new AuthController instance.
     *
     * @param ContinueStudyRepositoryInterface $continueStudyRepository
     * @return void
     */
    public function __construct(ContinueStudyRepositoryInterface $continueStudyRepository)
    {
        $this->continueStudyRepository = $continueStudyRepository;
    }

    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $request->validate([
            'continuing_education_level' => 'required|string',
            'university_name' => 'required|string',
            'study_program' => 'required|string',
            'alignment_of_study_program' => 'required|string',
            'reason_for_continuing' => 'required|string',
        ]);

        try {
            $continueStudy = $this->continueStudyRepository->create([
                'continuing_education_level' => $request->continuing_education_level,
                'university_name' => $request->university_name,
                'study_program' => $request->study_program,
                'user_id' => $user->id,
                'alignment_of_study_program' => $request->alignment_of_study_program,
                'reason_for_continuing' => $request->reason_for_continuing,
            ]);

            return response()->json(['message' => 'Continue Study successfully created', 'continueStudy' => $continueStudy], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create continueStudy', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $continueStudyId)
    {
        $request->validate([
            'continuing_education_level' => 'required|string',
            'university_name' => 'required|string',
            'study_program' => 'required|string',
            'alignment_of_study_program' => 'required|string',
            'reason_for_continuing' => 'required|string',
        ]);

        $continueStudy = $this->continueStudyRepository->findById($continueStudyId);

        if (!$continueStudy) {
            return response()->json(['message' => 'Continue Study not found'], 404);
        }

        try {
            $updatedContinueStudy = $this->continueStudyRepository->update($continueStudyId, [
                'continuing_education_level' => $request->continuing_education_level,
                'university_name' => $request->university_name,
                'study_program' => $request->study_program,
                'alignment_of_study_program' => $request->alignment_of_study_program,
                'reason_for_continuing' => $request->reason_for_continuing,
            ]);

            return response()->json(['message' => 'Continue Study successfully updated', 'continueStudy' => $updatedContinueStudy], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update continueStudy', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $continueStudyId)
    {
        $continueStudy = $this->continueStudyRepository->findById($continueStudyId);

        if (!$continueStudy) {
            return response()->json(['message' => 'Continue Study not found'], 404);
        }

        return response()->json(['continueStudy' => $continueStudy], 200);
    }

    public function index()
    {
        $continueStudies = $this->continueStudyRepository->findAll();

        return response()->json(['continueStudies' => $continueStudies], 200);
    }

    public function findByUserId($user_id)
    {
        try {
            $continueStudies = $this->continueStudyRepository->findByUserId($user_id);

            return response()->json(['continueStudies' => $continueStudies], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve continueStudies', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $continueStudyId)
    {
        $continueStudy = $this->continueStudyRepository->findById($continueStudyId);

        if (!$continueStudy) {
            return response()->json(['message' => 'Continue Study not found'], 404);
        }

        try {
            $this->continueStudyRepository->delete($continueStudyId);

            return response()->json(['message' => 'Continue Study successfully deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete continueStudy', 'error' => $e->getMessage()], 500);
        }
    }
}
