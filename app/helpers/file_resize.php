<?php
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

function resize_image($image)
{
    $originalName = $image->getClientOriginalName();
    $ext = $image->getClientOriginalExtension();

    $uniqueName = time() . '_' . uniqid() . '.' . $ext;

    $manager = new ImageManager(new Driver());

    $img = $manager->read($image->getRealPath());
    $img->scaleDown(800, 800);

    return [
        'img' => $img,
        'originalName' => $originalName,
        'uniqueName' => $uniqueName
    ];
}
