<?php

use PHPUnit\Framework\TestCase;

class Mapper_Revisions_save_NegativeCommentTest extends TestCase
{
    public function testCommentNotString()
    {
        $revision = new Revision_Model();
        $revision->setAnswerID(11);
        $revision->setOpcodes('abc');
        $revision->setBaseText('Answer written at 19:33');
        $revision->setComment(123);

        $this->expectExceptionMessage('Revision comment param 123 must be a string');
        $revision = (new Revision_Mapper('ru'))->save($revision);
    }

    public function testCommentIsEmpty()
    {
        $revision = new Revision_Model();
        $revision->setAnswerID(11);
        $revision->setOpcodes('abc');
        $revision->setBaseText('Answer written at 19:33');
        $revision->setComment('');

        $this->expectExceptionMessage('Revision comment param "" must have a length between 3 and 255');
        $revision = (new Revision_Mapper('ru'))->save($revision);
    }

    public function testCommentTooShort()
    {
        $revision = new Revision_Model();
        $revision->setAnswerID(11);
        $revision->setOpcodes('abc');
        $revision->setBaseText('Answer written at 19:33');
        $revision->setComment('s');

        $this->expectExceptionMessage('Revision comment param "s" must have a length between 3 and 255');
        $revision = (new Revision_Mapper('ru'))->save($revision);
    }
}