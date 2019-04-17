<?php

class URenameQ_Activity_Mapper extends Abstract_Mapper
{
    public function create(Activity_Model $activity): Activity_Model
    {
        $activity_type = $activity->type;
        if ($activity_type != Activity_Model::U_RENAME_Q) {
            throw new Exception("Incorrect activity type \"$activity_type\"", 0);
        }

        $user = $activity->subject;
        if (!is_a($user, User_Model::class)) {
            throw new Exception('Incorrect activity "subject" class type: '.get_class($user), 0);
        }

        if (!isset($activity->data['question']) || !isset($activity->data['old_title'])) {
            throw new Exception("Incorrect data param", 1);
        }
        $question = $activity->data['question'];
        $old_title = $activity->data['old_title'];
        if (!is_a($question, Question_Model::class)) {
            throw new Exception('Incorrect activity "data" class type: '.get_class($question), 0);
        }
        if (!is_string($old_title)) {
            throw new Exception('Incorrect activity "data" type of old_title', 0);
        }

        $userID = $user->getID();
        $data = json_encode([
            'user' => [
                'id' => $user->getID(),
                'name' => $user->name,
                'profile_url' => $user->getURL($this->lang),
                'avatar_xs_url' => $user->getAvatarSmallURL(),
            ],
            'question' => [
                'title_old' => $old_title,
                'title_new' => $question->title,
                'url' => $question->getURL($this->lang),
            ]
        ], JSON_UNESCAPED_UNICODE);

        $sql = 'INSERT INTO activities (u_id, activity_type, data) VALUES (:user_id, :activity_type, :data)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':activity_type', $activity_type, PDO::PARAM_STR);
        $stmt->bindParam(':data', $data, PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();
            throw new Exception($error[2], $error[1]);
        }

        $activity->setID((int) $this->pdo->lastInsertId());
        if ($activity->getID() === 0) {
            throw new Exception('Activity not saved', 1);
        }

        return $activity;
    }
}
