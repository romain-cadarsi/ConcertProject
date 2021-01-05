<?php

namespace App\Service;

use App\Entity\Picture;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\KernelInterface;

class ImageUploadService
{
    private $appKernel;

    public function __construct(KernelInterface $appKernel)
    {
        $this->appKernel = $appKernel;
    }
    public function uploadImage(UploadedFile $pictureElement) : Picture
    {
        $pictureLabel = $pictureElement->getClientOriginalName();
        $pictureName = $pictureElement->getFileName() .'.'. $pictureElement->guessExtension();
        move_uploaded_file($pictureElement, $this->appKernel->getProjectDir() . '/public/image/' . $pictureName);
        return new Picture($pictureName,$pictureLabel);
    }
}