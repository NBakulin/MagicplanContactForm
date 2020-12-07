<?php
declare(strict_types=1);

namespace App\Helper;

use Cake\Log\Log;

class LogHelper
{
    private string $scope;

    public function __construct(string $scope)
    {
        $this->scope = $scope;
    }

    public function log(string $level, string $message)
    {
        Log::write($level, $message, ['scope' => $this->scope]);
    }
}
