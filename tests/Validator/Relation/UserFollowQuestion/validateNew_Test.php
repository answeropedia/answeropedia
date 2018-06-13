<?php

class UserFollowQuestion_Relation_Validator__validateNew__Test extends PHPUnit\Framework\TestCase
{
    public function test__FullParams__OK()
    {
        $rel = new UserFollowQuestion_Relation_Model();
        $rel->setUserID(3);
        $rel->setQuestionID(9);
        $rel->setCreatedAt('2015-11-29 09:28:34');

        $this->assertEquals(true, UserFollowQuestion_Relation_Validator::validateNew($rel));
    }

    public function test__MinParams__OK()
    {
        $rel = new UserFollowQuestion_Relation_Model();
        $rel->setUserID(3);
        $rel->setQuestionID(9);

        $this->assertEquals(true, UserFollowQuestion_Relation_Validator::validateNew($rel));
    }
}