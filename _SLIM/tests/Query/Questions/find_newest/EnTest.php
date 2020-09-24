<?php

namespace Test\Query\Questions\findNewest;

class EnTest extends \Test\TestCase\DB
{
    protected $setUpDB = ['en' => ['questions']];

    public function test__Find_without_params()
    {
        $questions = (new \Query\Questions('en'))->findNewest();

        $this->assertEquals(10, count($questions));

        $this->assertEquals(29, $questions[0]->id);
        $this->assertEquals('What is main president daily function?', $questions[0]->title);
        $this->assertEquals('Oh, he make some work.', $questions[0]->answer->text);

        $this->assertEquals(20, $questions[9]->id);
        $this->assertEquals('How developers made interesting games?', $questions[9]->title);
        $this->assertEquals('Games', $questions[9]->answer->text);
    }
}
