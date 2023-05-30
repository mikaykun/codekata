<?php

declare(strict_types=1);

namespace App\Tests;

use App\StringHelper;
use PHPUnit\Framework\TestCase;

final class StringHelperTest extends TestCase
{
    public function testFirstNonRepeatingCharacter(): void
    {
        $this->assertEquals('a', StringHelper::firstNonRepeatingCharacter('a'));
        $this->assertEquals('t', StringHelper::firstNonRepeatingCharacter('stress'));
        $this->assertEquals('T', StringHelper::firstNonRepeatingCharacter('sTreSS'));
    }
}
