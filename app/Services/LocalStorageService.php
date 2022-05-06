<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Services\IStorageService;
use Illuminate\Support\Str;

class LocalStorageService implements IStorageService
{
    public function __construct()
    {
    }

    public function saveFile($data, $objectKey = 'image', $directory = 'images/post/')
    {
        $result = $this->putFile($data, $objectKey, $directory);
        if ($result) return $result;
        // throw new Exception("Error Processing Request", 1);
        
         
    }

    public function updateFile($existingFilePath, $data, $objectKey = 'image', $directory = 'images/post/')
    {
        $result = $this->putFile($data, $objectKey, $directory);
            if ($result) {
                Storage::disk('public')->delete($existingFilePath);
                // error_log(json_encode($result));
                return $result;
            }
        // throw new Exception("Error Processing Request", 1);
    }

    public function deleteFile(string $existingFilePath)
    {
        return Storage::disk('public')->delete($existingFilePath);
    }

    public function putFile(array $data, string $objectKey, string $directory) {
        $file = $data[$objectKey];
        $image_name = Str::random(20);
        $ext = strtolower($file->getClientOriginalName()); // You can use also getClientOriginalName()
        $image_full_name = $directory.$image_name.'-'.$ext;
        if(Storage::disk('public')->put($image_full_name, file_get_contents($file))) {
            $data[$objectKey] = $image_full_name;
            error_log(json_encode($data));
            return $data;
        }
        return [];
    }
}