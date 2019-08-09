<?php declare(strict_types=1);

use App\Kernel;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ServerRequestInterface;
use React\Http\Server;
use Symfony\Bridge\PsrHttpMessage\Factory\HttpFoundationFactory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\Debug\Debug;
use Symfony\Component\HttpFoundation\Request;

require __DIR__ . '/vendor/autoload.php';

$loop = React\EventLoop\Factory::create();

$httpFoundationFactory = new HttpFoundationFactory();

$psr17Factory = new Psr17Factory();
$psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);

if (getenv('APP_DEBUG')) {
    umask(0000);

    Debug::enable();
}

if ($trustedProxies = getenv('TRUSTED_PROXIES') ?? false) {
    Request::setTrustedProxies(explode(',', $trustedProxies), Request::HEADER_X_FORWARDED_ALL ^ Request::HEADER_X_FORWARDED_HOST);
}

if ($trustedHosts = getenv('TRUSTED_HOSTS') ?? false) {
    Request::setTrustedHosts([$trustedHosts]);
}

$server = new Server(function (ServerRequestInterface $psrRequest)
    use($httpFoundationFactory, $psrHttpFactory) {

    $kernel = new Kernel(getenv('APP_ENV'), (bool) getenv('APP_DEBUG'));
    $request = $httpFoundationFactory->createRequest($psrRequest);
    $response = $kernel->handle($request);
    $kernel->terminate($request, $response);

    $kernel->shutdown();

    unset($kernel);

    return $psrHttpFactory->createResponse($response);
});

$server->on('error', function (\Throwable $e) {
   echo 'Error: ' . $e->getMessage() . PHP_EOL;
});

$port = getenv('PORT');
$port = empty($port) ? 8080 : (int) $port;
echo sprintf('Starting server on 0.0.0.0:%1$d', $port);

$socket = new React\Socket\Server(sprintf('0.0.0.0:%1$d', $port), $loop);
$server->listen($socket);

$loop->run();