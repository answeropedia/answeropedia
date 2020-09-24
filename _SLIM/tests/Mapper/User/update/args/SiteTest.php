<?php

namespace Test\Mapper\User\update;

class SiteTest extends \Test\TestCase\DB
{
    protected $setUpDB = ['users' => ['users']];

    public function test_SiteNotSet()
    {
        $user = new \Model\User();
        $user->id = 7;
        $user->username = 'steve';
        $user->name = 'Steve Bo';
        $user->email = 'steve@aw.org';
        $user->passwordHash = '$2a$10$3f6bd68f206c46e04c8ecOVlP228zJXYjSbuVRiEMhoIWxjWkzcvy';
        $user->apiKey = '4447243e3e1766375d23b06bf6dd1271';
        $user->createdAt = '2016-03-19 06:47:41';

        $user = (new \Mapper\User())->update($user);
        $this->assertEquals(null, $user->site);
    }
}
