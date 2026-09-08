<?php

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

if (!function_exists('resize_image')) {

    function resize_image(UploadedFile $image): array
    {
        $originalName = $image->getClientOriginalName();

        $extension = strtolower(
            $image->getClientOriginalExtension()
        );

        $uniqueName = time() . '_' . uniqid() . '.' . $extension;

        $manager = new ImageManager(
            new Driver()
        );

        $img = $manager->read(
            $image->getRealPath()
        );

        $img->scaleDown(
            800,
            800
        );

        return [

            'img' => $img,

            'originalName' => $originalName,

            'uniqueName' => $uniqueName,

            'extension' => $extension,
        ];
    }
}


if (!function_exists('save_resize_image')) {

    function save_resize_image(array $resize, string $savePath): bool
    {
        switch ($resize['extension']) {

            case 'jpg':
            case 'jpeg':
                $resize['img']->toJpeg(85)->save($savePath);
                break;

            case 'png':
                $resize['img']->toPng()->save($savePath);
                break;

            case 'webp':
                $resize['img']->toWebp(85)->save($savePath);
                break;

            default:
                throw new Exception('Unsupported image format.');
        }

        return true;
    }
}
