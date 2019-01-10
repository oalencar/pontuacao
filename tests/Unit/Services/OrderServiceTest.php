<?php

namespace Tests\Unit;

use App\Services\OrderService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderServiceTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testGetAllPartnersOfOrder()
    {
        $partner = $this->app->make('App\Partner');
        $order = $this->app->make('App\Order');
        $score = $this->app->make('App\Score');

        $orderService = new OrderService($partner, $order, $score);

        $res = $orderService->getAllPartnersOfOrder(23);

    }
}
