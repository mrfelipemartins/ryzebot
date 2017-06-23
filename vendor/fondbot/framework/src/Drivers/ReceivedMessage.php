<?php

declare(strict_types=1);

namespace FondBot\Drivers;

use FondBot\Templates\Location;
use FondBot\Templates\Attachment;

interface ReceivedMessage
{
    /**
     * Get text.
     *
     * @return string|null
     */
    public function getText(): ?string;

    /**
     * Get location.
     *
     * @return Location|null
     */
    public function getLocation(): ?Location;

    /**
     * Determine if message has attachment.
     *
     * @return bool
     */
    public function hasAttachment(): bool;

    /**
     * Get attachment.
     *
     * @return Attachment|null
     */
    public function getAttachment(): ?Attachment;

    /**
     * Determine if message has payload.
     *
     * @return bool
     */
    public function hasData(): bool;

    /**
     * Get payload.
     *
     * @return string|null
     */
    public function getData(): ?string;
}
