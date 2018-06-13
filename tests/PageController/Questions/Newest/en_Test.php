<?php

class Newest_Questions_PageController__en__Test extends Abstract_Frontend_TestCase
{
    protected $setUpDB = ['en' => ['questions', 'topics', 'revisions'], 'users' => ['users']];

    public function testBase()
    {
        $environment = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/en/questions/newest',
        ]);
        $request = \Slim\Http\Request::createFromEnvironment($environment);
        $this->app->getContainer()['request'] = $request;

        $response = $this->app->run(true);
        $responseBody = (string) $response->getBody();

        $this->assertContains('Questions with answers - Page 1 - OctoAnswers', $responseBody);
        $this->assertContains('What is main president daily function?', $responseBody);
        $this->assertSame(200, $response->getStatusCode());
    }
}