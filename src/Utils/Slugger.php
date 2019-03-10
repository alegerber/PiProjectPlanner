<?php declare(strict_types = 1);

namespace App\Utils;

/**
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 */
class Slugger
{
    public static function slugify(string $string): string
    {
        return \preg_replace('/\s+/', '-', \mb_strtolower(\trim(\strip_tags($string)), 'UTF-8'));
    }
}
