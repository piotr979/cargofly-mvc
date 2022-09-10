<?php

declare(strict_types = 1 );

namespace App\Services;

use App\Exceptions\FileHandlingException;

class FileHandler 
{
    private $mime_types = ['image/gif', 'image/png', 'image/webp', 'image/jpeg'];

    public function uploadFile(array $files): string|bool
    {

        try {
        if ($files['file']['size'] > 1000000) {
            throw new FileHandlingException("File is too large.");
        }
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
            if ($files['file']['tmp_name'] === '') {
                throw new FileHandlingException('No image uploaded.Try again');
                return false;
            }
        $mime_type = finfo_file($finfo, $files['file']['tmp_name']);

        if (!in_array($mime_type, $this->mime_types)) {
            throw new FileHandlingException("Wrong file type.");
        }

        $extension = pathinfo($files['file']['name'], PATHINFO_EXTENSION);
        $newFileName = str_replace("." . $extension, "", $files['file']['name']);
        $newFileName = $newFileName . uniqid() . "." . $extension;
        $destination = "uploads/" . $newFileName ;
        if (move_uploaded_file($files['file']['tmp_name'], $destination)) {
            return $newFileName;
        } else {
            throw new FileHandlingException("Error uploading file.");
        }
    } catch (FileHandlingException $e) {
        echo $e->getMessage();
    }
       
    }
}