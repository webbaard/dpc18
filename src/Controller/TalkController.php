<?php

namespace App\Controller;

use App\Repository\TalkRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(path="/talks")
 */
class TalkController
{
    /**
     * @Route(name="talk_list")
     */
    public function list(TalkRepository $repository, SerializerInterface $serializer)
    {
        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $repository->list(),
                'json'
            )
        );
    }

    /**
     * @Route(path="/{id}", name="talk_get")
     */
    public function get(string $id, TalkRepository $repository, SerializerInterface $serializer)
    {
        $talk = $repository->get($id);

        if (null === $talk) {
            throw new NotFoundHttpException('Talk does not exist');
        }

        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $talk,
                'json'
            )
        );
    }
}
