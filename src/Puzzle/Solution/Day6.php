<?php

declare(strict_types=1);

namespace AOC\Puzzle\Solution;

use AOC\Puzzle\InfiniteRecursionException;
use AOC\Puzzle\Input\Input;
use AOC\Puzzle\Matrix;

final class Day6 implements IDay
{
    private const array UP = [-1, 0];
    private const array RIGHT = [0, 1];
    private const array DOWN = [1, 0];
    private const array LEFT = [0, -1];
    private array $directions = [
        self::UP,
        self::RIGHT,
        self::DOWN,
        self::LEFT
    ];

    public function part1(Input $input): string
    {
        $area = Matrix::fromString($input->read())->toArray();
        [$row, $col] = self::findGuard($area);
        $visited = $this->traverse($area, $row, $col, self::UP);

        // slice only visits, omit directions
        // count only unique positions
        return (string)count(array_unique(array_map(function (array $visit): array {
            return array_slice($visit, 0, -1);
        }, $visited), SORT_REGULAR));
    }

    public function part2(Input $input): string
    {
        $area = Matrix::fromString($input->read())->toArray();
        [$startRow, $startCol] = self::findGuard($area);

        $visited = $this->traverse($area, $startRow, $startCol, self::UP);

        $obstructions = [];
        foreach ($visited as $visit) {
            [$row, $col] = $visit;

            try {
                $area[$row][$col] = '#'; // blockade
                $this->traverse($area, $startRow, $startCol, self::UP);
            } catch (InfiniteRecursionException $e) {
                $obstructions[] = "$row-$col";
            } finally {
                $area[$row][$col] = '.'; // restore
            }
        }

        return (string)count(array_unique($obstructions, SORT_REGULAR));
    }

    private static function findGuard(array $area): array
    {
        foreach ($area as $i => $row) {
            foreach ($row as $j => $col) {
                if ($col === '^') {
                    return [$i, $j];
                }
            }
        }
    }

    private function traverse(array $area, int $row, int $col, array $direction): array
    {
        $visited = [];
        $visitedHashmap = [];
        $directions = $this->directions;
        while (true) {
            $forward = $area[$row + $direction[0]][$col + $direction[1]] ?? null;
            if ($forward === '#') {
                // turn right
                $direction = $directions[(array_search($direction, $directions, true) + 1) % 4];
                continue;
            }

            // mark leaving spot as visited
            $visited[] = [$row, $col, $direction];
            $hash = "$row-$col-$direction[0]-$direction[1]";

            // in a loop?
            if (isset($visitedHashmap[$hash])) {
                throw new InfiniteRecursionException();
            }

            // move away
            $visitedHashmap[$hash] = 1;
            $area[$row][$col] = '.';
            $row += $direction[0];
            $col += $direction[1];

            // if within bounds
            if (isset($area[$row][$col])) {
                // visit new
                $area[$row][$col] = '^';
            } else {
                // exit
                return $visited;
            }
        }
    }
}