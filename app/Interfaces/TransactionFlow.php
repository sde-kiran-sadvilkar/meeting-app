<?php

namespace App\Interfaces;

interface TransactionFlow
{
    public function initiate(array $data);

    public function redirectToFateway(array $data);

    public function handleCallback(array $data);

    public function createSubscription(array $data, $transaction);

    public function updateUser(array $data, $subscription);
}
