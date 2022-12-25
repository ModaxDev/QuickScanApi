<?php

namespace App\Normalizer;

use App\Entity\Product;
use App\Entity\ProductAccessories;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

class ProductAccessorieFileNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'AppProductAccessorieNormalizerAlreadyCalled';

    public function __construct(private StorageInterface $storageInterface)
    {
    }

    public function supportsNormalization($data, string $format = null, array $context = []): bool
    {
        return !isset($context[self::ALREADY_CALLED]) && $data instanceof ProductAccessories;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        $object->setFileUrl($this->storageInterface->resolveUri($object, "picture"));
        $context[self::ALREADY_CALLED] = true;
        return $this->normalizer->normalize($object, $format, $context);
    }
}