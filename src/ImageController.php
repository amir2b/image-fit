<?php

namespace Amir2b\ImageFit;

use App\Http\Controllers\Controller;
use Image;
use Request;

class ImageController extends Controller
{
    public function create($image, $type, $width, $height, $ext)
    {
        try {
            if ((config('app.debug') || !empty(Request::server('HTTP_REFERER')))) {
                $w = $width * 10;
                if ($w <= 0) $w = null;

                $h = $height * 10;
                if ($h <= 0) $h = null;

                if ($w > 2000 || $h > 1500)
                    abort(404);

                if (!in_array($type, ['_', '-']))
                    return abort(404);
                    
				$root_path = config('image-fit.root_path', 'files');

                if (
                    in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'gif', 'webp']) &&
                    file_exists(public_path("{$root_path}{$image}.{$ext}"))
                ) {
                    $img = Image::make("{$root_path}{$image}.{$ext}");
                } else {
                    if (($image404 = config('image-fit.image_404')) && file_exists(public_path($image404))) {
                        $img = Image::make($image404);
                    } elseif (file_exists(public_path('vendor/image-fit/404.jpg'))) {
                        $img = Image::make(public_path('vendor/image-fit/404.jpg'));
                    } else
                        return abort(404);
                }

                switch ($type) {
                    case '_':
                        if ($w == null || $h == null)
                            return abort(404);
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
                }

                @mkdir(dirname(public_path(config('image-fit.prefix') . "{$image}.{$ext}")), 0755, true);
                $img->save(public_path(config('image-fit.prefix') . "{$image}{$type}{$width}x{$height}.{$ext}"));
                return $img->response($ext);
            }
        } catch (\Exception $e) {
        }

        return abort(404);
    }
}
