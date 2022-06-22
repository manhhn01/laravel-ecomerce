<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;
use Intervention\Image\Facades\Image;
use Storage;

class ImageController extends Controller
{
    public function product(ImageUploadRequest $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            return response()->json([
                'filename' => $this->storeFile($file, 'images/products/', [360, 480]),
            ]);
        } else {
            $fileResponse = [];
            foreach ($request->file('images') as $file) {
                $fileResponse[] =  $this->storeFile($file, 'images/products/', [360, 480]);
            }
            return response()->json([
                'filenames' => $fileResponse
            ]);
        }
    }

    public function avatar(ImageUploadRequest $request)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            return response()->json([
                'filename' => $this->storeFile($file, 'images/users/', [400, 480]),
            ]);
        }
    }


    /**
     * @param UploadedFile $file
     * @param string $path
     * @param array $size
     * @param int $quality
     * @param string $format
     * @return JsonResponse
     * @throws InvalidArgumentException
     * @throws BindingResolutionException
     */
    protected function storeFile($file, $path, $size = [300, 300], $quality = 90, $format = 'jpg')
    {
        $filePath = $this->filename($file, $path);
        Image::make($file)
            ->fit($size[0], $size[1])
            ->save(
                Storage::disk('public')->path($filePath),
                $quality,
                $format
            );
        return $filePath;
    }

    protected function filename($file, $path)
    {
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        return $path . $fileName . '|' . time() . '.jpg';
    }
}
