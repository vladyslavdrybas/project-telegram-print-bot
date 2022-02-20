<?php

declare(strict_types=1);

namespace App\Bundle\LeoTelegramSdk\Entity;

use App\Library\Entity\AbstractEntity;
use App\Bundle\LeoTelegramSdk\Repository\PhotoRepository;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 * @ORM\Table(name="telegram_photo")
 */
class Photo extends AbstractEntity
{
    /**
     * @ORM\Column(type="integer")
     */
    protected int $chatId;
    /**
     * @ORM\Column(type="string")
     */
    protected string $chatType;
    /**
     * @ORM\Column(type="integer")
     */
    protected int $messageId;
    /**
     * @ORM\Column(type="integer")
     */
    protected int $updateId;
    /**
     * @ORM\Column(type="datetime_immutable")
     */
    protected DateTimeImmutable $date;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $fileId;
    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected string $fileUniqueId;
    /**
     * @ORM\Column(type="string")
     */
    protected string $caption;
    /**
     * @ORM\Column(type="integer")
     */
    protected int $width;
    /**
     * @ORM\Column(type="integer")
     */
    protected int $height;
    /**
     * @ORM\Column(type="blob")
     */
    protected string $content='';
    /**
     * Many photos have one telegram account. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Account", inversedBy="telegramPhotos", cascade={"persist"})
     * @ORM\JoinColumn(name="telegram_account_id", referencedColumnName="id")
     */
    protected Account $telegramAccount;

    /**
     * @return int
     */
    public function getChatId(): int
    {
        return $this->chatId;
    }

    /**
     * @param int $chatId
     */
    public function setChatId(int $chatId): void
    {
        $this->chatId = $chatId;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * @param int $messageId
     */
    public function setMessageId(int $messageId): void
    {
        $this->messageId = $messageId;
    }

    /**
     * @return string
     */
    public function getFileId(): string
    {
        return $this->fileId;
    }

    /**
     * @param string $fileId
     */
    public function setFileId(string $fileId): void
    {
        $this->fileId = $fileId;
    }

    /**
     * @return string
     */
    public function getFileUniqueId(): string
    {
        return $this->fileUniqueId;
    }

    /**
     * @param string $fileUniqueId
     */
    public function setFileUniqueId(string $fileUniqueId): void
    {
        $this->fileUniqueId = $fileUniqueId;
    }

    /**
     * @return \App\Bundle\LeoTelegramSdk\Entity\Account
     */
    public function getTelegramAccount(): Account
    {
        return $this->telegramAccount;
    }

    /**
     * @param \App\Bundle\LeoTelegramSdk\Entity\Account $telegramAccount
     */
    public function setTelegramAccount(Account $telegramAccount): void
    {
        $this->telegramAccount = $telegramAccount;
    }

    /**
     * @return string
     */
    public function getChatType(): string
    {
        return $this->chatType;
    }

    /**
     * @param string $chatType
     */
    public function setChatType(string $chatType): void
    {
        $this->chatType = $chatType;
    }

    /**
     * @return string
     */
    public function getCaption(): string
    {
        return $this->caption;
    }

    /**
     * @param string $caption
     */
    public function setCaption(string $caption): void
    {
        $this->caption = $caption;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth(int $width): void
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight(int $height): void
    {
        $this->height = $height;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getUpdateId(): int
    {
        return $this->updateId;
    }

    /**
     * @param int $updateId
     */
    public function setUpdateId(int $updateId): void
    {
        $this->updateId = $updateId;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getDate(): DateTimeImmutable
    {
        return $this->date;
    }

    /**
     * @param \DateTimeImmutable $date
     */
    public function setDate(DateTimeImmutable $date): void
    {
        $this->date = $date;
    }
}
