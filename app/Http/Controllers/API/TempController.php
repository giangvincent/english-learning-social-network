<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TempController extends Controller
{
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

    public function uploadTempImg(Request $request)
    {
        $this->CreateUploadFol();
        $base64String = $request->base64;
        if (!$this->validateBaseImg($base64String)) {
            $res = [
                'success' => false,
                'message' => 'Validate failed: Image error',
            ];
            return response()->json($res);
        }
        $tempImg = $this->saveImgBase64($base64String, 'temp');
        if ($tempImg) {
            $res = [
                'success' => true,
                'data' => $tempImg,
            ];
        }

        return response()->json($res);
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

    protected function saveImgBase64($param, $folder)
    {
        list($extension, $content) = explode(';', $param);
        $tmpExtension = explode('/', $extension);
        preg_match('/.([0-9]+) /', microtime(), $m);
        $fileName = sprintf('img%s%s.%s', date('YmdHis'), $m[1], $tmpExtension[1]);
        $content = explode(',', $content)[1];
        $storage = Storage::disk('public');

        $storage->put($folder . '/' . $fileName, base64_decode($content), 'public');

        return 'upload' . '/' . $folder . '/' . $fileName;
    }
}
