<?php

namespace App\Repositories;

use App\Models\Score;
use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class ScoreRepository
{
    public function __construct(private Client $elasticsearch) {}

    public function search(?string $search = null, ?array $filters = null): Collection
    {
        $items = $this->searchOnElasticsearch($search, $filters);

        return $this->buildCollection($items);
    }

    public function getAllFieldValues(string $fieldName): array
    {
        $aggregationName = $fieldName . '_values';

        $result = $this->elasticsearch->search([
            'index' => Score::getSearchIndex(),
            'body' => [
                'aggs' => [
                    $aggregationName => [
                        'terms' => ['field' => $fieldName . '.raw', 'size' => 10000]
                    ]
                ],
                'size' => 0
            ]
        ]);

        return Arr::pluck($result['aggregations'][$aggregationName]['buckets'], 'key');
    }

    private function searchOnElasticsearch(?string $search = null, ?array $filters = null): array
    {
        $query = [];

        if (null === $search) {
            $query['bool']['must'][]['match_all'] = new \stdClass();
        } else {
            $query['bool']['must'][]['query_string'] = [
                'query' => $search
            ];
        }

        if (!empty($filters)) {
            foreach ($filters as $key => $terms) {
                if (!empty($terms)) {
                    $query['bool']['must'][]['terms'][$key . '.raw'] = $terms;
                }
            }
        }

        return $this->elasticsearch->search([
            'index' => Score::getSearchIndex(),
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

    private function getSearchType(): string
    {
        return (new Score())->getSearchType();
    }
}
