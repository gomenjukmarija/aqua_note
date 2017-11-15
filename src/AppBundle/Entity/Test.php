<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="test")
 * @UniqueEntity(fields={"nickname"}, message="It looks like you already have this user!")
 */
class Test
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank(message="Please enter a clever nickname")
     */
    private $nickname;

    /**
     * @ORM\Column(type="string")
     */
    private $avatarNumber;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $tagLine;


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getNickname()
    {
        return $this->nickname;
    }


    public function setNickname($nickname)
    {
        $this->nickname = $nickname;
    }

    public function getAvatarNumber()
    {
        return $this->avatarNumber;
    }

    public function setAvatarNumber($avatarNumber)
    {
        $this->avatarNumber = $avatarNumber;
    }

    public function getTagLine()
    {
        return $this->tagLine;
    }

    public function setTagLine($tagLine)
    {
        $this->tagLine = $tagLine;
    }
}