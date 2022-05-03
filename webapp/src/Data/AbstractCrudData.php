<?php

namespace App\Data;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\PropertyAccess\PropertyAccessor;

abstract class AbstractCrudData implements CrudDataInterface
{
    protected object $entity;

    public function __construct(object $entity)
    {
        $this->entity = $entity;

        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $accessor = new PropertyAccessor();
        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $value = $accessor->getValue($this->entity, $propertyName);
            if ($value instanceof Collection) {
                $value = $value->toArray();
            }
            // hydrate l'objet courant avec l'entité
            $accessor->setValue($this, $propertyName, $value);
        }
    }

    /**
     * Hydrate un object.
     */
    public function hydrate(): void
    {
        $reflection = new \ReflectionClass($this);
        $properties = $reflection->getProperties(\ReflectionProperty::IS_PUBLIC);
        $accessor = new PropertyAccessor();

        foreach ($properties as $property) {
            $propertyName = $property->getName();

            // hydrate l'entité avec l'objet courant
            $value = $accessor->getValue($this, $propertyName);
            if ($value instanceof Collection) {
                $value = $value->toArray();
            }
            $accessor->setValue($this->entity, $propertyName, $value);
        }
    }
}
