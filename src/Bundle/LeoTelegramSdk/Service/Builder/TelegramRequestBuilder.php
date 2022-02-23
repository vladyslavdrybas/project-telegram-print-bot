<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Service\Builder;

use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Chat;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\CommandRequest;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\From;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\RequestBase;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\RequestInterface;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Metadata;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Photo;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\PhotoCollection;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\PhotoRequest;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Sticker;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\StickerRequest;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\TextRequest;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Thumb;
use DateTimeImmutable;
use Symfony\Component\HttpFoundation\Request;
use function array_key_exists;
use function assert;
use function str_starts_with;

class TelegramRequestBuilder implements MessageBuilderInterface
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

        $message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS] = RequestBase::class;
        $message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE] = Metadata::BASE_MESSAGE_TYPE;

        if (array_key_exists('photo', $message)) {
            $message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS] = PhotoRequest::class;
            $message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE] = Metadata::PHOTO_MESSAGE_TYPE;
        } elseif (array_key_exists('sticker', $message)) {
            $message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS] = StickerRequest::class;
            $message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE] = Metadata::STICKER_MESSAGE_TYPE;
        } elseif (array_key_exists('text', $message)
            && str_starts_with($message['text'], '/')
        ) {
            $message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS] = CommandRequest::class;
            $message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE] = Metadata::COMMAND_MESSAGE_TYPE;
        } elseif (array_key_exists('text', $message)) {
            $message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS] = TextRequest::class;
            $message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE] = Metadata::TEXT_MESSAGE_TYPE;
        }

        $this->message = $message;
    }

    public function build(): RequestInterface
    {
        return match ($this->message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS]) {
            PhotoRequest::class => $this->buildPhotoMessage(),
            CommandRequest::class => $this->buildCommandMessage(),
            TextRequest::class => $this->buildTextMessage(),
            StickerRequest::class => $this->buildStickerMessage(),
            default => $this->buildBaseMessage(),
        };
    }

    public function buildBaseMessage(): RequestBase
    {
        assert(array_key_exists('update_id', $this->message));
        assert(array_key_exists('message_id', $this->message));
        $updateId = $this->message['update_id'];
        $messageId = $this->message['message_id'];
        $metadata = $this->buildMetadata();
        $date = $this->buildDate();
        $from = $this->buildFrom();
        $chat = $this->buildChat();

        return new RequestBase($updateId, $messageId, $date, $from, $chat, $metadata);
    }

    protected function buildPhotoMessage(): PhotoRequest
    {
        return new PhotoRequest($this->buildBaseMessage(), $this->buildPhotos());
    }

    protected function buildStickerMessage(): StickerRequest
    {
        return new StickerRequest($this->buildBaseMessage(), $this->buildSticker());
    }

    protected function buildTextMessage(): TextRequest
    {
        assert(array_key_exists('text', $this->message));

        return new TextRequest($this->buildBaseMessage(), $this->message['text']);
    }

    protected function buildCommandMessage(): CommandRequest
    {
        assert(array_key_exists('text', $this->message));

        return new CommandRequest($this->buildBaseMessage(), $this->message['text']);
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

    protected function buildSticker(): Sticker
    {
        assert(array_key_exists('sticker', $this->message));

        $sticker = $this->message['sticker'];
        assert(array_key_exists('file_id', $sticker));
        assert(array_key_exists('file_unique_id', $sticker));
        assert(array_key_exists('width', $sticker));
        assert(array_key_exists('height', $sticker));
        assert(array_key_exists('file_size', $sticker));
        assert(array_key_exists('emoji', $sticker));
        assert(array_key_exists('set_name', $sticker));
        assert(array_key_exists('is_animated', $sticker));
        assert(array_key_exists('is_video', $sticker));
        assert(array_key_exists('thumb', $sticker));

        $thumbMeta = $sticker['thumb'];
        assert(array_key_exists('file_id', $thumbMeta));
        assert(array_key_exists('file_unique_id', $thumbMeta));
        assert(array_key_exists('width', $thumbMeta));
        assert(array_key_exists('height', $thumbMeta));
        assert(array_key_exists('file_size', $thumbMeta));

        $thumb = new Thumb(
            $thumbMeta['file_id'],
            $thumbMeta['file_unique_id'],
            $thumbMeta['width'],
            $thumbMeta['height'],
            $thumbMeta['file_size']
        );

        return new Sticker(
            $sticker['file_id'],
            $sticker['file_unique_id'],
            $sticker['width'],
            $sticker['height'],
            $sticker['file_size'],
            $sticker['emoji'],
            $sticker['set_name'],
            $sticker['is_animated'],
            $sticker['is_video'],
            $thumb
        );
    }

    protected function buildMetadata(): Metadata
    {
        return new Metadata(
            $this->message[static::SDK_MESSAGE_VALUE_OBJECT_CLASS],
            $this->message[static::SDK_MESSAGE_VALUE_OBJECT_TYPE]
        );
    }
}
