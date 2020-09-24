<?php

namespace Test\Query\Question\questionWithTitle;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['questions']];

    public function test__Question_with_answer()
    {
        $question = (new \Query\Question('ru'))->questionWithTitle('Как птицы помечают свою территорию?');

        $this->assertEquals(6, $question->id);
        $this->assertEquals('Как птицы помечают свою территорию?', $question->title);
        $this->assertEquals('4_2013_05_09_123', $question->imageBaseName);
    }

    public function test__Question_without_answer()
    {
        $question = (new \Query\Question('ru'))->questionWithTitle('В чем драматизм человека?');

        $this->assertEquals(5, $question->id);
        $this->assertEquals('В чем драматизм человека?', $question->title);
        $this->assertEquals('4_2066_05_09_123', $question->imageBaseName);
    }
}
