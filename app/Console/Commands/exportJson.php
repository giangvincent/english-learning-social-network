<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class exportJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:json {type?} {id?}';

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
    public function __construct()
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
        $typeExport = $this->argument('type');
        $exportId = $this->argument('id');
        if ($typeExport && $typeExport === 'post') {
            if ($exportId && is_numeric($exportId)) {
                $post = \App\Models\Post::firstOrFail($exportId);
                \App\Repositories\ExportJson::exportPost($post);
                $this->info('Exported post: ' . $exportId);
            } else {
                $posts = \App\Models\Post::all();
                foreach ($posts as $post) {
                    \App\Repositories\ExportJson::exportPost($post);
                }
                $this->info('Exported posts');
            }
            $this->info('finish export.');
            return 0;
        }

        if ($typeExport && $typeExport === 'tag') {

        }

        $this->info('do nothing');
        return 0;
    }
}
