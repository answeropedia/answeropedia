<?php

namespace Test\Validator\Relation\UserFollowCategory\validateExists;

class Test extends \PHPUnit\Framework\TestCase
{
    public function test__Full_params()
    {
        $relation = new \Model\Relation\UserFollowCategory();
        $relation->id = 13;
        $relation->userID = 3;
        $relation->categoryID = 9;
        $relation->createdAt = '2015-11-29 09:28:34';

        $this->assertEquals(true, \Validator\Relation\UserFollowCategory::validateExists($relation));
    }

    public function test__Min_params()
    {
        $relation = new \Model\Relation\UserFollowCategory();
        $relation->id = 13;
        $relation->userID = 3;
        $relation->categoryID = 9;

        $this->assertEquals(true, \Validator\Relation\UserFollowCategory::validateExists($relation));
    }
}
