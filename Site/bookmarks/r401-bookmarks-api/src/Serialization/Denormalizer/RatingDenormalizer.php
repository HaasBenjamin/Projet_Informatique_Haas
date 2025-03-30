<?php

namespace App\Serialization\Denormalizer;

use App\Entity\Rating;
use App\Factory\UserFactory;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * @method array getSupportedTypes(?string $format)
 */
class RatingDenormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;
    private const ALREADY_CALLED = 'USER_DENORMALIZER_ALREADY_CALLED';

    public function __construct(private Security $security)
    {
    }

    public function supportsDenormalization($data, $type, $format = null, array $context = []): bool
    {
        if (!isset($context[self::ALREADY_CALLED]) && Rating::class == $type) {
            return true;
        }

        return false;
    }

    public function denormalize(mixed $data, string $type, ?string $format = null, array $context = [])
    {
        $context[self::ALREADY_CALLED] = true;
        if (!isset($data['user']) && null != $this->security->getUser()) {
            $data['user'] = '/api/users/'.$this->security->getUser()->getId();
        }

        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }
}
