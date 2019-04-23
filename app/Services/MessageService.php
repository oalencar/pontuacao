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
use App\Models\Partner;
use function foo\func;
use Illuminate\Support\Collection;

class MessageService
{

    /**
     * @var ScoreService
     */
    private $scoreService;

    /**
     * MessageService constructor.
     * @param $scoreService ScoreService
     */
    public function __construct(ScoreService $scoreService)
    {
        $this->scoreService = $scoreService;
    }


    /**
     * @param $order Order
     * @param $orderStatus OrderStatus
     * @return string
     */
    public function getWhatsappClientMessageOrderStatusUrl($order, $orderStatus)
    {
        $clientPhoneNumber = '55' . $order->client->phone;

        $orderDescricao = $order->descricao ? '(' . $order->descricao . ')' : '';

        $messageBody = 'Olá cliente ' . $order->company->nome . ', seu pedido ' . $order->codigo . $orderDescricao . ' tem uma nova atualização de status: ' . $orderStatus->observacao . ' no dia ' . $orderStatus->data;
        $mensagem = new WhatsappMessage($messageBody, $clientPhoneNumber);
        return $mensagem->generateSendUrl();
    }


    /**
     * @param $award Award
     * @param $partner Partner
     * @return string
     */
    public function getWhatsappPartnerMessageReportAwardTotalScoreUrl($award, $partner, $totalScore, $percentual)
    {

        $user = $partner->user;

        $clientPhoneNumber = '55'.$partner->whatsapp;

        $messageBody = ' Olá, ' .$user->name.'. Sua pontuação na premiação '.$award->title.' é de '.$totalScore.' ('. $percentual .'%). Agradecemos imensamente por sua parceria!';
        $mensagem = new WhatsappMessage($messageBody, $clientPhoneNumber);
        return $mensagem->generateSendUrl();
    }

}
