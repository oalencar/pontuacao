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
     * @param \App\Services\MailjetService $mailjetService
     * @param \App\Services\OrderService $orderService
     * @param Order $order
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

    /**
     * @param $contato Partner|Cliente
     * @return string
     */
    public function returnTypeClientOrPartner($contato)
    {
        /*  O template do mailjet está configurado para receber 'cliente' ou 'profissional'para
        renderizar as mensagens de email de acordo com o perfil do destinatário */
        if (!isset($contato->partner_type)) {
            return 'cliente';
        }
        return 'profissional';
    }


    /**
     * @param $contato Partner | Cliente
     * @param $parameter
     * @return mixed
     */
    public function getContatoParameter($contato, $parameter)
    {
        if ($this->returnTypeClientOrPartner($contato) === 'cliente') {
            return $contato->$parameter;
        }
        return $contato->user->$parameter;
    }

    /**
     * @param $order_id
     * @param $client
     * @return Partner[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getContatosDoPedido($order_id, $client)
    {
        $partnersOfOrder = $this->orderService->getAllPartnersOfOrder($order_id);
        $contatosDoPedido = $partnersOfOrder->push($client);
        return $contatosDoPedido;
    }

    /**
     * Send Order Register Email
     * @param $order_id integer
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function sendOrderRegister($order_id)
    {

        $order = $this->order->with('client')->findOrFail($order_id);

        $client = $this->orderService->getOrderClient($order->id);

        $subject = $order->company->nome. ' - Cadastro de Pedido';
        $to = $client->email;

        $cliente_display_name = $client->name;
        $cliente_display_name != '' ?: $cliente_display_name = '';

        if (!$to) {
            return "É necessário ter um cliente associado ao pedido. Verifique se o pedido foi salvo após o cliente ter sido selecionado.";
        }

        $cc = $client->email_alternative;

        $contatosDoPedido = $this->getContatosDoPedido($order->id, $client);

        foreach ($contatosDoPedido as $key => $contato) {

            $emailVars = '{
                "pedido_descricao": "' . $order->descricao . '",
                "cliente": "' . $order->client->name . '",
                "pedido_id": "' . $order->codigo . '",
                "destinatario_tipo": "' . $this->returnTypeClientOrPartner($contato) . '",
                "data_entrega" : ""
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
                            "Name" => "RelApp - Mailjet",
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
        }

        return response()->json(
            array(
                'success' => true,
                'message' => 'Email enviado com sucesso'
            ), 200);

    }


    /**
     * Send order update email
     * @param $order_id integer
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function sendOrderUpdate($order_id)
    {
        $order = $this->order->with('client')->findOrFail($order_id);
        $client = $this->orderService->getOrderClient($order_id);

        $subject = $order->company->nome . ' - Pedido #' . $order->codigo . ' atualizado';

        $to = $client->email;

        $cliente_display_name = $client->name;
        $cliente_display_name != '' ?: $cliente_display_name = '';


        if (!$to) {
            return "É necessário ter um cliente associado ao pedido. Verifique se o pedido foi salvo após o cliente ter sido selecionado.";
        }

        $cc = $client->email_alternative;

        $contatosDoPedido = $this->getContatosDoPedido($order->id, $client);

        foreach ($contatosDoPedido as $key => $contato) {

            $emailVars = '{
                "pedido_descricao": "' . $order->descricao . '",
                "cliente": "' . $order->client->name . '",
                "pedido_id": "' . $order->codigo . '",
                "destinatario_tipo": "' . $this->returnTypeClientOrPartner($contato) . '",
                "data" : "' . $order->start_date . '",
                "status" : '.json_encode($order->order_statuses).'               
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
                        'TemplateID' => 302272,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'TemplateErrorReporting' => [
                            "Name" => "RelApp - Mailjet",
                            "Email" => "oscar.apps@gmail.com"
                        ],
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

        }

        return response()->json(
            array(
                'success' => true,
                'message' => 'Email enviado com sucesso'
            ), 200);

    }

    /**
     * @param $order_id integer
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function sendOrderFinished($order_id)
    {
        $order = $this->order->with('client')->findOrFail($order_id);
        $client = $this->orderService->getOrderClient($order_id);

        $subject = $order->company->nome . ' - Pedido #' . $order->codigo . ' finalizado';

        $to = $client->email;

        $cliente_display_name = $client->name;
        $cliente_display_name != '' ?: $cliente_display_name = '';

        if (!$to) {
            return "É necessário ter um cliente associado ao pedido. Verifique se o pedido foi salvo após o cliente ter sido selecionado.";
        }

        $cc = $client->email_alternative;

        $contatosDoPedido = $this->getContatosDoPedido($order->id, $client);

        foreach ($contatosDoPedido as $key => $contato) {

            $emailVars = '{
                "pedido_descricao": "' . $order->descricao . '",
                "cliente": "' . $order->client->name . '",
                "pedido_id": "' . $order->codigo . '",
                "destinatario_tipo": "' . $this->returnTypeClientOrPartner($contato) . '",
                "data" : "' . $order->start_date . '",
                "status" : '.json_encode($order->order_statuses).'               
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
                        'TemplateID' => 149667,
                        'TemplateLanguage' => true,
                        'Subject' => $subject,
                        'TemplateErrorReporting' => [
                            "Name" => "RelApp - Mailjet",
                            "Email" => "oscar.apps@gmail.com"
                        ],
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

        }

        return response()->json(
            array(
                'success' => true,
                'message' => 'Email enviado com sucesso'
            ), 200);

    }

}
