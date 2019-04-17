<?php

class Sandbox_Query__findNewestWithoutAnswer_Test extends Abstract_DB_TestCase
{
    protected $setUpDB = ['ru' => ['questions'], 'en' => ['questions']];

    public function test_Ru()
    {
        $questions = (new Sandbox_Query('ru'))->findNewestWithoutAnswer();

        $this->assertEquals(10, count($questions));

        $this->assertEquals(31, $questions[0]->getID());
        $this->assertEquals('Какая сейчас погода?', $questions[0]->getTitle());
        $this->assertEquals(null, $questions[0]->answer->text);

        $this->assertEquals(18, $questions[9]->getID());
        $this->assertEquals('Кто лучший драматический актер?', $questions[9]->getTitle());
        $this->assertEquals(null, $questions[9]->answer->text);
    }

    public function test_firstPage()
    {
        $questions = (new Sandbox_Query('ru'))->findNewestWithoutAnswer(1);

        $this->assertEquals(10, count($questions));

        $this->assertEquals(31, $questions[0]->getID());
        $this->assertEquals('Какая сейчас погода?', $questions[0]->getTitle());
        $this->assertEquals(null, $questions[0]->answer->text);

        $this->assertEquals(18, $questions[9]->getID());
        $this->assertEquals('Кто лучший драматический актер?', $questions[9]->getTitle());
        $this->assertEquals(null, $questions[9]->answer->text);
    }

    public function test_secondPage()
    {
        $questions = (new Sandbox_Query('ru'))->findNewestWithoutAnswer(2);

        $this->assertEquals(10, count($questions));

        $this->assertEquals(17, $questions[0]->getID());
        $this->assertEquals(2, $questions[9]->getID());
    }
}
