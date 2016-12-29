<?php

if (! function_exists('image_url')) {

    /**
     * @param string $file
     * @param int $width
     * @param int $height
     * @param bool $is_crop
     * @return string
     */
    function image_url($file, $width = 0, $height = 0, $is_crop = false)
    {
        $info = pathinfo($file);
        if (count($info) == 4) {
            if (substr($info['dirname'], 0, 6) == 'files/') {
                $info['dirname'] = substr($info['dirname'], 6);
            }
            return url("images/{$info['dirname']}/{$info['filename']}" . ($is_crop ? '_' : '-') . "{$width}x{$height}.{$info['extension']}");
        }

        return url($file);
    }

}
