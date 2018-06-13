<?php

class Mapper_User_save_negative_email_Test extends Abstract_DB_TestCase
{
    public function test_notSet()
    {
        $user = new User_Model();
        $user->setID(37);
        $user->setUsername('steve');
        $user->setName('Steve Bo');
        $user->setPasswordHash('$2a$10$3f6bd68f206c46e04c8ecOVlP228zJXYjSbuVRiEMhoIWxjWkzcvy');
        $user->setAPIKey('4447243e3e1766375d23b06bf6dd1271');
        $user->setCreatedAt('2016-03-19 06:47:41');

        $this->expectExceptionMessage('User "email" property null must be a string');
        $user = (new User_Mapper())->update($user);
    }

    public function test_incorrect()
    {
        $user = new User_Model();
        $user->setID(37);
        $user->setUsername('steve');
        $user->setName('Steve Bo');
        $user->setEmail('steve_aw.org');
        $user->setPasswordHash('$2a$10$3f6bd68f206c46e04c8ecOVlP228zJXYjSbuVRiEMhoIWxjWkzcvy');
        $user->setAPIKey('4447243e3e1766375d23b06bf6dd1271');
        $user->setCreatedAt('2016-03-19 06:47:41');

        $this->expectExceptionMessage('User "email" property "steve_aw.org" must be valid email');
        $user = (new User_Mapper())->update($user);
    }
}