<?php

namespace Test\Query\Search\searchQuestions;

class QueryTest extends \Test\TestCase\DB
{
    public function test__Query_string_is_empty()
    {
        $this->expectExceptionMessage('Search query param "" must have a length between 2 and 32');
        $questions = (new \Query\Search('ru'))->searchQuestions('');
    }

    public function test__Query_string_below_3()
    {
        $this->expectExceptionMessage('Search query param "A" must have a length between 2 and 32');
        $questions = (new \Query\Search('ru'))->searchQuestions('A');
    }

    public function test__Query_string_greater_then_64()
    {
        $this->expectExceptionMessage('Search query param "some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text" must have a length between 2 and 32');
        $questions = (new \Query\Search('ru'))->searchQuestions('some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text some text');
    }
}
