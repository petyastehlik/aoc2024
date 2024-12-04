<?php

declare(strict_types=1);

namespace AOC\Puzzle;

use InvalidArgumentException;

final class Matrix
{

    private function __construct(private readonly array $internal)
    {

    }

    public static function fromString(string $input): self
    {
        return new self(
            array_map(fn(string $line): array => str_split($line), explode("\n", $input))
        );
    }

    public static function fromArray(array $input): self
    {
        return new self($input);
    }

    public function toString(): string
    {
        return rtrim(array_reduce($this->internal, function (string $carry, array $line) {
            return $carry . implode('', $line) . "\n";
        }, ''), "\n");
    }

    public function toArray(): array
    {
        return $this->internal;
    }

    public function rotate(int $degrees): self
    {
        return match ($degrees) {
            45 => $this->rotateDiagonally(),
            90 => self::fromArray(array_map(array_reverse(...), $this->transpose()->toArray())),
            default => throw new InvalidArgumentException("Rotation by '$degrees' degrees is not implemented")
        };
    }

    private function rotateDiagonally(string $filler = '.'): self
    {
        $rows = count($this->internal);
        $cols = count($this->internal[0]);
        $width = $rows + $cols - 1;
        $sparse = array_fill(0, $width, array_fill(0, $width, $filler));

        foreach ($this->internal as $i => $row) {
            foreach ($row as $j => $value) {
                $newRow = $i + $j;
                $newCol = ($cols - 1) + $i - $j;
                $sparse[$newRow][$newCol] = $value;
            }
        }

        return self::fromArray($sparse);
    }

    private function transpose(): self
    {
        return self::fromArray(array_map(null, ...$this->internal));
    }
}