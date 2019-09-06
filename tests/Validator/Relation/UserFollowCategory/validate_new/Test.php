<?php

class UserFollowCategory_Relation_Validator__validate_newTest extends PHPUnit\Framework\TestCase
{
    public function test__Full_params()
    {
        $relation = new UserFollowCategory_Relation_Model();
        $relation->userID = 3;
        $relation->categoryID = 9;
        $relation->createdAt = '2015-11-29 09:28:34';

        $this->assertEquals(true, UserFollowCategory_Relation_Validator::validate_new($relation));
    }

    public function test__Min_params()
    {
        $relation = new UserFollowCategory_Relation_Model();
        $relation->userID = 3;
        $relation->categoryID = 9;

        $this->assertEquals(true, UserFollowCategory_Relation_Validator::validate_new($relation));
    }
}