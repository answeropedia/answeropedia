<?php

namespace Query\Redirects;

class Question extends \Query\Query
{
    public function redirectForQuestionWithID(int $questionID): \Model\Redirect\Question
    {
        \Validator\Question::validateID($questionID);

        $stmt = $this->pdo->prepare('SELECT * FROM redirects_questions WHERE rd_from=:rd_from LIMIT 1');
        $stmt->bindParam(':rd_from', $questionID, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) {
            throw new \Exception('Redirect for question with ID "' . $questionID . '" not exists', 1);
        }

        return \Model\Redirect\Question::initWithDBState($row);
    }
}
