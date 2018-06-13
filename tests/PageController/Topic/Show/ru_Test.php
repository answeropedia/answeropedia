<?php

class Show_Topic_PageController__ru__Test extends Abstract_Frontend_TestCase
{
    protected $setUpDB = ['ru' => ['questions', 'topics', 'er_topics_questions', 'er_users_follow_topics']];

    public function test__ShowENPage()
    {
        $environment = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/ru/topic/12/kashemir',
        ]);
        $request = \Slim\Http\Request::createFromEnvironment($environment);
        $this->app->getContainer()['request'] = $request;

        $response = $this->app->run(true);
        $responseBody = (string) $response->getBody();

        $this->assertContains('<title>Вопросы и ответы на тему &laquo;Кашемир&raquo; &mdash; OctoAnswers</title>', $responseBody);
        $this->assertSame(200, $response->getStatusCode());
    }
}