<?php

class Mapper_Activity_UUA__create__Test extends Abstract_DB_TestCase
{
    protected $setUpDB = ['ru' => ['activities']];

    public function test_CreateWithFullParams_Ok()
    {
        $user = new User_Model;
        $user->setID(46);
        $user->setName('Steve Bo');

        $question = Question_Model::initWithDBState([
            'q_id' => 13,
            'q_title' => 'This is question?',
            'q_is_redirect' => 1,
            'a_text' => 'Yes, it is!',
            'a_len' => 11,
            'a_updated_at' => '2015-11-29 09:28:34'
        ]);

        $revision = Revision_Model::initWithDBState([
            'rev_id' => 13,
            'rev_answer_id' => 11,
            'rev_opcodes' => 'opCodes',
            'rev_base_text' => 'Ответ на вопрос про птиц.',
            'rev_comment' => 'Rev comment',
            'rev_parent_id' => 2,
            'rev_user_id' => 14,
            'rev_created_at' => '2015-12-16 13:28:56',
        ]);

        $activity = new Activity_Model();
        $activity->setType(Activity_Model::F_U_UPDATE_A);
        $activity->setSubject($user);
        $activity->setData([ 'question' => $question, 'revision' => $revision]);

        $activity = (new UUpdateA_Activity_Mapper('ru'))->create($activity);

        $this->assertEquals(13, $activity->getID());
        $this->assertEquals(Activity_Model::F_U_UPDATE_A, $activity->getType());
    }
}