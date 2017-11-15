<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="test")
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
     * @ORM\Column(type="string")
     */
    private $nickname;

    /**
     * @ORM\Column(type="string")
     */
    private $avatarNumber;

    /**
     * @ORM\Column(type="string")
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