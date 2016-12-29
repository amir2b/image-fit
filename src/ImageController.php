<?php

namespace Amir2b\ImageFit;

use App\Http\Controllers\Controller;
use Request;
use Image;

class ImageController extends Controller
{
    public function create($image, $type, $width, $height, $ext)
    {
        try {
            if ((config('app.debug') || !empty(Request::server('HTTP_REFERER'))) && file_exists(public_path("files{$image}.{$ext}"))) {
                $w = $width * 10;
                if ($w <= 0) $w = null;

                $h = $height * 10;
                if ($h <= 0) $h = null;

                if ($w > 2000 || $h > 1500)
                    abort(404);

                $img = Image::make("files{$image}.{$ext}");

                switch ($type) {
                    case '_':
                        if ($w == null || $h == null)
                            abort(404);
                        else {
                            $img->fit($w, $h);
                        }
                        break;
                    case '-':
                        if ($w != null && $h == null)
                            $img->widen($w);
                        elseif ($w == null && $h != null)
                            $img->heighten($h);
                        elseif ($w != null && $h != null) {
                            $img->resize($w, $h, function ($constraint) {
                                $constraint->aspectRatio();
                                #$constraint->upsize();
                            });
                        }

                        break;
                    default:
                        abort(404);
                }

                @mkdir(dirname(public_path("images{$image}.{$ext}")), 0755, true);
                $img->save("images{$image}{$type}{$width}x{$height}.{$ext}");
                return $img->response($ext);
            }
        } catch(\Exception $e){}

        abort(404);
        return false;
    }
}
