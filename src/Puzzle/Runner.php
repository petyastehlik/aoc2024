<?php

declare(strict_types=1);

namespace AOC\Puzzle;

use AOC\Puzzle\Input\Input;
use AOC\Puzzle\Input\InputType;
use AOC\Puzzle\Input\Part;
use AOC\Puzzle\Solution\IDay;

final class Runner
{
    public static function solve(int $n, Part $part, InputType $type): string
    {
        /** @var IDay $day */
        $day = new ("\AOC\Puzzle\Solution\Day$n");
        $method = "part$part->value";
        $input = self::findInput($n, $part, $type);

        return $day->$method($input);
    }

    /**
     * Expects to find a full input and test inputs for both parts as files:
     *  input/1/input.txt
     *  input/1/part-1-test-input.txt
     *  input/1/part-2-test-input.txt
     */
    private static function findInput(int $n, Part $part, InputType $type): Input
    {
        return match ($type) {
            InputType::FULL => Input::fromFile(__DIR__ . "/../../input/$n/input.txt"),
            InputType::TEST => match ($part) {
                Part::ONE, Part::TWO => Input::fromFile(__DIR__ . "/../../input/$n/part-$part->value-test-input.txt"),
            }
        };
    }
}