<?php

class Show_Category_PageController__ru__Test extends Abstract_Frontend_TestCase
{
    protected $setUpDB = ['ru' => ['questions', 'categories', 'er_categories_questions', 'er_users_follow_categories']];

    public function test__ShowPage()
    {
        $environment = \Slim\Http\Environment::mock([
            'REQUEST_METHOD' => 'GET',
            'REQUEST_URI' => '/ru/category/Птицы',
        ]);
        $request = \Slim\Http\Request::createFromEnvironment($environment);
        $this->app->getContainer()['request'] = $request;

        $response = $this->app->run(true);
        $responseBody = (string) $response->getBody();

        $this->assertStringContainsString('Категория: Птицы – Answeropedia', $responseBody);
        $this->assertSame(200, $response->getStatusCode());
    }
}
