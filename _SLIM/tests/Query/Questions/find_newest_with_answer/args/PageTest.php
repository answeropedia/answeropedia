<?php

namespace Test\Query\Questions\findNewestWithAnswer;

class PageTest extends \Test\TestCase\DB
{
    public function test__Page_param_equal_zero()
    {
        $this->expectExceptionMessage('Questions list page param 0 must be greater than or equal to 1');
        $questions = (new \Query\Questions('ru'))->findNewestWithAnswer(0);
    }

    public function test__Page_param_below_zero()
    {
        $this->expectExceptionMessage('Questions list page param -1 must be greater than or equal to 1');
        $questions = (new \Query\Questions('ru'))->findNewestWithAnswer(-1);
    }

    public function test__Page_param_greater_than_9999()
    {
        $this->expectExceptionMessage('Questions list page param 10000 must be less than or equal to 9999');
        $questions = (new \Query\Questions('ru'))->findNewestWithAnswer(10000);
    }
}
