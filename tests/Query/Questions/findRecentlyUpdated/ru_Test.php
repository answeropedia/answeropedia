<?php

class Query_Questions__findRecentlyUpdated__Test extends Abstract_DB_TestCase
{
    protected $setUpDB = ['ru' => ['questions']];

    public function test__Ru()
    {
        $questions = (new Questions_Query('ru'))->findRecentlyUpdated();

        $this->assertEquals(10, count($questions));

        $this->assertEquals(33, $questions[0]->getID());
        $this->assertEquals('Птицы играют в игры?', $questions[0]->getTitle());
        $this->assertEquals('Нет, не играют.', $questions[0]->answer->getText());

        $this->assertEquals(20, $questions[1]->getID());
        $this->assertEquals('Как разработчики делают интересные игры?', $questions[1]->getTitle());
        $this->assertEquals('#Games', $questions[1]->answer->getText());
    }

    public function test_firstPage()
    {
        $questions = (new Questions_Query('ru'))->findRecentlyUpdated();

        $this->assertEquals(10, count($questions));

        $this->assertEquals(33, $questions[0]->getID());
        $this->assertEquals('Птицы играют в игры?', $questions[0]->getTitle());
        $this->assertEquals('Нет, не играют.', $questions[0]->answer->getText());

        $this->assertEquals(20, $questions[1]->getID());
        $this->assertEquals('Как разработчики делают интересные игры?', $questions[1]->getTitle());
        $this->assertEquals('#Games', $questions[1]->answer->getText());
    }

    public function test_secondPage()
    {
        $questions = (new Questions_Query('ru'))->findRecentlyUpdated(1);

        $this->assertEquals(1, count($questions));

        $this->assertEquals(32, $questions[0]->getID());
        $this->assertEquals('Чем отличается проектная деятельность от операционной в области ИТ?', $questions[0]->getTitle());
        $this->assertEquals('There are a lot of differences.', $questions[0]->answer->getText());
    }
}
