<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MockService
{
    private Client $client;

    /**
     * @throws GuzzleException
     */
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://run.mocky.io'
        ]);
    }

    public function authorizeTransaction(): array //  autorizar transação
    {
        $uri = '/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';
        try {
            $response = $this->client->request( 'GET', $uri);
            return json_decode($response->getBody(), true);
        }catch (GuzzleException $exception) {
            return ['message' => 'Não Autorizado'];
        }

    }

    public function notifyUser(string $fakeUserId): array // notificar o usuário
    {
        // Sinceramente vc nao precisa fazer nada com esse Id mas ta ali
        // pq se precisasse memo vc teria que ter
        $uri = 'https://o4d9z.mocklab.io/notify';
        try {
            $response = $this->client->request('GET', $uri);

            return json_decode($response->getBody(), true);
        } catch (GuzzleException $exception) {
            return ['deu beyblade'];
        }

    }
}