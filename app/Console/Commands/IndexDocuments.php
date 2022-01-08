<?php

namespace App\Console\Commands;

use App\Models\Score;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Console\Command;

class IndexDocuments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearch:index_documents';

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
    public function __construct(private Client $elasticsearch)
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
        $scores = Score::all();

        foreach ($scores as $score) {
            $score->elasticsearchIndex($this->elasticsearch);
        }

        return 0;
    }
}
