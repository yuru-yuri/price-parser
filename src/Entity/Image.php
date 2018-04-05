<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="images")
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Image
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Assert\File(mimeTypes={ "image/jpeg", "image/png" }, maxSize="1M")
     */
    private $file;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $data;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param null|UploadedFile $file
     *
     * @return Image
     */
    public function setFile(?UploadedFile $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): self
    {
        $this->data = $data;

        return $this;
    }

    public function getThumb($size=null)
    {
        if(null === $size)
        {
            return $this->getData();
        }

        $data = (array)$this->getData();
        return $data[$size] ?? null;
    }

}
