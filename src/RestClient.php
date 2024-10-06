<?php

namespace Rosa\Client;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
class RestClient extends AbstractRestClient
{
    public static function buildForGet()
    {
        return parent::buildForGet();
    }

    public static function buildForPost()
    {
        return parent::buildForPost();
    }

    public static function buildForPut()
    {
        return parent::buildForPut();
    }

    public static function buildForPatch()
    {
        return parent::buildForPatch();
    }

    public static function buildForDelete()
    {
        return parent::buildForDelete();
    }
}