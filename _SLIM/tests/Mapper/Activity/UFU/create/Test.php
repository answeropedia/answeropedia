<?php

namespace Test\Mapper\Activity\UFU\create;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['activities']];

    public function test__Create_with_full_params()
    {
        $user = new \Model\User();
        $user->id = 46;
        $user->name = 'Steve Bo';

        $followedUser = new \Model\User();
        $followedUser->id = 6;
        $followedUser->name = 'Steve Bar';

        $activity = new \Model\Activity();
        $activity->type = \Model\Activity::F_U_FOLLOW_U;
        $activity->subject = $user;
        $activity->data = $followedUser;

        $activity = (new \Mapper\Activity\UFollowU('ru'))->create($activity);

        $this->assertEquals(13, $activity->id);
        $this->assertEquals(\Model\Activity::F_U_FOLLOW_U, $activity->type);
    }
}
