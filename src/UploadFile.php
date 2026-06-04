<?php

namespace Nece\Framework\Adapter;

use Nece\Framework\Adapter\Contract\UploadFile as ContractUploadFile;
use Webman\Http\UploadFile as HttpUploadFile;
use Webman\File;

class UploadFile implements ContractUploadFile
{
    /**
     * 创建上传文件实例
     *
     * @author nece001@163.com
     * @create 2026-06-04 16:54:01
     *
     * @param HttpUploadFile $file
     * @return static
     */
    public static function instance($file): static
    {
        return new static($file);
    }

    /**
     * @inheritDoc
     */
    public static function instances(array $files): array
    {
        $instances = [];
        foreach ($files as $field=>$file) {
            $instances[$field] = new static($file);
        }
        return $instances;
    }

    /**
     * 上传文件
     *
     * @var HttpUploadFile
     */
    private $upload_file;

    public function __construct(HttpUploadFile $file)
    {
        $this->upload_file = $file;
    }

    /**
     * @inheritDoc
     */
    public function getUploadName(): ?string
    {
        return $this->upload_file->getUploadName();
    }

    /**
     * @inheritDoc
     */
    public function getUploadMimeType(): ?string
    {
        return $this->upload_file->getUploadMimeType();
    }

    /**
     * @inheritDoc
     */
    public function getUploadExtension(): string
    {
        return $this->upload_file->getUploadExtension();
    }

    /**
     * @inheritDoc
     */
    public function getUploadErrorCode(): ?int
    {
        return $this->upload_file->getUploadErrorCode();
    }

    /**
     * @inheritDoc
     */
    public function isValid(): bool
    {
        return $this->upload_file->isValid();
    }

    /**
     * @inheritDoc
     */
    public function move(string $destination): File
    {
        return $this->upload_file->move($destination);
    }

    /**
     * @inheritDoc
     */
    public function getPath(): string
    {
        return $this->upload_file->getPath();
    }

    /**
     * @inheritDoc
     */
    public function getFilename(): string
    {
        return $this->upload_file->getFilename();
    }

    /**
     * @inheritDoc
     */
    public function getPathname(): string
    {
        return $this->upload_file->getPathname();
    }

    /**
     * @inheritDoc
     */
    public function getExtension(): string
    {
        return $this->upload_file->getExtension();
    }

    /**
     * @inheritDoc
     */
    public function getBasename(?string $suffix = null): string
    {
        return $this->upload_file->getBasename($suffix);
    }

    /**
     * @inheritDoc
     */
    public function isFile(): bool
    {
        return $this->upload_file->isFile();
    }

    /**
     * @inheritDoc
     */
    public function isDir(): bool
    {
        return $this->upload_file->isDir();
    }

    /**
     * @inheritDoc
     */
    public function isLink(): bool
    {
        return $this->upload_file->isLink();
    }

    /**
     * @inheritDoc
     */
    public function getSize(): int|false
    {
        return $this->upload_file->getSize();
    }

    /**
     * @inheritDoc
     */
    public function getOwner(): int|false
    {
        return $this->upload_file->getOwner();
    }

    /**
     * @inheritDoc
     */
    public function getGroup(): int|false
    {
        return $this->upload_file->getGroup();
    }

    /**
     * @inheritDoc
     */
    public function getATime(): int|false
    {
        return $this->upload_file->getATime();
    }

    /**
     * @inheritDoc
     */
    public function getMTime(): int|false
    {
        return $this->upload_file->getMTime();
    }

    /**
     * @inheritDoc
     */
    public function getCTime(): int|false
    {
        return $this->upload_file->getCTime();
    }

    /**
     * @inheritDoc
     */
    public function getPerms(): int|false
    {
        return $this->upload_file->getPerms();
    }

    /**
     * @inheritDoc
     */
    public function isReadable(): bool
    {
        return $this->upload_file->isReadable();
    }

    /**
     * @inheritDoc
     */
    public function isWritable(): bool
    {
        return $this->upload_file->isWritable();
    }

    /**
     * @inheritDoc
     */
    public function isExecutable(): bool
    {
        return $this->upload_file->isExecutable();
    }

    /**
     * @inheritDoc
     */
    public function getRealPath(): string|false
    {
        return $this->upload_file->getRealPath();
    }
}