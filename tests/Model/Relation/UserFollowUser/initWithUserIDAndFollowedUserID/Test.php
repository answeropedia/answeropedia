<?php

class UserFollowUser_Relation_Model__initWithUserIDAndFollowedUserID__Test extends PHPUnit\Framework\TestCase
{
    public function test__BaseParams()
    {
        $rel = UserFollowUser_Relation_Model::initWithUserIDAndFollowedUserID(3, 9);

        $this->assertEquals(null, $rel->getID());
        $this->assertEquals(3, $rel->getUserID());
        $this->assertEquals(9, $rel->getFollowedUserID());
        $this->assertEquals(null, $rel->getCreatedAt());
    }
}