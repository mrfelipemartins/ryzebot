<?php

declare(strict_types=1);

namespace FondBot\Channels;

use FondBot\Channels\Exceptions\ChannelNotFound;

class ChannelManager
{
    /** @var array */
    private $channels;

    /**
     * Add channel.
     *
     * @param string $name
     * @param array  $parameters
     */
    public function add(string $name, array $parameters): void
    {
        $this->channels[$name] = $parameters;
    }

    /**
     * Get all channels.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->channels;
    }

    /**
     * Create channel.
     *
     * @param string $name
     *
     * @return Channel
     * @throws ChannelNotFound
     */
    public function create(string $name): Channel
    {
        if (!isset($this->channels[$name])) {
            throw new ChannelNotFound('Channel `'.$name.'` not found.');
        }

        $data = collect($this->channels[$name]);

        $driver = $data->get('driver');
        $parameters = $data->except('driver')->toArray();

        return new Channel($name, $driver, $parameters);
    }
}
