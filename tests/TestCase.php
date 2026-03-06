<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase; // <--- ESTO ES VITAL

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase; // <--- ASEGÚRATE DE QUE ESTÉ AQUÍ
}