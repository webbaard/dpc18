<?php

namespace App\Serializer;

use App\Entity\Talk;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class TalkNormalizer implements NormalizerInterface
{
    /**
     * @var ObjectNormalizer
     */
    private $objectNormalizer;

    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    /**
     * @var string
     */
    private $routeName = 'talk_get';

    /**
     * @var string
     */
    private $routeParameter = 'id';

    /**
     * @param ObjectNormalizer $objectNormalizer
     * @param UrlGeneratorInterface $urlGenerator
     */
    public function __construct(
        ObjectNormalizer $objectNormalizer,
        UrlGeneratorInterface $urlGenerator,
        string $routeName = 'talk_get',
        string $routeParameter = 'id'
    ) {
        $this->objectNormalizer = $objectNormalizer;
        $this->urlGenerator = $urlGenerator;
        $this->routeName = $routeName;
        $this->routeParameter = $routeParameter;
    }

    public function normalize($object, $format = null, array $context = array())
    {
        if (!$object instanceof Talk) {
            throw new InvalidArgumentException('Object to serialize must be a Talk instance.');
        }

        $data = $this->objectNormalizer->normalize($object, $format, $context);

        $selfHref = $this->urlGenerator->generate(
            $this->routeName,
            [
                $this->routeParameter => $object->getId()
            ],
            UrlGeneratorInterface::ABSOLUTE_URL
        );

        if ('xml' === $format) {
            unset($data['id']);
            $data['@id'] = $object->getId();
            $data['link'] = [
                '@rel' => '_self',
                '@href' => $selfHref
            ];
        } else {
            $data['_link'] = $selfHref;
        }

        return $data;
    }

    public function supportsNormalization($data, $format = null)
    {
        return $data instanceof Talk;
    }
}
