<?php

namespace Test\Helper\ExtendedParsedown;

use PHPUnit\Framework\TestCase;

class CategoriesTest extends TestCase
{
    protected function setUp(): void
    {
        $this->pd = new \Helper\ExtendedParsedown('ru');
    }

    protected function tearDown(): void
    {
        $this->pd = null;
    }

    public function test_Dont_link_to_hashtags()
    {
        $stringMD = 'Any #birds may #fly.';
        $stringHTML = '<p>Any #birds may #fly.</p>';

        $this->assertEquals($stringHTML, $this->pd->text($stringMD));
    }
}
