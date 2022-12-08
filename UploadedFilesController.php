<?php

namespace App\Controller;

use App\Repository\UploadedFilesRepository;
use App\Service\CreateDbEntryService;
use App\Service\UploadedFilesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadedFilesController extends AbstractController
{
    private UploadedFilesService $uploadedFilesService;
    private CreateDbEntryService $createDbEntryService;
    private UploadedFilesRepository $uploadedFilesRepository;

    public function __construct(
        UploadedFilesService $uploadedFilesService,
        CreateDbEntryService $createDbEntryService,
        UploadedFilesRepository $uploadedFilesRepository)
    {
        $this->uploadedFilesService = $uploadedFilesService;
        $this->createDbEntryService = $createDbEntryService;
        $this->uploadedFilesRepository = $uploadedFilesRepository;
    }

    /**
     * @Route ("/")
     */
    public function listFiles(): Response
    {
        $files = $this->uploadedFilesRepository->findAll();

        return $this->render("index.html.twig", [
            "files"=>$files
        ]);
    }

    /**
     * @Route ("/upload-file")
     */
    public function uploadFile()
    {
        $response = "";

        if($this->uploadedFilesService->uploadFile()){

            $this->createDbEntryService->createDbEntry();

            return $this->redirect("/");
        } else {
            $response = "Error";
        }
        return $response;
    }

    /**
     * @Route ("/download-file/{id}")
     */
    public function downloadFile($id): BinaryFileResponse
    {
        $file = $this->uploadedFilesRepository->find($id);

        return $this->file($_SERVER['DOCUMENT_ROOT']."/Downloads/".$file->getName());
    }

    /**
     * @Route ("/remove-file/{id}")
     */
    public function removeFile($id): RedirectResponse
    {
        if(!empty($id)){
            $file = $this->uploadedFilesRepository->find($id);

            unlink($_SERVER['DOCUMENT_ROOT']."/Downloads/".$file->getName());
            $this->uploadedFilesRepository->delete($file);
        }

        return $this->redirect("/");
    }

}