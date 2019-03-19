<?php

namespace App\Services;

use App\Cliente;
use App\Order;
use App\Partner;
use App\Services\MailjetService;
use Illuminate\Http\Response;
use Mailjet\Resources;
use App\Services\OrderService;

/**
 * Class EmailMarketingService
 * @package App\Services
 */
class EmailMarketingService
{

    /**
     * @var MailjetService
     */
    private $mailService;

    /**
     * @var Order
     */
    private $order;
    /**
     * @var \App\Services\OrderService
     */
    private $orderService;

    /**
     * EmailMarketingService constructor.
     * @param $mailjet MailJet
     */
    public function __construct(
        MailjetService $mailjetService,
        OrderService $orderService,
        Order $order
    )
    {
        $this->mailService = $mailjetService;
        $this->orderService = $orderService;
        $this->order = $order;
    }

    public function sendTest()
    {

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
     * @param $contato Partner|Cliente
     * @return string
     */
    public function returnTypeClientOrPartner($contato)
    {
        /*  O template do mailjet está configurado para receber 'cliente' ou 'profissional'para
        renderizar as mensagens de email de acordo com o perfil do destinatário */
        if (!$contato->partner_type) {
            return 'cliente';
        }
        return 'profissional';
    }

    public function getContatoParameter($contato, $parameter)
    {
        if ($this->returnTypeClientOrPartner($contato) === 'cliente') {
            return $contato[$parameter];
        }
        return $contato->user[$parameter];
    }

    /**
     * Send Order Register Email
     * @param $order_id int
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendOrderRegister($order_id)
    {

        $order = $this->order->with('client')->findOrFail($order_id);

        $client = $this->orderService->getOrderClient($order_id);

        $subject = 'Celmar Belém - Cadastro de Pedido';
        $to = $client->email;


        $cliente_display_name = $client->name;
        $cliente_display_name != '' ?: $cliente_display_name = '';

        $cc = $client->email_alternative;

        $partnersOfOrder = $this->orderService->getAllPartnersOfOrder($order_id)->toArray();
        array_unshift($partnersOfOrder, $client);
        $contatosDoPedido = $partnersOfOrder;

        $pedido = $order;


        foreach ($contatosDoPedido as $key => $contato) {

            $emailVars = '{
                "pedido_descricao": "' . $order->descricao . '",
                "cliente": "' . $order->client->name . '",
                "pedido_id": "' . $order->codigo . '",
                "destinatario_tipo": "' . $this->returnTypeClientOrPartner($contato) . '",
                "data_entrega" : "' . $order->start_date . '"
            }';


            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "contato@celmarbelem.com.br",
                            'Name' => "Celmar Belém"
                        ],
                        'To' => [
                            [
                                'Email' => $this->getContatoParameter($contato, 'email'),
                                'Name' => $this->getContatoParameter($contato, 'name')
                            ]
                        ],
                        'TemplateID' => 149737,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'TemplateErrorReporting' => [
                            "Name" => "Celmar - Mailjet",
                            "Email" => "oscar.apps@gmail.com"
                        ],
                        'TemplateErrorDeliver' => true,
                        'Variables' => json_decode($emailVars, true)
                    ]
                ]
            ];

            $response = $this->mailService->getClient()->post(Resources::$Email, ['body' => $body]);

            if (!$response->success()) {
                return response()->json(
                    array(
                        'success' => false,
                        'message' => $response->getReasonPhrase()
                    ), $response->getStatus());
            }
            return response()->json(
                array(
                    'success' => true,
                    'message' => $response->getBody()
                ), $response->getStatus());
        }
    }


    public function sendOrderUpdate($order_id)
    {
        $order = $this->order->with('client')->findOrFail($order_id);
        $client = $this->orderService->getOrderClient($order_id);

        $subject = 'Celmar Belém - Pedido #' . $order->codigo . ' atualizado';

        $to = $client->email;

        $cliente_display_name = $client->name;
        $cliente_display_name != '' ?: $cliente_display_name = '';


        if (!$to) {
            return "É necessário ter um cliente associado ao pedido. Verifique se o pedido foi salvo após o cliente ter sido selecionado.";
        }

        $cc = $client->email_alternative;

        $contatosDoPedido = $this->orderService->getAllPartnersOfOrder($order_id);


        $pedido = $order;


        foreach ($contatosDoPedido as $key => $contato) {

            $emailVars = '{
                "pedido_descricao": "' . $order->descricao . '",
                "cliente": "' . $order->client->name . '",
                "pedido_id": "' . $order->codigo . '",
                "destinatario_tipo": "' . $order->codigo . '",
                "data_entrega" : "' . $order->start_date . '"
            }';

//            '{
//                        "pedido_descricao": "'.$fields['descricao']['value'].'",
//                        "cliente": "'.$cliente_display_name.'",
//                        "pedido_id": "'.get_the_title($post_id).'",
//                        "destinatario_tipo": "'.$key.'",
//                        "status" : '.json_encode($pedido['status']).',
//                        "data": '.json_encode($pedido['data']).'
//                    }'

            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "contato@celmarbelem.com.br",
                            'Name' => "Celmar Belém"
                        ],
                        'To' => [
                            [
                                'Email' => $contato->user->email,
                                'Name' => $contato->user->name
                            ]
                        ],
                        'TemplateID' => 302272,
                        'TemplateLanguage' => true,
                        'Subject' => "Atualização de status do seu pedido na Celmar",
                        'TemplateErrorReporting' => [
                            "Name" => "Celmar - Mailjet",
                            "Email" => "oscar.apps@gmail.com"
                        ],
                        'Variables' => json_decode($emailVars, true)
                    ]
                ]
            ];

            $response1 = $mj1->post(Resources::$Email, ['body' => $body]);

            if ($response1->success() == true) {
                $statusMensagemRetorno[] = $key . ' [ ' . $contato . ' ] Email enviado com sucesso';
            } else {
                $statusMensagemRetorno[] = $response1->getData();
            }

        }

        foreach ($statusMensagemRetorno as $m) {
            echo $m;
        };

    }

}
