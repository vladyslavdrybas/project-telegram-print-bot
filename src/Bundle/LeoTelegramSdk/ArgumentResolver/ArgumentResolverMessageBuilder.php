<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\ArgumentResolver;

use App\Bundle\LeoTelegramSdk\ValueObject\Chat;
use App\Bundle\LeoTelegramSdk\ValueObject\CommandMessage;
use App\Bundle\LeoTelegramSdk\ValueObject\PhotoCollection;
use App\Bundle\LeoTelegramSdk\ValueObject\Metadata;
use App\Bundle\LeoTelegramSdk\ValueObject\Photo;
use App\Bundle\LeoTelegramSdk\ValueObject\MessageBase;
use App\Bundle\LeoTelegramSdk\ValueObject\From;
use App\Bundle\LeoTelegramSdk\ValueObject\MessageInterface;
use App\Bundle\LeoTelegramSdk\ValueObject\PhotoMessage;
use App\Bundle\LeoTelegramSdk\ValueObject\TextMessage;
use DateTimeImmutable;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\HttpFoundation\Request;
use function array_key_exists;
use function json_decode;
use function str_starts_with;

class ArgumentResolverMessageBuilder implements MessageBuilderInterface
{
    protected const SDK_MESSAGE_VALUE_OBJECT_CLASS = 'sdk_message_value_object_class';
    protected const SDK_MESSAGE_VALUE_OBJECT_TYPE = 'sdk_message_value_object_TYPE';

    protected array $message;

    public function __construct(
        Request $request
    ) {
        $data = $request->toArray();
        $message = $data['message'];
        $message['update_id'] = $data['update_id'];

        $message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS] = MessageBase::class;
        $message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE] = Metadata::SKELETON_MESSAGE_TYPE;

        if (array_key_exists('photo', $message)) {
            $message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS] = PhotoMessage::class;
            $message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE] = Metadata::PHOTO_MESSAGE_TYPE;
        } elseif (array_key_exists('text', $message)
            && str_starts_with($message['text'], '/')
        ) {
            $message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS] = CommandMessage::class;
            $message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE] = Metadata::COMMAND_MESSAGE_TYPE;
        } elseif (array_key_exists('text', $message)) {
            $message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS] = TextMessage::class;
            $message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE] = Metadata::TEXT_MESSAGE_TYPE;
        }

        $this->message = $message;
    }

    public function buildMessage(): MessageInterface
    {
        return match ($this->message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS]) {
            PhotoMessage::class => $this->buildPhotoMessage(),
            CommandMessage::class => $this->buildCommandMessage(),
            TextMessage::class => $this->buildTextMessage(),
            default => $this->buildSkeleton(),
        };
    }

    public function buildSkeleton(): MessageBase
    {
        assert(array_key_exists('update_id', $this->message));
        assert(array_key_exists('message_id', $this->message));
        $updateId = $this->message['update_id'];
        $messageId = $this->message['message_id'];
        $metadata = $this->buildMetadata();
        $date = $this->buildDate();
        $from = $this->buildFrom();
        $chat = $this->buildChat();

        return new MessageBase($updateId, $messageId, $date, $from, $chat, $metadata);
    }

    protected function buildPhotoMessage(): PhotoMessage
    {
        return new PhotoMessage($this->buildSkeleton(), $this->buildPhotos());
    }

    protected function buildTextMessage(): TextMessage
    {
        assert(array_key_exists('text', $this->message));

        return new TextMessage($this->buildSkeleton(), $this->message['text']);
    }

    protected function buildCommandMessage(): CommandMessage
    {
        assert(array_key_exists('text', $this->message));

        return new CommandMessage($this->buildSkeleton(), $this->message['text']);
    }

    protected function buildFrom(): From
    {
        assert(array_key_exists('from', $this->message));

        $from = $this->message['from'];
        assert(array_key_exists('id', $from));
        assert(array_key_exists('is_bot', $from));
        assert(array_key_exists('first_name', $from));
        assert(array_key_exists('last_name', $from));
        assert(array_key_exists('username', $from));
        assert(array_key_exists('language_code', $from));

        return new From(
            $from['id'],
            $from['is_bot'],
            $from['first_name'],
            $from['last_name'],
            $from['username'],
            $from['language_code']
        );
    }

    protected function buildChat(): Chat
    {
        assert(array_key_exists('chat', $this->message));

        $chat = $this->message['chat'];
        assert(array_key_exists('id', $chat));
        assert(array_key_exists('first_name', $chat));
        assert(array_key_exists('last_name', $chat));
        assert(array_key_exists('username', $chat));
        assert(array_key_exists('type', $chat));

        return new Chat(
            $chat['id'],
            $chat['first_name'],
            $chat['last_name'],
            $chat['username'],
            $chat['type']
        );
    }

    protected function buildDate(): DateTimeImmutable
    {
        assert(array_key_exists('date', $this->message));
        $date = new DateTimeImmutable();

        return $date->setTimestamp($this->message['date']);
    }

    protected function buildPhotos(): PhotoCollection
    {
        assert(array_key_exists('photo', $this->message));
        //@todo test assertions with empty caption
//        assert(array_key_exists('caption', $this->message));

        $photos = new PhotoCollection();
        $caption = $this->message['caption'] ?? '';

        foreach ($this->message['photo'] as $photo)
        {
            assert(array_key_exists('file_id', $photo));
            assert(array_key_exists('file_unique_id', $photo));
            assert(array_key_exists('width', $photo));
            assert(array_key_exists('height', $photo));

            $fileId = $photo['file_id'];
            $fileUniqueId = $photo['file_unique_id'];
            $width = $photo['width'];
            $height = $photo['height'];
            $photos->append(new Photo($fileId, $fileUniqueId, $width, $height, $caption));
        }

        return $photos;
    }

    #[Pure] protected function buildMetadata(): Metadata
    {
        return new Metadata(
            $this->message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS],
            $this->message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE]
        );
    }
}
