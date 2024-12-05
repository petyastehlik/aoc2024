<?php

declare(strict_types=1);

namespace AOC\Puzzle\Solution;

use AOC\Puzzle\Input\Input;

final class Day5 implements IDay
{
    public function part1(Input $input): string
    {
        [$sequences, $rules] = $this->parse($input);

        $valid = array_filter($sequences, fn(array $sequence): bool => $sequence === $this->sortSequence($sequence, $rules));

        return (string)$this->sumOfMiddleElements($valid);
    }

    public function part2(Input $input): string
    {
        [$sequences, $rules] = $this->parse($input);

        $invalid = array_filter($sequences, fn(array $sequence): bool => $sequence !== $this->sortSequence($sequence, $rules));

        $sorted = array_map(function (array $sequence) use ($rules): array {
            return $this->sortSequence($sequence, $rules);
        }, $invalid);

        return (string)$this->sumOfMiddleElements($sorted);
    }

    private function parse(Input $input): array
    {
        [$rulesString, $updatesString] = explode("\n\n", $input->read());
        $rules = ['before' => [], 'after' => []];

        foreach (explode("\n", $rulesString) as $ruleString) {
            [$before, $after] = explode("|", $ruleString);
            $rules['before'][(int)$before][] = (int)$after;
            $rules['after'][(int)$after][] = (int)$before;
        }

        $sequences = [];
        foreach (explode("\n", $updatesString) as $updateString) {
            $sequences[] = array_map(fn(string $n): int => (int)$n, explode(",", $updateString));
        }

        return [$sequences, $rules];
    }

    private function sortSequence(array $sequence, array $rules): array
    {
        usort($sequence, function (int $a, $b) use ($rules, $sequence): int {
            if (in_array($b, $rules['before'][$a] ?? [], true)) {
                return -1;
            }

            if (in_array($b, $rules['after'][$a] ?? [], true)) {
                return 1;
            }

            return 0;
        });

        return $sequence;
    }

    private function sumOfMiddleElements(array $valid): int
    {
        return array_reduce($valid, function (int $carry, array $sequence): int {
            $middle = floor(count($sequence) / 2);
            return $carry + $sequence[$middle];
        }, 0);
    }
}