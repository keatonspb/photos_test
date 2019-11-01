<?php
namespace app\schema;

class Types
{
    private static $query;
    private static $photo;

    public static function query()
    {
        return self::$query ?: (self::$query = new QueryType());
    }

    public static function photo()
    {
        return self::$photo ?: (self::$photo = new PhotoType());
    }
}
