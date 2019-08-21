<?php

class User_URL_Trait__get_avatar_URL_medium__Test extends PHPUnit\Framework\TestCase
{
    public function test_Full_params()
    {
        $user = new User_Model();
        $user->id = 13;
        $user->name = 'Sasha';

        $this->assertEquals('https://avatars.answeropedia.org/avatars/user.png?size=200&name=Sasha', $user->get_avatar_URL_medium());
    }
}
