<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Service\Builder;

use App\Bundle\LeoTelegramSdk\Entity\Account;
use App\Bundle\LeoTelegramSdk\Entity\Photo;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\Photo as PhotoValueObject;
use App\Bundle\LeoTelegramSdk\ValueObject\TelegramRequest\PhotoRequest;

class PhotoBuilder
{
    public function build(
        PhotoRequest     $photoMessage,
        PhotoValueObject $photoValueObject,
        Account          $telegramAccount
    ): Photo {
        $telegramPhoto = new Photo();
        $telegramPhoto->setMessageId($photoMessage->getMessageId());
        $telegramPhoto->setDate($photoMessage->getDate());
        $telegramPhoto->setChatId($photoMessage->getChat()->getId());
        $telegramPhoto->setChatType($photoMessage->getChat()->getType());
        $telegramPhoto->setFileId($photoValueObject->getFileId());
        $telegramPhoto->setFileUniqueId($photoValueObject->getFileUniqueId());
        $telegramPhoto->setCaption($photoValueObject->getCaption());
        $telegramPhoto->setWidth($photoValueObject->getWidth());
        $telegramPhoto->setHeight($photoValueObject->getHeight());
        $telegramPhoto->setUpdateId($photoMessage->getUpdateId());
        $telegramPhoto->setTelegramAccount($telegramAccount);

        return $telegramPhoto;
    }
}
