<?php

namespace App\Services;

use Inertia\Inertia;
use danog\MadelineProto\Exception;

class TryCatch
{
    public static function run(callable $callback)
    {
        try {
            return $callback();
        } catch (Exception $e) {
            return back()->flashError('Произошла ошибка: ' . $e->getMessage());
        }
    }
}
