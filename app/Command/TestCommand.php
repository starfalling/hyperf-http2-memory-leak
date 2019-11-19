<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;
use Swoole\Atomic;
use Swoole\Coroutine;

/**
 * @Command
 */
class TestCommand extends HyperfCommand
{

    protected $name = 'test';
    /** @var Atomic */
    private $counter;

    /**
     * Handle the current command.
     */
    public function handle()
    {
        $this->counter = new Atomic(0);
        for ($i = 0; $i < 100; $i++) {
            Coroutine::create(function () use ($i) {
                $req = new \Swoole\Http2\Request();
                $req->method = 'GET';
                $req->path = '/index/index';
                $req->headers = [
                    'host' => '192.168.1.222',
                    "user-agent" => 'Chrome/49.0.2587.3',
                    'accept' => 'text/html,application/xhtml+xml,application/xml',
                    'accept-encoding' => 'gzip'
                ];
                $client = new \Swoole\Coroutine\Http2\Client('127.0.0.1', 9501, false);
                $client->connect();
                while (true) {
                    $send_result = $client->send($req);
                    if ($send_result <= 0) {
                        var_dump($client->errMsg);
                        var_dump($client->errCode);
                        exit();
                    }
                    $response = $client->recv();
                    if (empty($response) || $response->data !== '{"method":"GET","message":"Hello Hyperf."}') {
                        var_dump($response);
                        exit();
                    }
                    $count = $this->counter->add(1);
                    if ($count % 1000 === 0) {
                        $this->output->writeln(date('Y-m-d H:i:s') . ' called ' . $count . ' times');
                    }
                }
                $client->close();
                unset($client);
            });
        }
    }
}
