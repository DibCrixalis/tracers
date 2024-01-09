<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\Surveys\SurveyRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class SurveyController extends Controller
{
    private $surveyRepository;

    public function __construct(SurveyRepositoryInterface $surveyRepository)
    {
        $this->surveyRepository = $surveyRepository;
    }

    public function index()
    {
        try {
            $surveys = $this->surveyRepository->getAll();

            return response()->json(['data' => $surveys], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $survey = $this->surveyRepository->getById($id);

            return response()->json(['data' => $survey], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function store(Request $request)
    {
        try {
            // Ambil ID pengguna yang sedang login
            $authenticatedUserId = auth()->user()->id;

            // Validasi dan buat survey
            $data = $request->validate([
                'tahun_lulusan' => 'required|date_format:Y-m-d',
                'status_sekarang' => 'required|in:kerja,tidak_bekerja,pengusaha',
                'nama_perusahaan' => 'nullable|string',
                'posisi' => 'nullable|string',
                'lama_bekerja' => 'nullable|integer|min:0',
            ]);

            // Setel user_id ke ID pengguna yang sedang login
            $data['user_id'] = $authenticatedUserId;

            $survey = $this->surveyRepository->create($data);

            return response()->json(['data' => $survey], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $authenticatedUserId = auth()->user()->id;

            $data = $request->validate([
                'user_id' => [
                    'required',
                    'uuid',
                    Rule::in([$authenticatedUserId]),
                ],
                'tahun_lulusan' => 'date_format:Y-m-d',
                'status_sekarang' => 'in:kerja,tidak_bekerja,pengusaha',
                'nama_perusahaan' => 'nullable|string',
                'posisi' => 'nullable|string',
                'lama_bekerja' => 'nullable|integer|min:0',
            ]);

            $survey = $this->surveyRepository->update($id, $data);

            return response()->json(['data' => $survey], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    public function destroy($id)
    {
        try {
            $this->surveyRepository->delete($id);

            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
