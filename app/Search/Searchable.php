<?php

namespace App\Search;

use Elasticsearch\Client;

trait Searchable
{
    public static function bootSearchable()
    {
        if (config('services.search.enabled')) {
            static::observe(ElasticsearchObserver::class);
        }
    }

    public static function getSearchIndex()
    {
        return env('ELASTICSEARCH_INDEX');
    }

    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function toSearchArray()
    {
        return $this->toArray();
    }

    public function elasticsearchIndex(Client $elasticsearchClient)
    {
        $elasticsearchClient->index([
            'index' => self::getSearchIndex(),
            'id' => $this->getKey(),
            'body' => $this->toElasticsearchDocumentArray(),
        ]);
    }

    public function elasticsearchDelete(Client $elasticsearchClient)
    {
        $elasticsearchClient->delete([
            'index' => self::getSearchIndex(),
            'id' => $this->getKey(),
        ]);
    }

    abstract public function toElasticsearchDocumentArray(): array;
}
