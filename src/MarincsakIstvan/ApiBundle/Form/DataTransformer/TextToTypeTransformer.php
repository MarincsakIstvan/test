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

    /**
     * Elkéri az aktuális Type obj. id-ját, vagy ha az objektum null, akkor null-al tér vissza.
     *
     * @param null|Type $type
     * @return integer|null
     */
    public function transform($type)
    {
        if (null === $type) {
            return null;
        }

        return $type->getId();
    }

    /**
     * Átalakítja a kapott string-et egy Type objektummá, vagy ha nem található, akkor kivételt dob
     *
     * @param  string $name
     * @return Type|null
     * @throws TransformationFailedException Ha a nem található ilyen nevű Type az adatbázisban.
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