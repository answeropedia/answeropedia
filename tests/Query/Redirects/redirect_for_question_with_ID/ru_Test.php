<?php

class Question_Redirects_Query__redirect_for_question_with_ID__ruTest extends Abstract_DB_TestCase
{
    protected $setUpDB = ['ru' => ['redirects_questions']];

    public function test__Redirect_exists()
    {
        $redirect = (new Question_Redirects_Query('ru'))->redirect_for_question_with_ID(30);

        $this->assertEquals(30, $redirect->fromID);
        $this->assertEquals('Был ли мальчик?', $redirect->toTitle);
    }

    public function test__Redirect_not_exists()
    {
        $this->expectExceptionMessage('Redirect for question with ID "145" not exists');
        $redirect = (new Question_Redirects_Query('ru'))->redirect_for_question_with_ID(145);
    }
}