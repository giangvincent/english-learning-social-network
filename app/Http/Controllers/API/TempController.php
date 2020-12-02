<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TempController extends Controller
{
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

    private function saveImgBase64($param, $folder)
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
