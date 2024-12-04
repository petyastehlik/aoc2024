<?php

declare(strict_types=1);

namespace AOC\Puzzle\Input;

use InvalidArgumentException;

final readonly class Input
{
    private function __construct(private string $filePath)
    {
        if (file_exists($this->filePath) === false) {
            throw new InvalidArgumentException("The file '$this->filePath' doest not exist");
        }
    }

    public static function fromFile(string $filePath): self
    {
        return new self($filePath);
    }

    public function read(): string
    {
        return file_get_contents($this->filePath);
    }

    public function readAsLines(): array
    {
        return explode("\n", $this->read());
    }

    public function readAsArrayOfIntegers(): array
    {
        return array_map(fn(string $line) => array_map(fn(string $n) => (int)$n, explode(" ", $line)), $this->readAsLines());
    }
}