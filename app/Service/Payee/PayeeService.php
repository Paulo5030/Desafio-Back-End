<?php

namespace App\Service\Payee;

use App\Exceptions\NotFoundException;
use App\Traits\ValidateProviderTrait;

class PayeeService
{
    use ValidateProviderTrait;

    /**
     * @throws NotFoundException
     */
    public function checkBeneficiary(array $data)
    {
        if (!$this->retrievePayee($data)) {
            throw new NotFoundException('User Not Found');
        }
        return $this->retrievePayee($data);
    }

    private function retrievePayee(array $data) // recuperar Beneficiário
    {
        try {
            $model = $this->getProvider($data['provider']);
            return $model->find($data['payee_id']);
        } catch (NotFoundException | \Exception $e) {
            return false;
        }
    }
}
