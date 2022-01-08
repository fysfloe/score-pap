<?php

namespace App\Search;

use Elasticsearch\Client;
use Illuminate\Database\Eloquent\Model;

class ElasticsearchObserver
{
    public function __construct(private Client $elasticsearch)
    {
        // ...
    }

    public function saved(Model $model)
    {
        $this->elasticsearch->index([
            'index' => $model->getSearchIndex(),
            'id' => $model->getKey(),
            'body' => $model->toSearchArray(),
        ]);
    }

    public function deleted($model)
    {
        $this->elasticsearch->delete([
            'index' => $model->getSearchIndex(),
            'id' => $model->getKey(),
        ]);
    }
}
