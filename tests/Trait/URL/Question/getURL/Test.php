<?php

class Question_URL_Trait__getURL__Test extends PHPUnit\Framework\TestCase
{
    public function test_baseURI()
    {
        $question = new Question_Model();
        $question->setID(19);
        $question->setTitle('How iPhone 8 are charged?');

        $this->assertEquals('http://octoanswers.com/en/19/how-iphone-8-are-charged', $question->getURL('en'));
    }

    public function test_RuTitle()
    {
        $question = new Question_Model();
        $question->setID(18);
        $question->setTitle('Можно ли сохранить массив в COOKIE?');

        $this->assertEquals('http://octoanswers.com/ru/18/mozhno-li-sohranit-massiv-v-cookie', $question->getURL('ru'));
    }
}