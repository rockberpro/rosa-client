<?php

namespace Rosa\Client\Interfaces;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
interface RestClientInterface
{
    public static function buildForGet();
    public static function buildForPost();
    public static function buildForPut();
    public static function buildForPatch();
    public static function buildForDelete();
}