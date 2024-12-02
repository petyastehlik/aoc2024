<?php

declare(strict_types=1);

namespace AOC\Puzzle\Solution;

use AOC\Puzzle\Input\Input;

final class Day1 implements IDay
{

    public function part1(Input $input): string
    {
        [$left, $right] = $this->parse($input);

        $total = 0;
        foreach ($left as $k => $l) {
            $total += abs($right[$k] - $l);
        }

        return (string)$total;
    }

    public function part2(Input $input): string
    {
        [$left, $right] = $this->parse($input);

        $occurences = array_count_values($right);
        $similarity = array_map(fn(int $n): int => isset($occurences[$n]) ? $n * $occurences[$n] : 0, $left);

        return (string) array_sum($similarity);
    }

    private function parse(Input $input): array
    {
        $lines = $input->readAsLines();
        $columns = array_map(fn(string $line): array => preg_split('/\s+/', trim($line)), $lines);

        $left = array_map(fn(string $n) => (int)$n, array_column($columns, 0));
        $right = array_map(fn(string $n) => (int)$n, array_column($columns, 1));

        sort($left);
        sort($right);

        return [$left, $right];
    }
}