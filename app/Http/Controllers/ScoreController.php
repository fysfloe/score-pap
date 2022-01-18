<?php

namespace App\Http\Controllers;

use App\Models\Score;
use App\Repositories\ScoreRepository;
use Illuminate\Contracts\Filesystem\FileExistsException;
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

    public function get(Score $score): JsonResponse
    {
        return response()->json($score);
    }

    public function create(Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'file' => 'required'
        ]);

        $file = $request->get('file');

        $score = new Score($request->all());

        try {
            $score = $this->uploadFile($file, $score);
        } catch (FileExistsException $e) {
            return response()->json(['error' => 'Datei existiert bereits.'], 400);
        }

        $score->save();

        return response()->json($score);
    }

    public function edit(Score $score, Request $request): JsonResponse
    {
        $request->validate([
            'title' => 'required|max:255',
            'author' => 'required|max:255',
            'file' => 'required'
        ]);

        $scoreInput = $request->all();

        $file = $request->get('file');

        if (!empty($file['data'])) {
            if (Storage::disk('local')->exists('public/' . $score->file_path)) {
                Storage::disk('local')->delete('public/' . $score->file_path);
            }

            try {
                $score = $this->uploadFile($file, $score);
            } catch (FileExistsException $e) {
                return response()->json(['error' => 'Datei existiert bereits.'], 400);
            }
        }

        $score->update($scoreInput);

        return response()->json($score);
    }

    /**
     * @param array $file
     * @param Score $score
     * @return Score
     * @throws FileExistsException
     */
    protected function uploadFile(array $file, Score $score): Score
    {
        $fileContent = base64_decode($file['data']);
        $filePath = 'public/scores/' . $file['name'];

        if (Storage::disk('local')->exists($filePath)) {
            throw new FileExistsException();
        }

        Storage::disk('local')->put($filePath, $fileContent);

        $score->file_path = str_replace('public/', '', $filePath);

        return $score;
    }
}
