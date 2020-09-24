<?php

namespace Test\Traits\Model\Redirect\Category\init_with_DB_state;

class Test extends \PHPUnit\Framework\TestCase
{
    public function test__Base_params()
    {
        $redirect = \Model\Redirect\Category::initWithDBState([
            'rd_from'  => 13,
            'rd_title' => 'Some category',
        ]);

        $this->assertEquals(13, $redirect->from_ID);
        $this->assertEquals('Some category', $redirect->to_title);
    }
}
