<?php

class UserFollowUser_Relation_Validator__id__Test extends PHPUnit\Framework\TestCase
{
    public function test_IDEqualZero()
    {
        $relation = new UserFollowUser_Relation_Model();
        $relation->setID(0);
        $relation->setUserID(3);
        $relation->setFollowedUserID(9);

        $this->expectExceptionMessage('UserFollowUser relation "id" property 0 must be greater than or equal to 1');
        UserFollowUser_Relation_Validator::validateExists($relation);
    }

    public function test__IDBelowZero()
    {
        $relation = new UserFollowUser_Relation_Model();
        $relation->setID(-1);
        $relation->setUserID(3);
        $relation->setFollowedUserID(9);

        $this->expectExceptionMessage('UserFollowUser relation "id" property -1 must be greater than or equal to 1');
        UserFollowUser_Relation_Validator::validateExists($relation);
    }
}