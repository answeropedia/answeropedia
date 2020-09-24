<?php

namespace Test\Validator\Question\validateExists;

class Test extends \PHPUnit\Framework\TestCase
{
    public function test__Exists_question_with_full_params()
    {
        $question = new \Model\Question();
        $question->id = 13;
        $question->title = 'How iPhone 8 are charged?';
        $question->isRedirect = true;

        $this->assertEquals(true, \Validator\Question::validateExists($question));
    }

    public function test__Exists_question_with_min_params()
    {
        $question = new \Model\Question();
        $question->id = 13;
        $question->title = 'How iPhone 8 are charged?';

        $this->assertEquals(true, \Validator\Question::validateExists($question));
    }
}
