<?php

namespace Test\Mapper\Activity\QUA\create;

class Test extends \Test\TestCase\DB
{
    protected $setUpDB = ['ru' => ['activities']];

    public function test__Create_with_full_params()
    {
        $question = \Model\Question::initWithTitle('Когда закончится дождь?');

        $answer = new \Model\Answer();
        $answer->text = 'Melody of my life.';

        $user = new \Model\User();
        $user->id = 13;
        $user->name = 'Boris Bro';
        $user->email = 'steve@aw.org';

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
        $activity->type = \Model\Activity::F_Q_UPDATE_A;
        $activity->subject = $question;
        $activity->data = ['user' => $user, 'revision' => $revision];

        $activity = (new \Mapper\Activity\QUpdateA('ru'))->create($activity);

        $this->assertEquals(13, $activity->id);
        $this->assertEquals(\Model\Activity::F_Q_UPDATE_A, $activity->type);
    }
}
