<?php

namespace App\Services;

use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class FileServices
{
  public function updateFile($model, $request, $type)
  {
    $image = (new ImageManager(new Driver()))->read($request->file('file'));

    if (!empty($model->file)) {
      $currentFile = public_path() . Str::after($model->file, url('/'));
      if (file_exists($currentFile)) unlink(($currentFile));
    }

    $file = null;
    if ($type == 'user') {
      $file = $image->resize(400, 400);
    } else {
      $file = $image;
    }

    $ext = ($request->file('file'))->getClientOriginalExtension();

    $name = time() . '.' . $ext;
    $file->save(public_path() . '/files/' . $name);
    $model->file = url('/') . '/files/' . $name;

    return $model;
  }
}
