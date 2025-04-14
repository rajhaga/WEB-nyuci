<?php

namespace App\Http\Middleware;

use Closure;
use Midtrans\Config;
use Midtrans\Notification;

class VerifyMidtransSignature
{
    public function handle($request, Closure $next)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        
        $notification = new Notification();
        $signatureKey = $notification->signature_key;
        
        if ($signatureKey != $request->header('x-midtrans-signature')) {
            abort(403, 'Invalid signature');
        }

        return $next($request);
    }
}