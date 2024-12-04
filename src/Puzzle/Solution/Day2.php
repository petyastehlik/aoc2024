<?php

declare(strict_types=1);

namespace AOC\Puzzle\Solution;

use AOC\Puzzle\Input\Input;

final class Day2 implements IDay
{

    public function part1(Input $input): string
    {
        $reports = $input->readAsArrayOfIntegers();
        return (string)count($this->findSatisfactory($reports));
    }

    public function part2(Input $input): string
    {
        $reports = $input->readAsArrayOfIntegers();
        $satisfactory = $this->findSatisfactory($reports);

        $unsatisfactory = array_diff_key($reports, array_flip($satisfactory));

        return (string)array_reduce($unsatisfactory, function (int $carry, array $report): int {
            $combinations = $this->generateCombinations($report);
            $carry += count($this->findSatisfactory($combinations)) > 0;

            return $carry;
        }, count($satisfactory));
    }

    public function findSatisfactory(array $reports): array
    {
        // sort in ascending order
        $reports = array_map(function (array $report): array {
            $first = $report[array_key_first($report)];
            $last = $report[array_key_last($report)];

            return $first < $last ? $report : array_reverse($report);
        }, $reports);

        // only sorted arrays satisfy the rules
        $reports = array_filter($reports, function (array $report): bool {
            $copy = $report;
            sort($copy);

            return $report === $copy;
        });

        $reports = array_filter($reports, function (array $report): bool {
            for ($i = 0; $i < count($report) - 1; $i++) {
                $diff = abs($report[$i] - $report[$i + 1]);
                if ($diff < 1 || $diff > 3) {
                    return false;
                }
            }

            return true;
        });

        return array_keys($reports);
    }

    private function generateCombinations(array $input): array
    {
        $result = [];
        foreach ($input as $index => $value) {
            $combination = $input;
            unset($combination[$index]);
            $result[] = array_values($combination);
        }

        return $result;
    }
}