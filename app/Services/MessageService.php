<?php
/**
 * Created by PhpStorm.
 * User: oscaralencar
 * Date: 2019-04-22
 * Time: 19:10
 */

namespace App\Services;


use App\Classes\WhatsappMessage;
use App\Models\Order;
use App\Models\OrderStatus;

class MessageService
{
    /**
     * @param $order Order
     * @param $orderStatus OrderStatus
     * @return string
     */
    public function getWhatsappClientMessageOrderStatusUrl($order, $orderStatus)
    {
        $clientPhoneNumber = '55'.$order->client->phone;

        $orderDescricao = $order->descricao ? '('.$order->descricao.')' : '';

        $messageBody = 'Olá cliente '.$order->company->nome.', seu pedido '.$order->codigo.$orderDescricao.' tem uma nova atualização de status: '.$orderStatus->observacao.' no dia '.$orderStatus->data ;
        $mensagem = new WhatsappMessage($messageBody, $clientPhoneNumber);
        return $mensagem->generateSendUrl();
    }
}
