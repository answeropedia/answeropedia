<?php

namespace Test\Traits\Model\Relation\UserFollowQuestion\initWithUserIDAndQuestionID;

class Test extends \PHPUnit\Framework\TestCase
{
    public function test__BaseParams()
    {
        $rel = \Model\Relation\UserFollowQuestion::initWithUserIDAndQuestionID(3, 9);

        $this->assertEquals(null, $rel->id);
        $this->assertEquals(3, $rel->userID);
        $this->assertEquals(9, $rel->questionID);
        $this->assertEquals(null, $rel->createdAt);
    }
}
