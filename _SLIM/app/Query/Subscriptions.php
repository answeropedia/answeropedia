<?php

namespace Query;

class Subscriptions extends \Query\Query
{
    public function findWithQuestionIDAndEmail(int $question_id, string $email)
    {
        \Validator\Question::validateID($question_id);
        \Validator\User::validateEmail($email);

        $stmt = $this->pdo->prepare('SELECT * FROM questions_subscriptions WHERE s_question_id=:s_question_id AND s_email=:s_email LIMIT 1');
        $stmt->bindParam(':s_question_id', $question_id, \PDO::PARAM_INT);
        $stmt->bindParam(':s_email', $email, \PDO::PARAM_STR);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            return;
        }

        return \Model\Subscription::initWithDBState($row);
    }
}
