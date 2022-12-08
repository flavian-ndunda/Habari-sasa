<?php

namespace App\Service;

class UploadedFilesService
{
    public function uploadFile(): bool
    {
        $uploadDir = $_SERVER['DOCUMENT_ROOT']."/Downloads/";
        $uploadFile = $uploadDir.basename($_FILES['userfile']['name']);

        return move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadFile);
    }
}
