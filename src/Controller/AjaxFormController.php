<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/form-ajax")
 */
class AjaxFormController extends AbstractController
{
    /**
     * @Route("/addresses-by-user/{id}", name="ajax_form", methods={"GET"})
     */
    public function getAddressesByUser(Request $request, EntityManagerInterface $entityManager, User $user)
    {
        $repository = $entityManager->getRepository(Address::class);
        $addresses = $repository->findByAddressByUser($user->getId());
        if ($addresses) {
            foreach ($addresses as $address) {
                 $data[] = [
                     'id' => $address->getId(),
                     'address' => $address->getDisplayName(),
                 ];
            }
        }
        if (isset($data)) {
            return new JsonResponse($data);
        } else {
            return new JsonResponse([]);
        }
    }
}
