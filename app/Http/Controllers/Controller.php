<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function saveLog(string $content, int $user_id)
    {
        $log = new Log();
        $log->content = $content;
        $log->user_id = $user_id;
        $log->save();
    }
}
