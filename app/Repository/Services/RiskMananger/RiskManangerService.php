<?php

namespace App\Repository\Services\RiskMananger;

use App\Models\RiskManager\RiskManager;
use App\Repository\Services\RiskMananger\Guep\GuepService;
use App\Repository\Services\Telerisco\TeleriscoService;

class RiskManangerService
{
    public static $instance;

    public static function getDefaultRiskMananger()
    {
        if (!isset(self::$instance)) {
            $riskManager = RiskManager::where('default', true)->first();

            $riskManagerClass = $riskManager->model_name;

            $riskManangerService = self::register()[$riskManagerClass];

            self::$instance = new $riskManangerService();
        }

        return self::$instance;
    }

    private static function register()
    {
        return [
            'GuepService'      => GuepService::class,
            'TeleriscoService' => TeleriscoService::class,
        ];
    }
}
