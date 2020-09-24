<?php

namespace Test\Traits\Model\User\URL\getAvatarURLLarge;

class Test extends \PHPUnit\Framework\TestCase
{
    public function test__Default_avatar()
    {
        $user = new \Model\User();
        $user->id = 13;
        $user->name = 'Sasha';

        $this->assertEquals('https://avatars.answeropedia.org/avatars/user.png?size=400&name=Sasha', $user->getAvatarURLLarge());
    }

    public function test__Avatar_uploaded()
    {
        $user = new \Model\User();
        $user->id = 13;
        $user->name = 'Sasha';
        $user->is_avatar_uploaded = true;

        $this->assertEquals('https://answeropedia.org/uploads/avatar/13_400.jpg', $user->getAvatarURLLarge());
    }
}
