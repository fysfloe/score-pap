<?php

namespace App\Console\Commands;

use App\Models\Score;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class CreateElasticsearchIndexMapping extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:create_index_mapping';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private ?Client $elasticsearch)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $score = new Score();

        if (!$this->indexExists()) {
            $this->elasticsearch->indices()->create([
                'index' => 'score-pap',
                'body' => [
                    'mappings' => [
                        'properties' => $this->getMappings()
                    ]
                ]
            ]);
        } else {
            $this->elasticsearch->indices()->putMapping([
                'index' => env('ELASTICSEARCH_INDEX'),
                'body' => [
                    '_source' => [
                        'enabled' => true
                    ],
                    'properties' => $this->getMappings()
                ]
            ]);
        }

        //dump($this->elasticsearch->index(['index' => env('ELASTICSEARCH_INDEX')]));

        return 0;
    }

    /**
     * @return bool
     */
    protected function indexExists(): bool
    {
        return $this->elasticsearch->indices()->exists(['index' => env('ELASTICSEARCH_INDEX')]);
    }

    /**
     * @return array
     */
    protected function getTextFieldMapping(): array
    {
        return [
            'type' => 'text',
            'fields' => [
                'raw' => ['type' => 'keyword']
            ]
        ];
    }

    /**
     * @return \array[][]
     */
    protected function getMappings(): array
    {
        return [
            'lineup' => $this->getTextFieldMapping(),
            'type' => $this->getTextFieldMapping(),
            'era' => $this->getTextFieldMapping(),
            'genre' => $this->getTextFieldMapping(),
            'severity' => $this->getTextFieldMapping(),
        ];
    }
}
