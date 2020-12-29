<?php


/*
 * This file is part of the MadForWebs package
 *
 * Copyright (c) 2017 Fernando Sánchez Martínez
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Fernando Sánchez Martínez <fer@madforwebs.com>
 */

namespace MadForWebs\UserBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\HttpFoundation\File\File as SFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\MappedSuperclass
 */
class Role
{
    /**
     * Encrypted password. Must be persisted.
     *
     * @var string
     */
    protected $name;

    public function __construct()
    {
        $this->name = ""
    }


    /**
     * @return string
     */
    public function __toString()
    {
        return sprintf('%s', $this->getName());
    }


    public function getName(){
        return $this->name;
    }

    public function setName( $name ){
        $this->name = $name;
        return $this;
    }

}

