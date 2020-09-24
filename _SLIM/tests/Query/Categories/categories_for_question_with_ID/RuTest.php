<?php

namespace Test\Query\Categories\categoriesForQuestionWithID;

class RuTest extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['categories', 'er_categories_questions']];

    public function test__Question_have_two_categories()
    {
        $categories = (new \Query\Categories('ru'))->categoriesForQuestionWithID(22);

        $this->assertEquals(2, count($categories));

        $this->assertEquals(7, $categories[0]->id);
        $this->assertEquals('Косметика', $categories[0]->title);

        $this->assertEquals(13, $categories[1]->id);
        $this->assertEquals('Птицы', $categories[1]->title);
    }

    public function test__Question_dont_havecategories()
    {
        $categories = (new \Query\Categories('ru'))->categoriesForQuestionWithID(5);

        $this->assertEquals(0, count($categories));
    }
}
