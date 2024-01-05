<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

trait ImageUpload
{
    //image upload
    public function image($file, $path, $width, $height)
    {
        // multiple image upload
        if (is_array($file)) {
            if (! empty($file)) {
                $gallery = [];
                $i = 1;
                foreach ($file as $item) {
                    $fileName = substr(md5(time()), 0, 20).$i.'.'.$item->getClientOriginalExtension();
                    Image::make(file_get_contents($item))->resize($width, $height)->save($path.$fileName);
                    $gallery[] = $path.$fileName;
                    $i++;
                }

                return json_encode($gallery);
            }
        }

        // single image upload
        if (! empty($file)) {
            $fileName = substr(md5(time()), 0, 20).'.'.$file->getClientOriginalExtension();
            Image::make(file_get_contents($file))->resize($width, $height)->save($path.$fileName);

            return $path.$fileName;
        }

    }

    public function fileUpload($file, $path)
    {
        if (! empty($file)) {
            $fileName = substr(md5(time()), 0, 20).'.'.$file->getClientOriginalExtension();
            $file->move($path, $fileName);

            return $path.$fileName;
        }

        return null;
    }

    public static function base64FileStore($file, $directory, $filename, $oldImage = null): string
    {
        self::fileDelete($oldImage);
        $image_name = $filename.'_'.Str::uuid();
        $base64Image = explode(';base64,', $file);
        $explodeImage = explode('image/', $base64Image[0]);
        $extension = $explodeImage[1];
        $image_base64 = base64_decode($base64Image[1]);

        $image = $directory.$image_name.'.'.$extension;
        if (! is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
        file_put_contents($image, $image_base64);

        return $image;
    }

    public static function fileDelete($image)
    {
        if (File::exists($image)) {
            File::delete($image);
        }

        return null;
    }
}
