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


    /**
     * @param $order_id
     * @return Partner[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAllPartnersOfOrder($order_id)
    {
        $scores = $this->score::with('partner')->where('order_id', $order_id)->get();

        $partnersIds = $scores->unique('partner_id')->pluck('partner_id')->all();

        $partners = $this->partner::with('user')->whereIn('id', $partnersIds)->get();

        return $partners;
    }

    public function getOrderClient($order_id) {
        $order = $this->order::with('client')->find($order_id);

        return $order->client;
    }
}
