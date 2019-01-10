<?php

namespace App\Services;


use App\Partner;
use App\Order;
use App\Score;

class OrderService
{


    /**
     * OrderService constructor.
     */
    public function __construct(
        Partner $partner,
        Order $order,
        Score $score
)
    {
        $this->partner = $partner;
        $this->order = $order;
        $this->score = $score;
    }

    public function getAllPartnersOfOrder($order_id)
    {
        $scores = $this->score::with('user')->where('order_id', $order_id)->get();

        $usersIds = $scores->unique('user_id')->pluck('user_id')->all();

        $partners = $this->partner::with('user')->whereIn('user_id', $usersIds)->get();

        return $partners;
    }

    public function getOrderClient($order_id) {
        $order = $this->order::with('client')->find($order_id);

        return $order->client;
    }
}
