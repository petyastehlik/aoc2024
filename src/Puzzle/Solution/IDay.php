<?php

declare(strict_types=1);

namespace AOC\Puzzle\Solution;

use AOC\Puzzle\Input\Input;

interface IDay
{
    public function part1(Input $input): string;

    public function part2(Input $input): string;
}

