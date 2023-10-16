<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Services\BasketService;
use Tests\TestCase;

class BasketServiceTest extends TestCase
{
    use RefreshDatabase;

    public function testTotalAmount()
    {
        // Seed products here or use database seeder.

        $basket = new BasketService();

        // Test case 1: Products B01, G01
        $basket->add('B01');
        $basket->add('G01');
        $this->assertEquals(37.85, $basket->total());

        // Reset basket for next test
        $basket = new BasketService();

        // Test case 2: Products R01, R01
        $basket->add('R01');
        $basket->add('R01');
        $this->assertEquals(54.37, $basket->total());

        // Add more test cases similarly...
    }
}

