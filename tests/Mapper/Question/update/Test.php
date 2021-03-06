<?php

namespace Test\Mapper\Question\update;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['questions']];

    public function test__Update_with_full_params()
    {
        $question = new \Model\Question();
        $question->id = 2;
        $question->title = 'This is question?';
        $question->isRedirect = true;
        $question->imageBaseName = '4_2013_05_09_123';

        $question = (new \Mapper\Question('ru'))->update($question);

        $this->assertEquals(2, $question->id);
        $this->assertEquals('This is question?', $question->title);
        $this->assertEquals(true, $question->isRedirect);
        $this->assertEquals('4_2013_05_09_123', $question->imageBaseName);
    }

    public function test__Update_with_min_params()
    {
        $question = new \Model\Question();
        $question->id = 4;
        $question->title = 'Ready to work?';

        $question = (new \Mapper\Question('ru'))->update($question);

        $this->assertEquals(4, $question->id);
        $this->assertEquals('Ready to work?', $question->title);
        $this->assertEquals(false, $question->isRedirect);
        $this->assertEquals(null, $question->imageBaseName);
    }
}
