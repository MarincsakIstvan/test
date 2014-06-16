<?php

namespace MarincsakIstvan\ApiBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use MarincsakIstvan\ApiBundle\Entity\Type;

class TextToTypeTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function transform($type)
    {
        if (null === $type) {
            return null;
        }

        return $type->getId();
    }

    /**
     * Transforms a string (number) to an object (issue).
     *
     * @param  string $number
     *
     * @return Issue|null
     *
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($name)
    {
        if (!$name) {
            return null;
        }

        $type = $this->om
            ->getRepository('MarincsakIstvanApiBundle:Type')
            ->findOneByName($name)
        ;

        if (null === $type) {
            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $name
            ));
        }

        return $type;
    }
}