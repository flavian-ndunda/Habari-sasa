<?php

namespace App\Service;

use App\Entity\UploadedFiles;
use App\Repository\UploadedFilesRepository;

class CreateDbEntryService extends UploadedFilesService
{
    private UploadedFilesRepository $uploadedFilesRepository;

    public function __construct(UploadedFilesRepository $uploadedFilesRepository)
    {
        $this->uploadedFilesRepository = $uploadedFilesRepository;
    }

    public function createDbEntry()
    {
        $uploadedFile = new UploadedFiles();

        $name = $_FILES['userfile']['name'];
        $type = $_FILES['userfile']['type'];
        $size = $_FILES['userfile']['size'];

        date_default_timezone_set('UTC');
        $date = date('Y-m-d H:i:s');

        $uploadedFile->setName($name);
        $uploadedFile->setType($type);
        $uploadedFile->setSize($size);
        $uploadedFile->setDate($date);

        $this->uploadedFilesRepository->save($uploadedFile);

        return $uploadedFile;
    }

}