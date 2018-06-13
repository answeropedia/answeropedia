<?php

class Unlogged_Main_PageController__ru__Test extends Abstract_Frontend_TestCase
{
    protected $setUpDB = ['ru' => ['questions', 'revisions', 'topics'], 'users' => ['users']];

    public function test_base()
    {
        $environment = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/ru',
        ]);
        $request = \Slim\Http\Request::createFromEnvironment($environment);
        $this->app->getContainer()['request'] = $request;

        $response = $this->app->run(true);
        $responseBody = (string) $response->getBody();

        $this->assertContains('OctoAnswers - Задай вопрос и получи один компетентный ответ', $responseBody);
        $this->assertSame(200, $response->getStatusCode());
    }
}