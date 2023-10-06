<?php

return [
    'plans' => [
        'basic' => [
            'trial_days' => 14,
            'price_id' => ENV('CASHIER_STRIPE_SUBSCRIPTION_BASIC_PRICE_ID'),
        ],
    ],
];
