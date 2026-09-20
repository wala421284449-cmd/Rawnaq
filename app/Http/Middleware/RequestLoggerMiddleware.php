<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RequestLoggerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. تسجيل وقت بداية الطلب بدقة بالميلي ثانية
        $startTime = microtime(true);

        // 2. تمرير الطلب لإكمال دورة حياته ومعالجته
        $response = $next($request);

        // 3. حساب وقت الاستغراق (Execution Time) بالميلي ثانية
        $endTime = microtime(true);
        $executionTime = round(($endTime - $startTime) * 1000, 2);

        // 4. تسجيل البيانات تلقائياً في السجلات كـ INFO
        Log::info('متجر رونق: تتبع تلقائي للطلب (Request Log)', [
            'method'         => $request->method(),
            'url'            => $request->fullUrl(),
            'ip'             => $request->ip(),
            'user_id'        => auth()->id() ?? 'زائر / غير مسجل',
            'execution_time' => $executionTime . ' ms',
        ]);

        return $response;
    }
}
