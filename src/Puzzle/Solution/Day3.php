<?php

declare(strict_types=1);

namespace AOC\Puzzle\Solution;

use AOC\Puzzle\Input\Input;

final class Day3 implements IDay
{
    public function part1(Input $input): string
    {
        return (string)$this->multiply($input->read());
    }

    public function part2(Input $input): string
    {
        $lines = preg_split("/(don't\(\))|(do\(\))/", $input->read(), -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        $enabled = true;
        return (string)array_reduce($lines, function (int $carry, string $line) use (&$enabled): int {
            match ($line) {
                'do()' => $enabled = true,
                'don\'t()' => $enabled = false,
                default => $carry += $enabled ? $this->multiply($line) : 0,
            };
            return $carry;
        },
            0
        );
    }

    private function multiply(string $instructions): int
    {
        $matches = null;
        preg_match_all("/mul\((\d{1,3}),(\d{1,3})\)/", $instructions, $matches, PREG_PATTERN_ORDER);

        $multiplied = array_map(fn(string $a, string $b): int => (int)$a * (int)$b, $matches[1], $matches[2]);

        return array_sum($multiplied);
    }
}