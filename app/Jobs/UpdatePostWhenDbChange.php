<?php

namespace App\Jobs;

use App\Models\Post;
use App\Repositories\ExportJson;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdatePostWhenDbChange implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $col = null;
    protected $id = null;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($col, $id)
    {
        $this->col = $col;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->col && $this->id) {
            Post::where($this->col, $this->id)->chunk(20, function ($posts) {
                foreach ($posts as $post) {
                    ExportJson::exportPost($post);
                }
            });
            Log::info('Handled update post : ' . $this->col . ' ' . $this->id);
            ExportJson::feedToJson('home');
            ExportJson::feedToJson('category');
        }
    }
}
