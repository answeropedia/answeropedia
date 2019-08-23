<?php

class Questions_Search_PageController__ru__Test extends Abstract_Frontend_TestCase
{
    protected $setUpDB = ['ru' => ['questions']];

    public function test_BaseQueryString_Ok()
    {
        $environment = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/ru/search',
            'QUERY_STRING'   => 'q=Apple',
        ]);
        $request = \Slim\Http\Request::createFromEnvironment($environment);
        $this->app->getContainer()['request'] = $request;

        $response = $this->app->run(true);
        $response_body = (string) $response->getBody();

        $this->assertStringContainsString('Поиск: Apple – Answeropedia', $response_body);

        $this->assertStringNotContainsString('NEED_TRANSLATE', $response_body);
        $this->assertSame(200, $response->getStatusCode());
    }

    public function test_Search_QueryWithoutQuery_EmptyPage()
    {
        $environment = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI'    => '/ru/search',
        ]);
        $request = \Slim\Http\Request::createFromEnvironment($environment);
        $this->app->getContainer()['request'] = $request;

        $response = $this->app->run(true);
        $response_body = (string) $response->getBody();

        $this->assertStringContainsString('Поиск:  – Answeropedia', $response_body);

        $this->assertStringNotContainsString('NEED_TRANSLATE', $response_body);
        $this->assertSame(200, $response->getStatusCode());
    }
}
