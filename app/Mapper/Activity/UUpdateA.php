<?php

class UUpdateA_Activity_Mapper extends Abstract_Mapper
{
    public function create(Activity_Model $activity): Activity_Model
    {
        $activity_type = $activity->getType();
        $user = $activity->getSubject();

        if (!isset($activity->getData()['question']) || !isset($activity->getData()['revision'])) {
            throw new Exception("Incorrect data param", 1);
        }

        $question = $activity->getData()['question'];
        $revision = $activity->getData()['revision'];

        if ($activity_type != Activity_Model::F_U_UPDATE_A) {
            throw new Exception("Incorrect activity type \"$activity_type\"", 0);
        }
        if (!is_a($user, User_Model::class)) {
            throw new Exception('Incorrect activity "subject" class type: '.get_class($user), 0);
        }
        if (!is_a($question, Question_Model::class)) {
            throw new Exception('Incorrect activity "data" class type: '.get_class($question), 0);
        }
        if (!is_a($revision, Revision_Model::class)) {
            throw new Exception('Incorrect activity "data" class type: '.get_class($revision), 0);
        }

        $userID = $user->getID();
        $data = json_encode([
            'user' => [
                'id' => $user->getID(),
                'name' => $user->getName(),
                'profile_url' => $user->getURL($this->lang),
                'avatar_xs_url' => $user->getAvatarSmallURL(),
            ],
            'question' => [
                'title' => $question->getTitle(),
                'url' => $question->getURL($this->lang),
            ],
            'revision' => [
                'diff_text' => FineDiff::renderDiffToHTMLFromOpcodes($revision->getBaseText(), $revision->getOpcodes()),
                'comment' => $revision->getComment(),
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