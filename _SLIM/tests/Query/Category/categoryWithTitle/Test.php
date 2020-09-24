<?php

namespace Test\Query\Category\categoryWithTitle;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['categories']];

    public function test__Category_exists()
    {
        $category = (new \Query\Category('ru'))->categoryWithTitle('парфюмерия');

        $this->assertEquals(8, $category->id);
        $this->assertEquals('Парфюмерия', $category->title);
    }

    public function test__Category_not_exists()
    {
        $category = (new \Query\Category('ru'))->categoryWithTitle('notexists');

        $this->assertEquals(null, $category);
    }
}
