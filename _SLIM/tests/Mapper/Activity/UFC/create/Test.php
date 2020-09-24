<?php

namespace Test\Mapper\Activity\UFC\create;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['activities']];

    public function test__Create_with_full_params()
    {
        $user = new \Model\User();
        $user->id = 46;
        $user->name = 'Steve Bo';

        $category = \Model\Category::initWithTitle('tag10');

        $activity = new \Model\Activity();
        $activity->type = \Model\Activity::USER_FOLLOW_CATEGORY;
        $activity->subject = $user;
        $activity->data = $category;

        $activity = (new \Mapper\Activity\UFollowC('ru'))->create($activity);

        $this->assertEquals(13, $activity->id);
        $this->assertEquals(\Model\Activity::USER_FOLLOW_CATEGORY, $activity->type);
    }
}
