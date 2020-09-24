<?php

namespace Query;

class Answers extends \Query\Query
{
    public function answerWithID(int $answerID)
    {
        \Validator\Answer::validateID($answerID);

        $this->pdo = \Helper\PDOFactory::getConnectionToLangDB($this->lang);

        $stmt = $this->pdo->prepare('SELECT * FROM questions WHERE q_id=:q_id LIMIT 1');
        $stmt->bindParam(':q_id', $answerID, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }
        if (!$row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return;
        }

        return \Model\Answer::initWithDBState($row);
    }
}
