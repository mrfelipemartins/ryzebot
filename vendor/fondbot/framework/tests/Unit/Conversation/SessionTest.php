<?php

declare(strict_types=1);

namespace FondBot\Tests\Unit\Conversation;

use FondBot\Drivers\Chat;
use FondBot\Drivers\User;
use FondBot\Tests\TestCase;
use FondBot\Channels\Channel;
use FondBot\Conversation\Intent;
use FondBot\Conversation\Session;
use FondBot\Drivers\ReceivedMessage;
use FondBot\Conversation\Interaction;

/**
 * @property mixed|\Mockery\Mock|\Mockery\MockInterface $channel
 * @property mixed|\Mockery\Mock|\Mockery\MockInterface $chat
 * @property mixed|\Mockery\Mock|\Mockery\MockInterface $sender
 * @property mixed|\Mockery\Mock|\Mockery\MockInterface $message
 * @property mixed|\Mockery\Mock|\Mockery\MockInterface $intent
 * @property mixed|\Mockery\Mock|\Mockery\MockInterface $interaction
 * @property array                                      $context
 * @property Session                                    $session
 */
class SessionTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->channel = $this->mock(Channel::class);
        $this->chat = $this->mock(Chat::class);
        $this->sender = $this->mock(User::class);
        $this->message = $this->mock(ReceivedMessage::class);
        $this->intent = $this->mock(Intent::class);
        $this->interaction = $this->mock(Interaction::class);
        $this->context = [
            'foo' => $this->faker()->sha1,
            'bar' => $this->faker()->sha1,
        ];

        $this->session = new Session(
            $this->channel,
            $this->chat,
            $this->sender,
            $this->message,
            $this->intent,
            $this->interaction,
            $this->context
        );
    }

    public function test_getChannel(): void
    {
        $this->assertSame($this->channel, $this->session->getChannel());
    }

    public function test_getChat(): void
    {
        $this->assertSame($this->chat, $this->session->getChat());
    }

    public function test_getSender(): void
    {
        $this->assertSame($this->sender, $this->session->getUser());
    }

    public function test_getMessage(): void
    {
        $this->assertSame($this->message, $this->session->getMessage());
    }

    public function test_intent(): void
    {
        $this->assertSame($this->intent, $this->session->getIntent());

        $intent = $this->mock(Intent::class);

        $this->session->setIntent($intent);
        $this->assertSame($intent, $this->session->getIntent());
        $this->assertNotSame($this->intent, $this->session->getIntent());
    }

    public function test_interaction(): void
    {
        $this->assertSame($this->interaction, $this->session->getInteraction());

        $interaction = $this->mock(Interaction::class);

        $this->session->setInteraction($interaction);
        $this->assertSame($interaction, $this->session->getInteraction());
        $this->assertNotSame($this->interaction, $this->session->getInteraction());
    }

    public function test_context(): void
    {
        $this->assertSame($this->context, $this->session->getContext());

        $values = [
            'name' => $this->faker()->name,
            'phone' => $this->faker()->phoneNumber,
        ];

        $this->session->setContext($values);
        $this->assertSame($values, $this->session->getContext());
        $this->assertNotSame($this->context, $this->session->getContext());

        $this->session->setContextValue('uuid', $uuid = $this->faker()->uuid);
        $values['uuid'] = $uuid;
        $this->assertSame($values, $this->session->getContext());
    }

    public function test_toArray(): void
    {
        $expected = [
            'intent' => get_class($this->intent),
            'interaction' => get_class($this->interaction),
            'context' => $this->context,
        ];

        $this->assertSame($expected, $this->session->toArray());
    }
}
