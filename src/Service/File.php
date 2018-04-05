<?php

namespace App\Service;

use Intervention\Image\Constraint;
use Intervention\Image\ImageManager;

class File
{
    protected const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_';
    private $targetDir;
    private $driver;
    private $manager;
    private $imagesWebRoot;

    public function __construct(array $params, ImageManager $manager)
    {
        $this->targetDir = $params['targetDir'];
        $this->driver = $params['driver'];
        $this->imagesWebRoot = $params['imagesWebRoot'];
        $this->manager = $manager;
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

    /**
     * @param string $path
     * @param array $options
     *
     * @return string
     */
    public function imageResize(string $path, array $options): ?string
    {
        if(!\is_file($path))
        {
            throw new \RuntimeException($path . ' is not file!');
        }

        $pathInfo = \pathinfo($path);

        $directory = $pathInfo['dirname'];
        $filename = $pathInfo['filename'];
        $extension = $pathInfo['extension'];

        $tmbPath = \sprintf('%s/%s-%sx%s.%s',
            $directory,
            $filename,
            $options['width'],
            $options['height'],
            $extension
        );

        if(\is_file($tmbPath))
        {
            return $tmbPath;
        }

        $image = $manager->make($path);

        if('resizeAspect' === $options['type'])
        {
            $image->resize($options['width'], $options['height'], function ($constraint) {
                /**
                 * @var $constraint Constraint
                 */
                $constraint->aspectRatio();
            });
        }
        else
        {
            $image->{$options['type']}($options['width'], $options['height']);
        }

        $image->save($tmbPath);

        return $tmbPath;
    }
}
