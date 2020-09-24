<?php

namespace Mapper\Activity;

class QRenamedByU extends \Mapper\Mapper
{
    public function create(\Model\Activity $activity): \Model\Activity
    {
        $activity_type = $activity->type;
        if ($activity_type != \Model\Activity::Q_RENAMED_BY_U) {
            throw new \Exception("Incorrect activity type \"$activity_type\"", 0);
        }

        $question = $activity->subject;
        if (!is_a($question, \Model\Question::class)) {
            throw new \Exception('Incorrect activity "data" class type: ' . get_class($question), 0);
        }

        if (!isset($activity->data['user']) || !isset($activity->data['old_title'])) {
            throw new \Exception('Incorrect data param', 1);
        }
        $user = $activity->data['user'];
        if (!is_a($user, \Model\User::class)) {
            throw new \Exception('Incorrect activity "subject" class type: ' . get_class($user), 0);
        }
        $old_title = $activity->data['old_title'];
        if (!is_string($old_title)) {
            throw new \Exception('Incorrect activity "data" type of old_title', 0);
        }

        $questionID = $question->id;
        $data = json_encode([
            'question' => [
                'title_old' => $old_title,
                'title_new' => $question->title,
                'url'       => $question->getURL($this->lang),
            ],
            'user' => [
                'id'            => $user->id,
                'name'          => $user->name,
                'profile_url'   => $user->getURL($this->lang),
                'avatar_xs_url' => $user->getAvatarURLSmall(),
            ],
        ], JSON_UNESCAPED_UNICODE);

        $sql = 'INSERT INTO activities (q_id, activity_type, data) VALUES (:q_id, :activity_type, :data)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':q_id', $questionID, \PDO::PARAM_INT);
        $stmt->bindParam(':activity_type', $activity_type, \PDO::PARAM_STR);
        $stmt->bindParam(':data', $data, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $activity->id = (int) $this->pdo->lastInsertId();
        if ($activity->id === 0) {
            throw new \Exception('Activity not saved', 1);
        }

        return $activity;
    }
}
