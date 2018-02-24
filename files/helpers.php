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
        $file = trim($file, '/');
        if (empty($file)) {
            if (!empty(config('image-fit.image_default')))
                $file = config('image-fit.image_default');
            else
                return url('vendor/image-fit/no-image.jpg');
        }

        $info = pathinfo($file);

        if (count($info) == 4) {
            if (substr($info['dirname'], 0, 6) == 'files/')
                $file = config('image-fit.prefix') . '/' . substr($info['dirname'], 6) . "/{$info['filename']}";
            elseif ($info['dirname'] == 'files')
                $file = config('image-fit.prefix') . "/{$info['filename']}";
            else
                $file = config('image-fit.prefix') . "/{$info['dirname']}/{$info['filename']}";

            return url($file . ($is_crop ? '_' : '-') . "{$width}x{$height}.{$info['extension']}");
        }

        return url($file);
    }

}
