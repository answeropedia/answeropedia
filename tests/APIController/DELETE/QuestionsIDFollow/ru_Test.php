<?php

class QuestionsIDFollow_DELETE_APIController__ru__Test extends Abstract_Frontend_TestCase
{
    protected $setUpDB = ['ru' => ['questions', 'er_users_follow_questions'], 'users' => ['users']];

    public function test__BaseUnfollow()
    {
        $query_string = 'api_key=7d21ebdbec3d4e396043c96b6ab44a6e';
        $request = $this->__getTestRequest('DELETE', '/api/v1/ru/questions/7/follow.json', $query_string, true);

        $this->app->getContainer()['request'] = $request;

        $response = $this->app->run(true);
        $responseBody = (string) $response->getBody();

        $expectedResponse = [
            'user_id' => 3,
            'user_name' => 'Иван Коршунов',
            'followed_question_id' => 7,
            'followed_question_title' => 'Какую роль играет почва во взаимосвязи неживой и живой природы?'
        ];

        $this->assertEquals($expectedResponse, json_decode($responseBody, true));
        $this->assertSame(200, $response->getStatusCode());
    }

    public function test__NotFollowed()
    {
        $query_string = 'api_key=7d21ebdbec3d4e396043c96b6ab44a6e';
        $request = $this->__getTestRequest('DELETE', '/api/v1/ru/questions/4/follow.json', $query_string, true);

        $this->app->getContainer()['request'] = $request;

        $response = $this->app->run(true);
        $responseBody = (string) $response->getBody();

        $expectedResponse = [
            'error_code' => 0,
            'error_message' => 'User with ID "3" not followed question with ID "4"'
        ];

        $this->assertEquals($expectedResponse, json_decode($responseBody, true));
        $this->assertSame(200, $response->getStatusCode());
    }
}