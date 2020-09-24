<?php

namespace Test\Mapper\Relation\UserFollowQuestion\delete_relation;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['er_users_follow_questions']];

    public function test__Full_args()
    {
        // Relation must be in DB
        $relation = new \Model\Relation\UserFollowQuestion();
        $relation->id = 5;
        $relation->userID = 7;
        $relation->questionID = 23;
        $relation->createdAt = '2014-12-16 11:28:56';

        $deleted = (new \Mapper\Relation\UserFollowQuestion('ru'))->delete_relation($relation);

        $this->assertEquals(true, $deleted);
    }

    public function test__Relation_not_exists()
    {
        // Not exists relation
        $relation = new \Model\Relation\UserFollowQuestion();
        $relation->id = 6;
        $relation->userID = 22;
        $relation->questionID = 61;
        $relation->createdAt = '2014-12-16 11:28:56';

        $this->expectExceptionMessage('UserFollowQuestion relation not deleted');
        $deleted = (new \Mapper\Relation\UserFollowQuestion('ru'))->delete_relation($relation);
    }
}
