<?php

class Validator_Revision_NegativeParentID_Test extends PHPUnit\Framework\TestCase
{
    public function testParentIDEqualZero()
    {
        $revision = new Revision_Model();
        $revision->setAnswerID(11);
        $revision->setOpcodes('xyz');
        $revision->setBaseText('Ответ на вопрос про птиц.');
        $revision->setParentID(0);

        $this->expectExceptionMessage('Revision parentID param 0 must be greater than or equal to 1');
        Revision_Validator::validate($revision);
    }

    public function testParentIDBelowZero()
    {
        $revision = new Revision_Model();
        $revision->setAnswerID(11);
        $revision->setOpcodes('xyz');
        $revision->setBaseText('Ответ на вопрос про птиц.');
        $revision->setParentID(-1);

        $this->expectExceptionMessage('Revision parentID param -1 must be greater than or equal to 1');
        Revision_Validator::validate($revision);
    }
}