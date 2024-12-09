<?php

declare(strict_types=1);

namespace Tests;

use AOC\Puzzle\Input\InputType;
use AOC\Puzzle\Input\Part;
use AOC\Puzzle\Runner;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class PuzzleTest extends TestCase
{
    #[Test]
    public function day1(): void
    {
        self::test(1, ['11', '2285373'], ['31', '21142653']);
    }

    #[Test]
    public function day2(): void
    {
        self::test(2, ['2', '432'], ['4', '488']);
    }

    #[Test]
    public function day3(): void
    {
        self::test(3, ['161', '188116424'], ['48', '104245808']);
    }

    #[Test]
    public function day4(): void
    {
        self::test(4, ['18', '2427'], ['9', '1900']);
    }

    #[Test]
    public function day5(): void
    {
        self::test(5, ['143', '6041'], ['123', '4884']);
    }

    #[Test]
    public function day6(): void
    {
        self::test(6, ['41', '5067'], ['6', '1793']);
    }

    private static function test(int $day, array $part1, array $part2): void
    {
        ini_set('display_errors', 1);
        ini_set('error_reporting', E_ALL);

        self::assertEquals($part1[0], Runner::solve($day, Part::ONE, InputType::TEST), "Day $day, part 1, test");
        self::assertEquals($part1[1], Runner::solve($day, Part::ONE, InputType::FULL), "Day $day, part 1, full input");

        self::assertEquals($part2[0], Runner::solve($day, Part::TWO, InputType::TEST), "Day $day, part 2, test");
        self::assertEquals($part2[1], Runner::solve($day, Part::TWO, InputType::FULL), "Day $day, part 2, full input");
    }
}