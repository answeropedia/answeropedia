<?php

class Hashtag_Query__findWithTitle__ru__Test extends Abstract_DB_TestCase
{
    protected $setUpDB = ['ru' => ['hashtags']];

    public function test__HastagExists()
    {
        $hashtag = (new Hashtag_Query('ru'))->findWithTitle('парфюмерия');

        $this->assertEquals(8, $hashtag->id);
        $this->assertEquals('парфюмерия', $hashtag->title);
    }

    public function test__HashtagNotExists()
    {
        $hashtag = (new Hashtag_Query('ru'))->findWithTitle('notexists');

        $this->assertEquals(null, $hashtag);
    }
}