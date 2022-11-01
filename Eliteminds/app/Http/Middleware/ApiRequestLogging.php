<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Illuminate\Support\Str;

class ApiRequestLogging
{
    /** @var Monolog\Logger **/
    private $logger;
    public function __construct()
    {
        $this->logger = $this->getLogger();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $this->logger->info('Incoming request:');
        $url = $request->url();
        $queryString = $request->getQueryString();
        $method = $request->method();
        $ip = $request->ip();
        $headers = $this->getHeadersFromRequest();
        $body = $request->getContent();
        $methodUrlString = "$ip $method $url";
        if ($queryString) {
            $methodUrlString .= "?$queryString";
        }

        if (array_key_exists('Authorization', $headers)) {
            $headers['Authorization'] = 'xxxxxxx';
        }
        $this->logger->info($methodUrlString);
        $this->logger->info(json_encode($headers));
        $this->logger->info($body);
//        $request->hooksLogger = $this->logger;
        return $next($request);
    }
    private function getHeadersFromRequest()
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) <> 'HTTP_') {
                continue;
            }
            $header = str_replace(' ', '-', ucwords(str_replace('_', ' ', strtolower(substr($key, 5)))));
            $headers[$header] = $value;
        }
        return $headers;
    }
    public function terminate(Request $request, JsonResponse $response)
    {
        // $this->logger->info('Outgoing response:');
        // $this->logger->info($response);
    }
    private function getLogger()
    {
        $dateString = now()->format('m_d_Y');
        $filePath = 'web_hooks_' . $dateString . '.log';
        $dateFormat = "m/d/Y H:i:s";
        $output = "[%datetime%] %channel%.%level_name%: %message%\n";
        $formatter = new LineFormatter($output, $dateFormat);
        $stream = new StreamHandler(storage_path('logs/' . $filePath), Logger::DEBUG);
        $stream->setFormatter($formatter);
        $processId = Str::random(5);
        $logger = new Logger($processId);
        $logger->pushHandler($stream);

        return $logger;
    }
}