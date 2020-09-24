<?php

namespace Tests\APIController\PATCH\CategoriesIDRename;

class NewTitleTest extends \Test\TestCase\Frontend
{
    protected $setUpDB = [
        'ru'    => ['categories', 'activities', 'redirects_categories'],
        'users' => ['users'],
    ];

    public function test_Error_when_category_new_title_not_set()
    {
        $uri = '/api/v1/ru/categories/12/rename.json';
        $post_data = [
            'api_key'           => '7d21ebdbec3d4e396043c96b6ab44a6e',
            'not_new_title'     => 'abc',
            'save_redirect'     => 1,
        ];

        $request = $this->createRequest('PATCH', $uri);
        $request = $this->withFormData($request, $post_data);

        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'error_code'    => 0,
            'error_message' => 'Category title param "" must have a length between 2 and 127',
        ];

        $this->assertSame(200, $response->getStatusCode());
        $this->assertEquals($expected_response, json_decode($response_body, true));
    }

    public function test_Error_when_category_new_title_too_short()
    {
        $uri = '/api/v1/ru/categories/12/rename.json?api_key=7d21ebdbec3d4e396043c96b6ab44a6e&new_title=' . urlencode('z');

        $uri = '/api/v1/ru/categories/12/rename.json';
        $post_data = [
            'api_key'       => '7d21ebdbec3d4e396043c96b6ab44a6e',
            'new_title'     => 'z',
        ];

        $request = $this->createRequest('PATCH', $uri);
        $request = $this->withFormData($request, $post_data);

        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'error_code'    => 0,
            'error_message' => 'Category title param "z" must have a length between 2 and 127',
        ];

        $this->assertSame(200, $response->getStatusCode());
        $this->assertEquals($expected_response, json_decode($response_body, true));
    }
}
