<?php

use Atrox\Haikunator\Haikunator;

class HaikunatorTest extends PHPUnit_Framework_TestCase {

    public function testDefaultUse()
    {
        $haikunate = Haikunator::haikunate();
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(\\d{4})$/i", $haikunate);
    }

    public function testHexUse()
    {
        $haikunate = Haikunator::haikunate(["tokenHex" => true]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(.{4})$/i", $haikunate);
    }

    public function test9DigitsUse()
    {
        $haikunate = Haikunator::haikunate(["tokenLength" => 9]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(\\d{9})$/i", $haikunate);
    }

    public function test9DigitsAsHexUse()
    {
        $haikunate = Haikunator::haikunate(["tokenLength" => 9, "tokenHex" => true]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(.{9})$/i", $haikunate);
    }

    public function testWontReturnSameForSubsequentCalls()
    {
        $haikunate = Haikunator::haikunate();
        $haikunate2 = Haikunator::haikunate();
        $this->assertNotEquals($haikunate, $haikunate2);
    }

    public function testDropsToken()
    {
        $haikunate = Haikunator::haikunate(["tokenLength" => 0]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))$/i", $haikunate);
    }

    public function testPermitsOptionalDelimiter()
    {
        $haikunate = Haikunator::haikunate(["delimiter" => "."]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(\\.)((?:[a-z][a-z]+))(\\.)(\\d+)$/i", $haikunate);
    }

    public function testSpaceDelimiterAndNoToken()
    {
        $haikunate = Haikunator::haikunate(["delimiter" => " ", "tokenLength" => 0]);
        $this->assertRegExp("/((?:[a-z][a-z]+))( )((?:[a-z][a-z]+))$/i", $haikunate);
    }

    public function testOneSingleWord()
    {
        $haikunate = Haikunator::haikunate(["delimiter" => "", "tokenLength" => 0]);
        $this->assertRegExp("/((?:[a-z][a-z]+))$/i", $haikunate);
    }

    public function testCustomChars()
    {
        $haikunate = Haikunator::haikunate(["tokenChars" => "A"]);
        $this->assertRegExp("/((?:[a-z][a-z]+))(-)((?:[a-z][a-z]+))(-)(AAAA)$/i", $haikunate);
    }

    public function testIndexScrambleUniqueness()
    {
        $this->assertEquals(128*128, Haikunator::possibleCombos());
        $n = [];
        for ($i = 0; $i < 128*128; ++$i) {
            $n[] = Haikunator::indexToScramble($i);
        }
        $this->assertEquals(Haikunator::possibleCombos(), count(array_unique($n)));
    }

    public function testIndexScrambleConversion()
    {
        for ($i = 0; $i < 128*128; ++$i) {
            $this->assertEquals($i, Haikunator::scrambleToIndex(Haikunator::indexToScramble($i)));
        }
    }

    public function testScrambleHaikuConversion()
    {
        $this->assertEquals(["honest", "malamute"], Haikunator::indexToHaikuPair(0));
        $this->assertEquals(["clever", "panda"], Haikunator::indexToHaikuPair(1));
        $this->assertEquals(0, Haikunator::haikuPairToIndex("honest", "malamute"));
        $this->assertEquals(1, Haikunator::haikuPairToIndex("clever", "panda"));
    }

    public function testCustomNounsAndAdjectives()
    {
        Haikunator::$ADJECTIVES = ['FAIL'];
        Haikunator::$NOUNS = ['WTF'];
        $haikunate = Haikunator::haikunate();
        $this->assertRegExp("/(FAIL)(-)(WTF)(-)(\\d{4})$/i", $haikunate);
    }

    public function testEverythingInOne()
    {
        Haikunator::$ADJECTIVES = ['ROFL'];
        Haikunator::$NOUNS = ['COPTER'];
        $haikunate = Haikunator::haikunate([
            "delimiter" => ".",
            "tokenLength" => 8,
            "tokenChars" => "L"
        ]);
        $this->assertRegExp("/(ROFL)(\\.)(COPTER)(\\.)(LLLLLLLL)$/i", $haikunate);
    }
}
