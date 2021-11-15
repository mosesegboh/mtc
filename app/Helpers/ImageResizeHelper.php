<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Image;

class ImageResizeHelper
{
    private $image;

	public function __construct()
    {
	}

    public function resizeAndSave($image)
    { 
        $image_name = time() . '.' . $image->getClientOriginalExtension();

        $destinationPath = public_path('/thumbnail');

        $resize_image = Image::make($image->getRealPath());

        $resize_image->resize(100, 100, function($constraint){

            $constraint->aspectRatio();

        })->save($destinationPath . '/' . $image_name);

        $destinationPath = public_path('/images');

        $image->move($destinationPath, $image_name);

        return $image_name;
    }

    public static function instance()
    {
        return new ImageResizeHelper();
    }
}