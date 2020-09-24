<?php

namespace Test\Validator\Question\validateNew;

class TitleTest extends \PHPUnit\Framework\TestCase
{
    public function test__Title_not_set()
    {
        $question = new \Model\Question();
        $question->isRedirect = true;

        $this->expectExceptionMessage('Question title param null must be a string');
        $this->assertEquals(true, \Validator\Question::validateNew($question));
    }

    public function test__Title_is_empty()
    {
        $question = new \Model\Question();
        $question->title = '';
        $question->isRedirect = true;

        $this->expectExceptionMessage('Question title param "" must have a length between 3 and 255');
        $this->assertEquals(true, \Validator\Question::validateNew($question));
    }

    public function test__Comment_too_short()
    {
        $question = new \Model\Question();
        $question->title = 'x';
        $question->isRedirect = true;

        $this->expectExceptionMessage('Question title param "x" must have a length between 3 and 255');
        $this->assertEquals(true, \Validator\Question::validateNew($question));
    }

    public function test__Comment_too_long()
    {
        $question = new \Model\Question();
        $question->title = 'Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42.';
        $question->isRedirect = true;

        $this->expectExceptionMessage('Question title param "Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42. Title42." must have a length between 3 and 255');
        $this->assertEquals(true, \Validator\Question::validateNew($question));
    }
}
