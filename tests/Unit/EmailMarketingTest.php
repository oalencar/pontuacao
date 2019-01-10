<?php

namespace Tests\Unit;

use App\Services\EmailMarketing;
use App\Services\MailjetService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailMarketingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testSendTest()
    {
        $mailjetService = $this->app->make('App\Services\MailjetService');
        $orderService = $this->app->make('App\Services\OrderService');
        $order = $this->app->make('App\Order');
        $emailMkt = new EmailMarketing($mailjetService, $orderService, $order);
        $res = $emailMkt->sendTest();
        $this->assertTrue($res);
    }
}
