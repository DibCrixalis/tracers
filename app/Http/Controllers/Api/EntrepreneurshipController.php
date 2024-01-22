<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use App\Repositories\Entrepreneurship\EntrepreneurshipRepositoryInterface;

class EntrepreneurshipController extends Controller
{
    private $entrepreneurshipRepository;

    /**
     * Create a new AuthController instance.
     *
     * @param EntrepreneurshipRepositoryInterface $entrepreneurshipRepository
     * @return void
     */

    public function __construct(EntrepreneurshipRepositoryInterface $entrepreneurshipRepository)
    {
        $this->entrepreneurshipRepository = $entrepreneurshipRepository;
    }

    // public function __construct(EntrepreneurshipRepositoryInterface $entrepreneurshipRepository)
    // {
    //     $this->entrepreneurshipRepository = $entrepreneurshipRepository;
    // }


    public function store(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $request->validate([
            'reason' => 'required|string',
            'location' => 'required|string',
            'entr_form' => 'required|string',
            'sector' => 'required|string',
            'product' => 'required|string',
            'num_employees' => 'required|numeric',
            'capital_status' => 'required|string',
            'workforce_fac' => 'required|string',
            'start_time' => 'required|date',
            'ent_count' => 'required|numeric',
            'chg_reason' => 'required|string',
            'working_hours' => 'required|numeric',
            'income_amount' => 'required|numeric',
        ]);

        try {
            $entrepreneurship = $this->entrepreneurshipRepository->create([
                'user_id' => $user->id,
                'reason' => $request->reason,
                'location' => $request->location,
                'entr_form' => $request->entr_form,
                'sector' => $request->sector,
                'product' => $request->product,
                'num_employees' => $request->num_employees,
                'capital_status' => $request->capital_status,
                'workforce_fac' => $request->workforce_fac,
                'start_time' => $request->start_time,
                'ent_count' => $request->ent_count,
                'chg_reason' => $request->chg_reason,
                'working_hours' => $request->working_hours,
                'income_amount' => $request->income_amount,
            ]);

            return response()->json(['message' => 'Entrepreneurship successfully created', 'Entrepreneurship' => $entrepreneurship], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create Entrepreneurship', 'error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, string $entrepreneurshipId)
    {
        $request->validate([
            'reason' => 'required|string',
            'location' => 'required|string',
            'entr_form' => 'required|string',
            'sector' => 'required|string',
            'product' => 'required|string',
            'num_employees' => 'required|numeric',
            'capital_status' => 'required|string',
            'workforce_fac' => 'required|string',
            'start_time' => 'required|date',
            'ent_count' => 'required|numeric',
            'chg_reason' => 'required|string',
            'working_hours' => 'required|numeric',
            'income_amount' => 'required|numeric',
        ]);

        $entrepreneurship = $this->entrepreneurshipRepository->findById($entrepreneurshipId);

        if (!$entrepreneurship) {
            return response()->json(['message' => 'Entrepeneurship not found'], 404);
        }

        try {
            $updatedentrepreneurship = $this->entrepreneurshipRepository->update($entrepreneurshipId, [
                'reason' => $request->reason,
                'location' => $request->location,
                'entr_form' => $request->entr_form,
                'sector' => $request->sector,
                'product' => $request->product,
                'num_employees' => $request->num_employees,
                'capital_status' => $request->capital_status,
                'workforce_fac' => $request->workforce_fac,
                'start_time' => $request->start_time,
                'ent_count' => $request->ent_count,
                'chg_reason' => $request->chg_reason,
                'working_hours' => $request->working_hours,
                'income_amount' => $request->income_amount,
            ]);

            return response()->json(['message' => 'Entrepeneurship successfully updated', 'entrepreneurship' => $updatedentrepreneurship], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to update Entrepreneurship', 'error' => $e->getMessage()], 500);
        }
    }

    public function show(string $entrepreneurshipId)
    {
        $entrepreneurship = $this->entrepreneurshipRepository->findById($entrepreneurshipId);

        if (!$entrepreneurship) {
            return response()->json(['message' => 'Entrepeneurship not found'], 404);
        }

        return response()->json(['entrepreneurship' => $entrepreneurship], 200);
    }

    public function index()
    {
        $entrepreneurship = $this->entrepreneurshipRepository->findAll();

        return response()->json(['entrepreneurship' => $entrepreneurship], 200);
    }

    public function findByUserId($user_id)
    {
        try {
            $entrepreneurship = $this->entrepreneurshipRepository->findByUserId($user_id);

            return response()->json(['ent$entrepreneurship' => $entrepreneurship], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to retrieve ent$entrepreneurship', 'error' => $e->getMessage()], 500);
        }
    }

    public function destroy(string $entrepreneurshipId)
    {
        $entrepreneurship = $this->entrepreneurshipRepository->findById($entrepreneurshipId);

        if (!$entrepreneurship) {
            return response()->json(['message' => 'Entrepeneurship not found'], 404);
        }

        try {
            $this->entrepreneurshipRepository->delete($entrepreneurshipId);

            return response()->json(['message' => 'Entrepeneurship successfully deleted'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete entrepreneurship', 'error' => $e->getMessage()], 500);
        }
    }
}
