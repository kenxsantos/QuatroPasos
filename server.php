<?php
require 'vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class ChatServer implements MessageComponentInterface
{
    protected $clients;

    public function __construct()
    {
        $this->clients = [];

        // Initialize separate clients for admin and customer
        $this->clients['admin'] = null;
        $this->clients['customer'] = null;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $queryParams = $conn->httpRequest->getUri()->getQuery();
        parse_str($queryParams, $params);

        $role = $params['role'] ?? null;

        if ($role === 'admin' || $role === 'customer') {
            $this->clients[$role] = $conn;
            $conn->send(json_encode(['status' => 'connected', 'role' => $role]));
        } else {
            $conn->close();
        }
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $messageData = json_decode($msg, true);

        // Determine the recipient role
        $recipientRole = $messageData['to'];
        if (isset($this->clients[$recipientRole]) && $this->clients[$recipientRole] !== null) {
            $this->clients[$recipientRole]->send(json_encode([
                'from' => $messageData['from'],
                'message' => $messageData['message']
            ]));
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        foreach ($this->clients as $role => $client) {
            if ($client === $conn) {
                $this->clients[$role] = null;
                break;
            }
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        $conn->close();
    }
}

// Start the server
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new ChatServer()
        )
    ),
    8080
);

$server->run();