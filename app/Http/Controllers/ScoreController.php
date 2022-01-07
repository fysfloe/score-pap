<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Repositories\ScoreRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    public function __construct(private ScoreRepository $scoreRepository) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->scoreRepository->search($request->get('search'))
        );
    }

    public function get(int $id): JsonResponse
    {
        return response()->json(
            $this->scoreRepository->search(`_id:$id`)
        );
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255'
        ]);

        $score = new Score($request->all());
        $score->save();

        return response()->json($score);
    }
}
