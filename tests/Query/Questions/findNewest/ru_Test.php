<?php

class Query_Questions__findNewest__ru_Test extends Abstract_DB_TestCase
{
    protected $setUpDB = ['ru' => ['questions']];

    public function test__Ru()
    {
        $questions = (new Questions_Query('ru'))->findNewest();

        $this->assertEquals(10, count($questions));

        $this->assertEquals(33, $questions[0]->getID());
        $this->assertEquals('Птицы играют в игры?', $questions[0]->getTitle());
        $this->assertEquals('Нет, не играют.', $questions[0]->getAnswer()->getText());

        $this->assertEquals(24, $questions[9]->getID());
        $this->assertEquals('Расскажете о своем опыте в области управления проектами?', $questions[9]->getTitle());
        $this->assertEquals('Hmm, it`s a long-long story...', $questions[9]->getAnswer()->getText());
    }

    public function test_firstPage()
    {
        $questions = (new Questions_Query('ru'))->findNewest(1);

        $this->assertEquals(10, count($questions));

        $this->assertEquals(33, $questions[0]->getID());
        $this->assertEquals('Птицы играют в игры?', $questions[0]->getTitle());
        $this->assertEquals('Нет, не играют.', $questions[0]->getAnswer()->getText());

        $this->assertEquals(24, $questions[9]->getID());
        $this->assertEquals('Расскажете о своем опыте в области управления проектами?', $questions[9]->getTitle());
        $this->assertEquals('Hmm, it`s a long-long story...', $questions[9]->getAnswer()->getText());
    }

    public function test_secondPage()
    {
        $questions = (new Questions_Query('ru'))->findNewest(2);

        $this->assertEquals(10, count($questions));

        $this->assertEquals(23, $questions[0]->getID());
        $this->assertEquals('Как армия тренирует солдат?', $questions[0]->getTitle());
        $this->assertEquals(null, $questions[0]->getAnswer()->getText());

        $this->assertEquals(14, $questions[9]->getID());
        $this->assertEquals('Как ты?', $questions[9]->getTitle());
        $this->assertEquals('I`m fine, bro!', $questions[9]->getAnswer()->getText());
    }
}