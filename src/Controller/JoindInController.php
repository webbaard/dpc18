<?php

namespace App\Controller;

use App\JoindIn\MockClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @Route(path="/joindin")
 */
class JoindInController
{
    /**
     * @Route(name="joindin_list")
     */
    public function list(MockClient $client, SerializerInterface $serializer)
    {
        return JsonResponse::fromJsonString(
            $serializer->serialize(
                $client->getTalks(),
                'json'
            )
        );
    }
}
