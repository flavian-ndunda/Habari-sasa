<?php

namespace App\Repository;

use App\Entity\UploadedFiles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UploadedFilesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UploadedFiles::class);
    }

    public function save(UploadedFiles $uploadedFiles)
    {
        $this->getEntityManager()->persist($uploadedFiles);
        $this->getEntityManager()->flush();
    }

    public function delete(UploadedFiles $uploadedFiles)
    {
        $this->getEntityManager()->remove($uploadedFiles);
        $this->getEntityManager()->flush();
    }

}
