<?php

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File
{
    protected const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_';
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function generateName(int $len = 8): string
    {
        if($len < 5)
        {
            throw new \RuntimeException('Len < 1');
        }

        $str = '';
        $alphabetLen = \strlen(self::ALPHABET) - 1;

        while (\strlen($str) < $len)
        {
            $index = \random_int(0, $alphabetLen);
            $str .= self::ALPHABET[$index];
        }

        return implode('/', [
            \substr($str, 0, 2),
            \substr($str, 2, 2),
            \substr($str, 4)
        ]);
    }

    public function uploadFile(UploadedFile $file)
    {
        $rootPath = $this->container->getParameter('images_directory');
        $extension = $file->guessExtension();

        do
        {
            $fileName = $this->generateName() . '.' . $extension;
        }
        while (\is_file($rootPath . '/' . $fileName));

        $fullName = $fileName;

        $rootPath .= '/' . \dirname($fileName);
        $fileName = \basename($fileName);

        $file->move($rootPath, $fileName);

        return $fullName;
    }
}
