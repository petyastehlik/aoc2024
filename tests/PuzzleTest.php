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

    private static function test(int $day, array $part1, array $part2): void
    {
        self::assertEquals($part1[0], Runner::solve($day, Part::ONE, InputType::TEST), "Day $day, part 1, test");
        self::assertEquals($part1[1], Runner::solve($day, Part::ONE, InputType::FULL), "Day $day, part 1, full input");

        self::assertEquals($part2[0], Runner::solve($day, Part::TWO, InputType::TEST), "Day $day, part 2, test");
        self::assertEquals($part2[1], Runner::solve($day, Part::TWO, InputType::FULL), "Day $day, part 2, full input");
    }
}