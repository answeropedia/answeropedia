<?php

class Mapper_Activity_UAQ__create__Test extends Abstract_DB_TestCase
{
    protected $setUpDB = ['ru' => ['activities']];

    public function test_CreateWithFullParams_Ok()
    {
        $user = new User_Model;
        $user->setID(46);
        $user->setName('Steve Bo');

        $question = Question_Model::initWithTitle('Когда закончится дождь?');

        $activity = new Activity_Model();
        $activity->type = Activity_Model::F_U_ASKED_Q;
        $activity->subject = $user;
        $activity->data = $question;

        $activity = (new UAskedQ_Activity_Mapper('ru'))->create($activity);

        $this->assertEquals(13, $activity->getID());
        $this->assertEquals(Activity_Model::F_U_ASKED_Q, $activity->type);
    }
}
