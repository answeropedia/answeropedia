<?php

class Query_Questions__findRecentlyUpdated__en__Test extends Abstract_DB_TestCase
{
    protected $setUpDB = ['en' => ['questions']];

    public function test__En()
    {
        $questions = (new Questions_Query('en'))->findRecentlyUpdated();

        $this->assertEquals(9, count($questions));

        $this->assertEquals(14, $questions[0]->getID());
        $this->assertEquals('How are you?', $questions[0]->getTitle());
        $this->assertEquals('I`m fine, bro!', $questions[0]->answer->getText());
    }
}
