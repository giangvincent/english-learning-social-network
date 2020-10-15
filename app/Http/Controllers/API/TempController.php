<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $res = [
            'success' => false,
            'message' => '',
        ];
        $this->CreateUploadFol();
        $base64String = $request->input('base64');
        $tempImg = new Photo();
        $tempImg->image = $this->saveImgBase64($base64String, 'upload/temp');

        if ($tempImg->save()) {
            $res = [
                'success' => true,
                'message' => 'Successfully updated',
            ];
        }

        return response()->json($res);
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

        return $fileName;
    }
}
