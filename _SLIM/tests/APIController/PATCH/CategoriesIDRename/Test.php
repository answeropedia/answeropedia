<?php

namespace Tests\APIController\PATCH\CategoriesIDRename;

class Test extends \Test\TestCase\Frontend
{
    protected $setUpDB = ['ru' => ['categories', 'activities', 'redirects_categories'], 'users' => ['users']];

    public function test__Rename_category_with_save_redirect()
    {
        $uri = '/api/v1/ru/categories/9/rename.json';
        $post_data = [
            'api_key'       => '7d21ebdbec3d4e396043c96b6ab44a6e',
            'new_title'     => 'Исследование почвы',
            'save_redirect' => 'true',
        ];

        $request = $this->createRequest('PATCH', $uri);
        $request = $this->withFormData($request, $post_data);

        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'category' => [
                'id'        => 9,
                'old_title' => 'Почвоведение',
                'new_title' => 'Исследование почвы',
                'url'       => 'https://answeropedia.org/ru/category/%D0%98%D1%81%D1%81%D0%BB%D0%B5%D0%B4%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5_%D0%BF%D0%BE%D1%87%D0%B2%D1%8B',
            ],
            'user' => [
                'id'   => 3,
                'name' => 'Иван Коршунов',
            ],
            'redirect' => [
                'from_id'  => 19,
                'to_title' => 'Исследование почвы',
            ],
            'activities' => [
                [
                    'id'   => 13,
                    'type' => 'USER_RENAME_CATEGORY',
                ],
                [
                    'id'   => 14,
                    'type' => 'CATEGORY_RENAMED_BY_USER',
                ],
            ],
        ];

        $this->assertEquals($expected_response, json_decode($response_body, true));
        $this->assertSame(200, $response->getStatusCode());
    }

    public function test__Rename_category_without_saving_redirect()
    {
        $uri = '/api/v1/ru/categories/9/rename.json';
        $post_data = [
            'api_key'       => '7d21ebdbec3d4e396043c96b6ab44a6e',
            'new_title'     => 'Наука о почвах',
        ];

        $request = $this->createRequest('PATCH', $uri);
        $request = $this->withFormData($request, $post_data);

        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'category' => [
                'id'        => 9,
                'old_title' => 'Почвоведение',
                'new_title' => 'Наука о почвах',
                'url'       => 'https://answeropedia.org/ru/category/%D0%9D%D0%B0%D1%83%D0%BA%D0%B0_%D0%BE_%D0%BF%D0%BE%D1%87%D0%B2%D0%B0%D1%85',
            ],
            'user' => [
                'id'   => 3,
                'name' => 'Иван Коршунов',
            ],
            'activities' => [
                [
                    'id'   => 13,
                    'type' => 'USER_RENAME_CATEGORY',
                ],
                [
                    'id'   => 14,
                    'type' => 'CATEGORY_RENAMED_BY_USER',
                ],
            ],
        ];

        $this->assertEquals($expected_response, json_decode($response_body, true));
        $this->assertSame(200, $response->getStatusCode());
    }

    public function test__Change_category_char_case_without_add_redirect()
    {
        $uri = '/api/v1/ru/categories/9/rename.json';
        $post_data = [
            'api_key'       => '7d21ebdbec3d4e396043c96b6ab44a6e',
            'new_title'     => 'ПочвоВедение',
        ];

        $request = $this->createRequest('PATCH', $uri);
        $request = $this->withFormData($request, $post_data);

        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'category' => [
                'id'        => 9,
                'old_title' => 'Почвоведение',
                'new_title' => 'ПочвоВедение',
                'url'       => 'https://answeropedia.org/ru/category/%D0%9F%D0%BE%D1%87%D0%B2%D0%BE%D0%92%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D0%B5',
            ],
            'user' => [
                'id'   => 3,
                'name' => 'Иван Коршунов',
            ],
            'activities' => [
                [
                    'id'   => 13,
                    'type' => 'USER_RENAME_CATEGORY',
                ],
                [
                    'id'   => 14,
                    'type' => 'CATEGORY_RENAMED_BY_USER',
                ],
            ],
        ];

        $this->assertEquals($expected_response, json_decode($response_body, true));
        $this->assertSame(200, $response->getStatusCode());
    }

    public function test__Change_category_char_case_with_add_redirect()
    {
        $uri = '/api/v1/ru/categories/9/rename.json';
        $post_data = [
            'api_key'       => '7d21ebdbec3d4e396043c96b6ab44a6e',
            'new_title'     => 'ПочвоВедение',
            'save_redirect' => 1,
        ];

        $request = $this->createRequest('PATCH', $uri);
        $request = $this->withFormData($request, $post_data);

        $response = $this->request($request);
        $response_body = (string) $response->getBody();

        $expected_response = [
            'category' => [
                'id'        => 9,
                'old_title' => 'Почвоведение',
                'new_title' => 'ПочвоВедение',
                'url'       => 'https://answeropedia.org/ru/category/%D0%9F%D0%BE%D1%87%D0%B2%D0%BE%D0%92%D0%B5%D0%B4%D0%B5%D0%BD%D0%B8%D0%B5',
            ],
            'user' => [
                'id'   => 3,
                'name' => 'Иван Коршунов',
            ],
            'activities' => [
                [
                    'id'   => 13,
                    'type' => 'USER_RENAME_CATEGORY',
                ],
                [
                    'id'   => 14,
                    'type' => 'CATEGORY_RENAMED_BY_USER',
                ],
            ],
        ];

        $this->assertEquals($expected_response, json_decode($response_body, true));
        $this->assertSame(200, $response->getStatusCode());
    }
}
