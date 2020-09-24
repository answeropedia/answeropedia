<?php

namespace Test\Mapper\Activity\UUA\create;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['activities']];

    public function test__Create_with_full_params()
    {
        $user = new \Model\User();
        $user->id = 46;
        $user->name = 'Steve Bo';

        $question = \Model\Question::initWithDBState([
            'q_id'             => 13,
            'q_title'          => 'This is question?',
            'q_is_redirect'    => 1,
            'a_text'           => 'Yes, it is!',
            'a_len'            => 11,
            'a_updated_at'     => '2015-11-29 09:28:34',
            'count_categories' => 0,
        ]);

        $revision = \Model\Revision::initWithDBState([
            'rev_id'         => 13,
            'rev_answer_id'  => 11,
            'rev_opcodes'    => 'opCodes',
            'rev_base_text'  => 'Ответ на вопрос про птиц.',
            'rev_comment'    => 'Rev comment',
            'rev_parent_id'  => 2,
            'rev_user_id'    => 14,
            'rev_created_at' => '2015-12-16 13:28:56',
        ]);

        $activity = new \Model\Activity();
        $activity->type = \Model\Activity::F_U_UPDATE_A;
        $activity->subject = $user;
        $activity->data = ['question' => $question, 'revision' => $revision];

        $activity = (new \Mapper\Activity\UUpdateA('ru'))->create($activity);

        $this->assertEquals(13, $activity->id);
        $this->assertEquals(\Model\Activity::F_U_UPDATE_A, $activity->type);
    }
}
