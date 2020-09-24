<?php

namespace Test\Query\Sandbox\findNewestWithoutAnswer;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['questions'], 'en' => ['questions']];

    public function test__Find_without_params()
    {
        $questions = (new \Query\Sandbox('ru'))->findNewestWithoutAnswer();

        $this->assertEquals(10, count($questions));

        $this->assertEquals(31, $questions[0]->id);
        $this->assertEquals('Какая сейчас погода?', $questions[0]->title);
        $this->assertEquals(null, $questions[0]->answer->text);

        $this->assertEquals(19, $questions[9]->id);
        $this->assertEquals('Огонь уничтожает ДНК?', $questions[9]->title);
        $this->assertEquals(null, $questions[9]->answer->text);
    }

    public function test__First_page()
    {
        $questions = (new \Query\Sandbox('ru'))->findNewestWithoutAnswer(1);

        $this->assertEquals(10, count($questions));

        $this->assertEquals(31, $questions[0]->id);
        $this->assertEquals('Какая сейчас погода?', $questions[0]->title);
        $this->assertEquals(null, $questions[0]->answer->text);

        $this->assertEquals(19, $questions[9]->id);
        $this->assertEquals('Огонь уничтожает ДНК?', $questions[9]->title);
        $this->assertEquals(null, $questions[9]->answer->text);
    }

    public function test__Second_page()
    {
        $questions = (new \Query\Sandbox('ru'))->findNewestWithoutAnswer(2);

        $this->assertEquals(10, count($questions));

        $this->assertEquals(18, $questions[0]->id);
        $this->assertEquals(3, $questions[9]->id);
    }
}
