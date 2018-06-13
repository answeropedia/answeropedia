<?php

class Mapper_User_save_negative_apiKey_Test extends Abstract_DB_TestCase
{
    public function test_notSet()
    {
        $user = new User_Model();
        $user->setID(37);
        $user->setUsername('steve');
        $user->setName('Steve Bo');
        $user->setSignature('Foo bar');
        $user->setEmail('steve@aw.org');
        $user->setPasswordHash('$2a$10$3f6bd68f206c46e04c8ecOVlP228zJXYjSbuVRiEMhoIWxjWkzcvy');
        $user->setCreatedAt('2016-03-19 06:47:41');

        $this->expectExceptionMessage('User "apiKey" property null must be a string');
        $user = (new User_Mapper())->update($user);
    }

    public function test_tooShort()
    {
        $user = new User_Model();
        $user->setID(37);
        $user->setUsername('steve');
        $user->setName('Steve Bo');
        $user->setSignature('Foo bar');
        $user->setEmail('steve@aw.org');
        $user->setPasswordHash('$2a$10$3f6bd68f206c46e04c8ecOVlP228zJXYjSbuVRiEMhoIWxjWkzcvy');
        $user->setAPIKey('123');
        $user->setCreatedAt('2016-03-19 06:47:41');

        $this->expectExceptionMessage('User "apiKey" property "123" must have a length between 25 and 45');
        $user = (new User_Mapper())->update($user);
    }

    public function test_tooLong()
    {
        $user = new User_Model();
        $user->setID(37);
        $user->setUsername('steve');
        $user->setName('Steve Bo');
        $user->setSignature('Foo bar');
        $user->setEmail('steve@aw.org');
        $user->setPasswordHash('$2a$10$3f6bd68f206c46e04c8ecOVlP228zJXYjSbuVRiEMhoIWxjWkzcvy');
        $user->setAPIKey('4447243e3e1766375d23b06bf6dd1271+4447243e3e1766375d23b06bf6dd1271');
        $user->setCreatedAt('2016-03-19 06:47:41');

        $this->expectExceptionMessage('User "apiKey" property "4447243e3e1766375d23b06bf6dd1271+4447243e3e1766375d23b06bf6dd1271" must have a length between 25 and 45');
        $user = (new User_Mapper())->update($user);
    }
}