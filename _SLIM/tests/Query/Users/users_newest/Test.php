<?php

namespace Test\Query\Users\users_newest;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['users' => ['users']];

    public function test__Query_with_no_params()
    {
        $users = (new \Query\Users())->usersNewest();

        $this->assertEquals(10, count($users));

        $firstUser = $users[0];
        $this->assertEquals(15, $firstUser->id);
        $this->assertEquals('leo', $firstUser->username);
        $this->assertEquals('Лев Толстой', $firstUser->name);

        $lastUser = $users[9];
        $this->assertEquals(6, $lastUser->id);
        $this->assertEquals('kozel', $lastUser->username);
        $this->assertEquals('Виталий Козлов', $lastUser->name);
    }
}
