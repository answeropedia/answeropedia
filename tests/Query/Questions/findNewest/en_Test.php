<?php

class Query_Questions__findNewest__en__Test extends Abstract_DB_TestCase
{
    protected $setUpDB = ['en' => ['questions']];

    public function test__En()
    {
        $questions = (new Questions_Query('en'))->findNewest();

        $this->assertEquals(10, count($questions));

        $this->assertEquals(29, $questions[0]->getID());
        $this->assertEquals('What is main president daily function?', $questions[0]->getTitle());
        $this->assertEquals('Oh, he make some work.', $questions[0]->getAnswer()->getText());

        $this->assertEquals(20, $questions[9]->getID());
        $this->assertEquals('How developers made interesting games?', $questions[9]->getTitle());
        $this->assertEquals('#Games', $questions[9]->getAnswer()->getText());
    }
}