<?php

class Model_Redirect_initWithDBState_Test extends PHPUnit\Framework\TestCase
{
    public function test_InitWithBaseParams_ReturnObject()
    {
        $redirect = Redirect_Model::initWithDBState([
            'rd_from' => 13,
            'rd_title' => 'This is question?',
        ]);

        $this->assertEquals(13, $redirect->getFromID());
        $this->assertEquals('This is question?', $redirect->getRedirectTitle());
    }
}