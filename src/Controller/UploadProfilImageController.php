<?php

namespace App\Controller;

use App\Entity\Profil;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;


class UploadProfilImageController extends AbstractController
{
    // #[Route('/upload/profil/image', name: 'app_upload_profil_image')]
    public function __invoke(Request $request): Profil
    {
        // Récupération du fichier et du nom depuis la requête
        $uploadedFile = $request->files->get('imageFile');
        $nom = $request->get('nom');

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"imageFile" is required');
        }

        $profil = new Profil();
        $profil->setImageFile($uploadedFile);
        $profil->setNom($nom);

        return $profil;
    }
}
