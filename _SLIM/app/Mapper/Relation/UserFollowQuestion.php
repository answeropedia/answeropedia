<?php

namespace Mapper\Relation;

class UserFollowQuestion extends \Mapper\Mapper
{
    public function create(\Model\Relation\UserFollowQuestion $relation): \Model\Relation\UserFollowQuestion
    {
        \Validator\Relation\UserFollowQuestion::validateNew($relation);

        $sql = 'INSERT INTO er_users_follow_questions (user_id, question_id) VALUES (:user_id, :question_id)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $relation->userID, \PDO::PARAM_INT);
        $stmt->bindParam(':question_id', $relation->questionID, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $relation->id = (int) $this->pdo->lastInsertId();
        if ($relation->id === 0) {
            throw new \Exception('UserFollowQuestion relation not saved', 1);
        }

        return $relation;
    }

    private function update(\Model\Relation\UserFollowQuestion $relation)
    {
        throw new \Exception('UserFollowQuestion relation "update" method not applicable', 0);
    }

    public function delete_relation(\Model\Relation\UserFollowQuestion $relation): bool
    {
        \Validator\Relation\UserFollowQuestion::validateExists($relation);

        $sql = 'DELETE FROM er_users_follow_questions WHERE question_id=:question_id AND user_id=:user_id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $relation->userID, \PDO::PARAM_INT);
        $stmt->bindParam(':question_id', $relation->questionID, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        if ($stmt->rowCount() == 0) {
            throw new \Exception('UserFollowQuestion relation not deleted', 1);
        }

        return true;
    }
}
