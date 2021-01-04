<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $root_folder = "dist/";

    public function CreateUploadFol()
    {
        if (!file_exists(public_path($this->root_folder . 'upload'))) {
            mkdir(public_path($this->root_folder . 'upload'), 0777);
        }
        if (!file_exists(public_path($this->root_folder . 'upload/post'))) {
            mkdir(public_path($this->root_folder . 'upload/post'), 0777);
        }
        if (!file_exists(public_path($this->root_folder . 'upload/temp'))) {
            mkdir(public_path($this->root_folder . 'upload/temp'), 0777);
        }
    }

    public function CreateContentFol()
    {
        if (!file_exists(public_path($this->root_folder . 'content'))) {
            mkdir(public_path($this->root_folder . 'content'), 0777);
        }
        if (!file_exists(public_path($this->root_folder . 'content/posts'))) {
            mkdir(public_path($this->root_folder . 'content/posts'), 0777);
        }
        if (!file_exists(public_path($this->root_folder . 'content/categories'))) {
            mkdir(public_path($this->root_folder . 'content/categories'), 0777);
        }
        if (!file_exists(public_path($this->root_folder . 'content/tags'))) {
            mkdir(public_path($this->root_folder . 'content/tags'), 0777);
        }
        if (!file_exists(public_path($this->root_folder . 'content/audios'))) {
            mkdir(public_path($this->root_folder . 'content/audios'), 0777);
        }
    }

    public function validateBaseImg($base64Str = '')
    {
        $base64StrData = explode(',', $base64Str)[1];
        $file_data = base64_decode($base64StrData);
        $f = finfo_open();
        $mime_type = finfo_buffer($f, $file_data, FILEINFO_MIME_TYPE); // mimetype, f.ex. image/jpeg
        $file_type = explode('/', $mime_type)[0]; // file type, f.ex. image
        $extension = explode('/', $mime_type)[1]; // extension, f.ex. jpeg

        $acceptable_mimetypes = [
            'image/png', 'image/gif', 'image/jpeg', 'image/bmp',
        ];
        if (!in_array($mime_type, $acceptable_mimetypes)) {
            return false;
        }
        return true;
    }
}
