<?php

namespace Tests\APIController\DELETE\UsersIDFollow;

class Test extends \Test\TestCase\Frontend
{
    protected $setUpDB = [
        'ru'    => ['er_users_follow_users'],
        'users' => ['users'],
    ];

    public function test__Base_unfollow()
    {
        $uri = '/api/v1/ru/users/7/follow.json?api_key=7d21ebdbec3d4e396043c96b6ab44a6e';

        $request = $this->createRequest('DELETE', $uri);
        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'user_id'            => 3,
            'user_name'          => 'Иван Коршунов',
            'followed_user_id'   => 7,
            'followed_user_name' => 'Павел Перепелов',
        ];

        $this->assertEquals($expected_response, json_decode($response_body, true));
        $this->assertSame(200, $response->getStatusCode());
    }

    public function test__Not_followed()
    {
        $uri = '/api/v1/ru/users/4/follow.json?api_key=7d21ebdbec3d4e396043c96b6ab44a6e';

        $request = $this->createRequest('DELETE', $uri);
        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'error_code'    => 0,
            'error_message' => 'User with ID "4" not followed by user with ID "3"',
        ];

        $this->assertEquals($expected_response, json_decode($response_body, true));
        $this->assertSame(200, $response->getStatusCode());
    }
}
