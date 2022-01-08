<?php

namespace App\Http\Controllers;

use App\Repositories\ScoreRepository;
use Illuminate\Http\JsonResponse;

class FilterController extends Controller
{
    public function __construct(private ScoreRepository $scoreRepository) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'lineup' => ['name' => 'Besetzung', 'values' => $this->scoreRepository->getAllFieldValues('lineup')],
            'type' => ['name' => 'Typ', 'values' => $this->scoreRepository->getAllFieldValues('type')],
            'era' => ['name' => 'Epoche', 'values' => $this->scoreRepository->getAllFieldValues('era')],
            'genre' => ['name' => 'Genre', 'values' => $this->scoreRepository->getAllFieldValues('genre')],
            'severity' => ['name' => 'Schwierigkeitsgrad', 'values' => $this->scoreRepository->getAllFieldValues('severity')],
        ]);
    }
}
