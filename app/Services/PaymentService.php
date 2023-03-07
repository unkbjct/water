<?php

namespace App\Services;

use YooKassa\Client;

class PaymentService
{

    public function getClient(): Client
    {
        $client = new Client();
        $client->setAuth(config('services.yookassa.shop_id'), config('services.yookassa.secret_key'));

        return $client;
    }

    public function createPayment(float $price, string $description, array $options)
    {
        $client = $this->getClient();
        $payment = $client->createPayment([
            'amount' => [
                'value' => $price,
                'currency' => 'RUB'
            ],
            'confirmation' => [
                'type' => 'redirect',
                'return_url' => route('order.successful', ['transaction' => $options['transaction']]),
            ],
            'capture' => false,
            'metadata' => [
                'transaction' => $options['transaction'],
                'user' => $options['user'],
                'name' => $options['name'],
                'surname' => $options['surname'],
                'email' => $options['email'],
                'phone' => $options['phone'],
                'city' => $options['city'],
                'street' => $options['street'],
                'house' => $options['house'],
                'apart' => $options['apart'],
                'build' => $options['build'],
                'comment' => $options['comment'],
                'cart' => $options['cart'],
            ],
            'description' => $description,

        ], uniqid('', true));

        return $payment->getConfirmation()->getConfirmationUrl();
    }
}