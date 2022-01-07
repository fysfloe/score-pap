<?php

namespace App\Repositories;

use App\Models\Score;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ScoreRepository
{
    public function __construct(private Client $elasticsearch) {}

    public function search(?string $query = null): Collection
    {
        $items = $this->searchOnElasticsearch($query);

        return $this->buildCollection($items);
    }

    private function searchOnElasticsearch(?string $query = null): array
    {
        $model = new Score();

        if (null === $query) {
            $query = [
                'match_all' => new \stdClass(),
            ];
        } else {
            $query = [
                'query_string' => [
                    'query' => $query
                ]
            ];
        }

        return $this->elasticsearch->search([
            'index' => $model->getSearchIndex(),
            'type' => $model->getSearchType(),
            'body' => [
                'query' => $query,
            ],
        ]);
    }

    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_id');

        return Score::findMany($ids)
            ->sortBy(function ($score) use ($ids) {
                return array_search($score->getKey(), $ids);
            });
    }
}
