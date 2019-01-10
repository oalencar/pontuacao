<?php

namespace App\Services;

use App\Order;
use Mailjet\Resources;
use App\Services\OrderService;

/**
 * Class EmailMarketing
 * @package App\Services
 */
class EmailMarketing
{

    /**
     * @var MailjetService
     */
    private $mailService;

    /**
     * EmailMarketing constructor.
     * @param $mailjet MailJet
     */
    public function __construct(
        MailjetService $mailjetService,
        OrderService $orderService,
        Order $order
    ) {
        $this->mailService = $mailjetService;
        $this->orderService = $orderService;
        $this->order = $order;
    }

    public function sendTest() {

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "contato@celmarbelem.com.br",
                        'Name' => "Mailjet Pilot"
                    ],
                    'To' => [
                        [
                            'Email' => "oscar.alencar@gmail.com",
                            'Name' => "passenger 1"
                        ]
                    ],
                    'Subject' => "Your email flight plan!",
                    'TextPart' => "Dear passenger 1, welcome to Mailjet! May the delivery force be with you!",
                    'HTMLPart' => "<h3>Dear passenger 1, welcome to Mailjet!</h3><br />May the delivery force be with you!"
                ]
            ]
        ];
        $response = $this->mailService->getClient()->post(Resources::$Email, ['body' => $body]);
        return $response->success();
    }


    /**
     * ENVIO DE EMAIL BOTÃO CADASTRO PEDIDO
     */

    public function sendOrderRegister($order_id)
    {

        $order = $this->order->findOrFail($order_id);

        $client = $this->orderService->getOrderClient($order_id);

        $subject = 'Celmar Belém - Cadastro de Pedido';
        $to = $client->email;


        $cliente_display_name = $client->name;
        $cliente_display_name != '' ? : $cliente_display_name = '';

        $cc = $client->email_alternative;

        $contatosDoPedido = $this->orderService->getAllPartnersOfOrder($order_id);

        $pedido = $order;


//        foreach ($contatosDoPedido as $key => $contato) {
//            $body = [
//                'Messages' => [
//                    [
//                        'From' => [
//                            'Email' => "contato@celmarbelem.com.br",
//                            'Name' => "Celmar Belém"
//                        ],
//                        'To' => [
//                            [
//                                'Email' => $contato->user->email,
//                                'Name' => $contato->user->name
//                            ]
//                        ],
//                        'TemplateID' => 149737,
//                        'TemplateLanguage' => true,
//                        'Subject' => $subject,
//                        'TemplateErrorReporting' => [
//                            "Name" => "Celmar - Mailjet",
//                            "Email" => "oscar.alencar@gmail.com"
//                        ],
//                        'TemplateErrorDeliver' => true,
//                        'Variables' => json_decode('{
//                        "pedido_descricao": "'.$order->descricao.'",
//                        "cliente": "'.$client->name.'",
//                        "pedido_id": "'.$order->codigo.'",
//                        "destinatario_tipo": "'.$order->codigo.'",
//                        "data_entrega" : "'.$order->start_date.'"
//                    }', true)
//                    ]
//                ]
//            ];
//
//            $response = $this->mailService->getClient()->post(Resources::$Email, ['body' => $body]);
//
//            if ($response->success() == true) {
//                $statusMensagemRetorno[] = $key.' [ '.$contato.' ] Email enviado com sucesso';
//            } else {
//                $statusMensagemRetorno[] = $response->getData();
//            }
//
//            foreach($statusMensagemRetorno as $m) {
//                echo $m;
//            };
//
//        }

        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "contato@celmarbelem.com.br",
                        'Name' => "Mailjet Pilot"
                    ],
                    'To' => [
                        [
                            'Email' => "oscar.alencar@gmail.com",
                            'Name' => "passenger 1"
                        ]
                    ],
                    'Subject' => "Your email flight plan!",
                    'TextPart' => "Dear passenger 1, welcome to Mailjet! May the delivery force be with you!",
                    'HTMLPart' => "<h3>Dear passenger 1, welcome to Mailjet!</h3><br />May the delivery force be with you!"
                ]
            ]
        ];
        $response = $this->mailService->getClient()->post(Resources::$Email, ['body' => $body]);
        return $response->success();


    }
}
