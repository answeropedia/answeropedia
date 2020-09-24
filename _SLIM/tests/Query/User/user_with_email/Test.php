<?php

namespace Test\Query\User\userWithEmail;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['users' => ['users']];

    public function test_Basic()
    {
        $user = (new \Query\User())->userWithEmail('pushka@answeropedia.org');

        $this->assertEquals(4, $user->id);
        $this->assertEquals('sasha', $user->username);
        $this->assertEquals('Александр Пушкин', $user->name);
        $this->assertEquals('pushka@answeropedia.org', $user->email);
        $this->assertEquals('2016-02-26 16:00:46', $user->createdAt);
    }
}
