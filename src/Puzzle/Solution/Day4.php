<?php

declare(strict_types=1);

namespace AOC\Puzzle\Solution;

use AOC\Puzzle\Input\Input;
use AOC\Puzzle\Matrix;

final class Day4 implements IDay
{
    public function part1(Input $input): string
    {
        $matrix = Matrix::fromString($input->read());

        $matched = 0;
        $matched += preg_match_all("/XMAS/", $matrix->toString());
        $matched += preg_match_all("/SAMX/", $matrix->toString());

        $matched += preg_match_all("/XMAS/", $matrix->rotate(90)->toString());
        $matched += preg_match_all("/SAMX/", $matrix->rotate(90)->toString());

        $jaggedArray = $matrix->rotate(45);
        $matched += preg_match_all("/S\.?A\.?M\.?X/", $jaggedArray->toString());
        $matched += preg_match_all("/X\.?M\.?A\.?S/", $jaggedArray->toString());

        $matched += preg_match_all("/S\.?A\.?M\.?X/", $jaggedArray->rotate(90)->toString());
        $matched += preg_match_all("/X\.?M\.?A\.?S/", $jaggedArray->rotate(90)->toString());

        return (string)$matched;
    }

    public function part2(Input $input): string
    {
        $total = 0;
        $matrix = Matrix::fromString($input->read())->toArray();
        for ($i = 0; $i < count($matrix); $i++) {
            for ($j = 0; $j < count($matrix[$i]); $j++) {
                $center = $matrix[$i][$j];
                $q1 = $matrix[$i - 1][$j - 1] ?? null;
                $q2 = $matrix[$i + 1][$j - 1] ?? null;
                $q3 = $matrix[$i - 1][$j + 1] ?? null;
                $q4 = $matrix[$i + 1][$j + 1] ?? null;

                $mainDiagonal = $q1 === 'M' && $q4 === 'S' || $q1 === 'S' && $q4 === 'M';
                $antiDiagonal = $q2 === 'M' && $q3 === 'S' || $q2 === 'S' && $q3 === 'M';

                $total += (int) ($center === 'A' && $mainDiagonal && $antiDiagonal);
            }
        }

        return (string) $total;
    }
}