<?php

namespace App\Model;


use Symfony\Component\HttpFoundation\File\UploadedFile;

class File
{

    protected const ALPHABET = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_';

    public function getClientExt(UploadedFile $file): string
    {
        return '-' . $file->getClientOriginalName() . $file->getClientOriginalExtension();
    }

    public function generateName(int $len = 8): string
    {
        if($len < 5)
        {
            throw new \RuntimeException('Len < 1');
        }

        $len += 2;

        $str = '';
        $alphabetLen = \strlen(self::ALPHABET) - 1;

        while ($strlen = \strlen($str) < $len)
        {
            $index = \random_int(0, $alphabetLen);
            if($strlen == 2 || $strlen == 5)
            {
                $str .= '/';
            }
            $str .= self::ALPHABET[$index];
        }

        return $str;
    }

}
