<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Repositories\ScoreRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ScoreController extends Controller
{
    public function __construct(private ScoreRepository $scoreRepository) {}

    public function index(Request $request): JsonResponse
    {
        return response()->json(
            $this->scoreRepository->search($request->get('search'), $request->get('filters'))
        );
    }

    public function get(int $id): JsonResponse
    {
        return response()->json(
            $this->scoreRepository->search("_id:$id")[0]
        );
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'file' => 'required'
        ]);

        $file = $request->get('file');

        $fileContent = base64_decode($file['data']);
        $filePath = 'public/scores/' . $file['name'];

        if (Storage::disk('local')->exists($filePath)) {
            return response()->json(['error' => 'Datei existiert bereits.'], 400);
        }

        Storage::disk('local')->put($filePath, $fileContent);

        $score = new Score($request->all());
        $score->file_path = str_replace('public/', '', $filePath);

        $score->save();

        return response()->json($score);
    }

    public function edit(Request $request, Score $score): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            //'file' => 'required'
        ]);

        $scoreInput = $request->all();

        $file = $request->get('file');

//        $fileContent = base64_decode($file['data']);
//        $filePath = 'public/scores/' . $file['name'];
//
//        if (Storage::disk('local')->exists($filePath)) {
//            return response()->json(['error' => 'Datei existiert bereits.'], 400);
//        }
//
//        Storage::disk('local')->put($filePath, $fileContent);
//
//        $score->file_path = str_replace('public/', '', $filePath);

        $score->update($scoreInput);

        return response()->json($score);
    }
}
