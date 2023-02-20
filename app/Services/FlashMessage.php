<?php

namespace App\Services;

use BadMethodCallException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Notification;

/**
 * @method success(string $message): FlashMessage
 */
class FlashMessage
{
    const TYPES = [
        'success',
        'warning',
        'error',
        'danger',
        'info',
    ];

    private string $message;
    private string $type;
    private bool $closeable;
    private FlashMessageAction|null $action = null;

    public static function make(): FlashMessage
    {
        return new self();
    }

    /**
     * Call a method from the allowed message types.
     *
     * @param string $name
     * @param array $arguments
     * @return \App\Services\FlashMessage
     */
    public function __call(string $name, array $arguments)
    {
        if (!in_array($name, self::TYPES)) {
            throw new BadMethodCallException('This message type is not allowed');
        }

        $message = new self();

        $message->setType($name);
        $message->setMessage($arguments['message']);

        return $message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * Add an action to the flash message.
     *
     * @param string $url
     * @param string $text
     * @return $this
     */
    public function action(string $url, string $text): FlashMessage
    {
        $this->action = FlashMessageAction::make(url: $url, text: $text);

        return $this;
    }

    /**
     * Mark the message as closable.
     *
     * @return \App\Services\FlashMessage
     */
    public function closeable(): FlashMessage
    {
        $this->closeable = true;

        return $this;
    }

    /**
     * Get the array representation of the class.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'body' => $this->message,
            'closeable' => $this->closeable,
            'action' => $this->action?->toArray(),
        ];
    }

    /**
     * Add the message to the request session.
     *
     * @return void
     */
    public function send(): void
    {
        request()->session()->flash('message', $this->toArray());
    }
}
