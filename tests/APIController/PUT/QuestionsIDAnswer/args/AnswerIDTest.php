<?php

namespace Tests\APIController\PUT\QuestionsIDAnswer;

class AnswerIDTest extends \Test\TestCase\Frontend
{
    protected $setUpDB = ['users' => ['users']];

    public function testQuestionIDEqualZero()
    {
        $uri = '/api/v1/ru/questions/0/answer.json';
        $form_data = [
            'answer_text'     => urlencode('In Ekaterinburg.'),
            'changes_comment' => urlencode('Some fixes for Q15'),
            'user_api_key'    => '34b88c8f1ed16fdcc18d93667c886fcc',
        ];

        $request = $this->createRequest('PUT', $uri);
        $request = $this->withFormData($request, $form_data);

        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'error_code'    => 0,
            'error_message' => 'Answer id param 0 must be greater than or equal to 1',
        ];

        $this->assertEquals($expected_response, json_decode($response_body, true));
        $this->assertSame(200, $response->getStatusCode());
    }

    public function test_questionIDBelowZero()
    {
        $uri = '/api/v1/ru/questions/-1/answer.json';
        $form_data = [
            'answer_text'     => urlencode('In Ekaterinburg.'),
            'changes_comment' => urlencode('Some fixes for Q15'),
            'user_api_key'    => '34b88c8f1ed16fdcc18d93667c886fcc',
        ];

        $request = $this->createRequest('PUT', $uri);
        $request = $this->withFormData($request, $form_data);

        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'error_code'    => 0,
            'error_message' => 'Answer id param -1 must be greater than or equal to 1',
        ];

        $this->assertEquals($expected_response, json_decode($response_body, true));
        $this->assertSame(200, $response->getStatusCode());
    }
}
