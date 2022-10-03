<?php
declare(strict_types = 1);

namespace MCarpinter\RethinkDb\Connection;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use MCarpinter\RethinkDb\Connection\Socket\Socket;
use MCarpinter\RethinkDb\Connection\Socket\Handshake;
use MCarpinter\RethinkDb\Serializer\QueryNormalizer;
use MCarpinter\RethinkDb\Types\VersionDummy\Version;

class Registry implements RegistryInterface
{
    /**
     * @var ConnectionInterface[]
     */
    private $connections;

    /**
     * @throws ConnectionException
     */
    public function __construct(array $connections = null)
    {
        if ($connections) {
            foreach ($connections as $name => $options) {
                if (!$options instanceof OptionsInterface) {
                    //TODO: Log error if options is not instanceOf
                    continue;
                }

                $this->addConnection($name, $options);
            }
        }
    }

    /**
     * @throws ConnectionException
     */
    public function addConnection(string $name, OptionsInterface $options): bool
    {
        if ($this->hasConnection($name)) {
            throw new ConnectionException("The connection {$name} has already been added.", 400);
        }

        // TODO: Create factory for instantiation Connection.
        $this->connections[$name] = new Connection(
            function () use ($options) {
                return new Socket(
                    $options
                );
            },
            new Handshake($options->getUser(), $options->getPassword(), Version::V1_0),
            $options->getDbName(),
            new Serializer(
                [new QueryNormalizer()],
                [new JsonEncoder()]
            ),
            new Serializer(
                [new ObjectNormalizer()],
                [new JsonEncoder()]
            )
        );

        return true;
    }

    public function hasConnection(string $name): bool
    {
        return isset($this->connections[$name]);
    }

    /**
     * @throws ConnectionException
     */
    public function getConnection(string $name): ConnectionInterface
    {
        if (!$this->hasConnection($name) || !$this->connections[$name]) {
            throw new ConnectionException("The connection {$name} does not exist.", 400);
        }

        return $this->connections[$name];
    }
}
