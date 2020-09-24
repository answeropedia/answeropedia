<?php

namespace Test\Validator\Revision\validate;

class IDTest extends \PHPUnit\Framework\TestCase
{
    public function test__ID_equal_zero()
    {
        $revision = new \Model\Revision();
        $revision->id = 0;
        $revision->answerID = 11;
        $revision->baseText = 'Some answer.';

        $this->expectExceptionMessage('Revision id param 0 must be greater than or equal to 1');
        \Validator\Revision::validate($revision);
    }

    public function test__ID_below_zero()
    {
        $revision = new \Model\Revision();
        $revision->id = -1;
        $revision->answerID = 11;
        $revision->baseText = 'Answer written at 10:15.';

        $this->expectExceptionMessage('Revision id param -1 must be greater than or equal to 1');
        \Validator\Revision::validate($revision);
    }
}
