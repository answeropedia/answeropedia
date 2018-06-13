<?php

class UserFollowQuestion_Relation_Mapper__deleteRelation__Test extends Abstract_DB_TestCase
{
    protected $setUpDB = ['ru' => ['er_users_follow_questions']];

    public function test__FullParams__OK()
    {
        // Relation must be in DB
        $relation = new UserFollowQuestion_Relation_Model();
        $relation->setID(5);
        $relation->setUserID(7);
        $relation->setQuestionID(23);
        $relation->setCreatedAt('2014-12-16 11:28:56');

        $deleted = (new UserFollowQuestion_Relation_Mapper('ru'))->deleteRelation($relation);

        $this->assertEquals(true, $deleted);
    }

    public function test__RelationNotExists()
    {
        // Not exists relation
        $relation = new UserFollowQuestion_Relation_Model();
        $relation->setID(6);
        $relation->setUserID(22);
        $relation->setQuestionID(61);
        $relation->setCreatedAt('2014-12-16 11:28:56');

        $this->expectExceptionMessage('UserFollowQuestion relation not deleted');
        $deleted = (new UserFollowQuestion_Relation_Mapper('ru'))->deleteRelation($relation);
    }
}