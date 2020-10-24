<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function CreateUploadFol()
    {
        if (!file_exists(public_path('upload'))) {
            mkdir(public_path('upload'), 0777);
        }
        if (!file_exists(public_path('upload/post'))) {
            mkdir(public_path('upload/post'), 0777);
        }
        if (!file_exists(public_path('upload/temp'))) {
            mkdir(public_path('upload/temp'), 0777);
        }
    }

    public function CreateContentFol()
    {
        if (!file_exists(public_path('content'))) {
            mkdir(public_path('content'), 0777);
        }
        if (!file_exists(public_path('content/posts'))) {
            mkdir(public_path('content/posts'), 0777);
        }
        if (!file_exists(public_path('content/categories'))) {
            mkdir(public_path('content/categories'), 0777);
        }
        if (!file_exists(public_path('content/tags'))) {
            mkdir(public_path('content/tags'), 0777);
        }
    }
}
