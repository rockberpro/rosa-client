<?php

namespace Rosa\Client\Interfaces;

/**
 * @author Samuel Oberger Rockenbach
 * @version 1.0
 * @since october-2024
 */
interface RestClientInterface
{
    public function buildForGet();
    public function buildForPost();
    public function buildForPut();
    public function buildForPatch();
    public function buildForDelete();
}