<?php

namespace Test\Mapper\Category\update;

class TitleTest extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['categories']];

    public function test_Exception_when_title_is_empty()
    {
        $category = new \Model\Category();
        $category->id = 2;
        $category->title = '';

        $this->expectExceptionMessage('Category title param "" must have a length between 2 and 127');
        $category = (new \Mapper\Category('ru'))->update($category);
    }

    public function test_Exception_when_title_too_short()
    {
        $category = new \Model\Category();
        $category->id = 2;
        $category->title = 'x';

        $this->expectExceptionMessage('Category title param "x" must have a length between 2 and 127');
        $category = (new \Mapper\Category('ru'))->update($category);
    }

    public function test_Exception_when_title_too_long()
    {
        $category = new \Model\Category();
        $category->id = 2;
        $category->title = 'title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title';

        $this->expectExceptionMessage('Category title param "title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title_42_title" must have a length between 2 and 127');
        $category = (new \Mapper\Category('ru'))->update($category);
    }
}
