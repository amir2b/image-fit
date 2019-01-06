<?php

if (!function_exists('image_url')) {

    /**
     * @param string $file
     * @param int $width
     * @param int $height
     * @param bool $is_crop
     * @return string
     */
    function image_url($file, $width = 0, $height = 0, $is_crop = false)
    {
		$root_path = config(config('image-fit.root_path'), 'files');
		
        $file = trim($file, '/');
        if (empty($file)) {
            if (!empty(config('image-fit.image_default')))
                $file = config('image-fit.image_default');
            else
                return url('vendor/image-fit/no-image.jpg');
        }

        $info = pathinfo($file);

        if (count($info) == 4) {
            if (substr($info['dirname'], 0, 6) == "{$root_path}/")
                $file = config('image-fit.prefix') . '/' . substr($info['dirname'], 6) . "/{$info['filename']}";
            elseif ($info['dirname'] == $root_path)
                $file = config('image-fit.prefix') . "/{$info['filename']}";
            else
                $file = config('image-fit.prefix') . "/{$info['dirname']}/{$info['filename']}";

            return url($file . ($is_crop ? '_' : '-') . "{$width}x{$height}.{$info['extension']}");
        }

        return url($file);
    }

}
