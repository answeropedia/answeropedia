<?php

namespace Test\Query\Categories\findNewest;

class RuTest extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['categories']];

    public function test__Find_without_params()
    {
        $categories = (new \Query\Categories('ru'))->findNewest();

        $this->assertEquals(10, count($categories));

        $this->assertEquals(17, $categories[0]->id);
        $this->assertEquals('Фотосинтез', $categories[0]->title);

        $this->assertEquals(8, $categories[9]->id);
        $this->assertEquals('Парфюмерия', $categories[9]->title);
    }

    public function test__First_page()
    {
        $categories = (new \Query\Categories('ru'))->findNewest(1);

        $this->assertEquals(10, count($categories));

        $this->assertEquals(17, $categories[0]->id);
        $this->assertEquals('Фотосинтез', $categories[0]->title);

        $this->assertEquals(8, $categories[9]->id);
        $this->assertEquals('Парфюмерия', $categories[9]->title);
    }

    public function test__Second_page()
    {
        $categories = (new \Query\Categories('ru'))->findNewest(2);

        $this->assertEquals(10, count($categories));

        $this->assertEquals(10, $categories[0]->id);
        $this->assertEquals('Религия', $categories[0]->title);

        $this->assertEquals(1, $categories[9]->id);
        $this->assertEquals('Русская литература', $categories[9]->title);
    }

    public function test__Find_first_7_categories()
    {
        $categories = (new \Query\Categories('ru'))->findNewest(1, 7);

        $this->assertEquals(7, count($categories));

        $this->assertEquals(17, $categories[0]->id);
        $this->assertEquals('Фотосинтез', $categories[0]->title);

        $this->assertEquals(11, $categories[6]->id);
        $this->assertEquals('Каша', $categories[6]->title);
    }
}
