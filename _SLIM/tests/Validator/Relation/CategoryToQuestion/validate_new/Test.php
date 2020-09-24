<?php

namespace Test\Validator\Relation\CategoryToQuestion\validateNew;

class Test extends \PHPUnit\Framework\TestCase
{
    public function test__Full_params()
    {
        $rel = new \Model\Relation\CategoriesToQuestions();
        $rel->categoryID = 3;
        $rel->questionID = 9;
        $rel->createdAt = '2015-11-29 09:28:34';

        $this->assertEquals(true, \Validator\Relation\CategoryToQuestion::validateNew($rel));
    }

    public function test__Min_params()
    {
        $rel = new \Model\Relation\CategoriesToQuestions();
        $rel->categoryID = 3;
        $rel->questionID = 9;

        $this->assertEquals(true, \Validator\Relation\CategoryToQuestion::validateNew($rel));
    }
}
