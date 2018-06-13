<?php

class Validator_Topic_validate_id_Test extends PHPUnit\Framework\TestCase
{
    public function test_IDEqualZero()
    {
        $topic = new Topic_Model();
        $topic->setID(0);
        $topic->setTitle('iphone8');

        $this->expectExceptionMessage('Topic id param 0 must be greater than or equal to 1');
        Topic_Validator::validateExists($topic);
    }

    public function testIDBelowZero()
    {
        $topic = new Topic_Model();
        $topic->setID(-1);
        $topic->setTitle('iphone8');

        $this->expectExceptionMessage('Topic id param -1 must be greater than or equal to 1');
        Topic_Validator::validateExists($topic);
    }
}