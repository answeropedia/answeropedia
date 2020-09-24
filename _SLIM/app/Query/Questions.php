<?php

namespace Query;

use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as v;

class Questions extends \Query\Query
{
    const QUESTIONS_PER_PAGE = 10; // @TODO double

    public function findNewest($page = 1, $perPage = 10): array
    {
        \Validator\QuestionsList::validatePage($page);
        \Validator\QuestionsList::validatePerPage($perPage);

        $this->pdo = \Helper\PDOFactory::getConnectionToLangDB($this->lang);

        $questionsLastID = (new \Query\QuestionsCount($this->lang))->questionsLastID();

        $offset = $questionsLastID - ($perPage * $page);

        $stmt = $this->pdo->prepare('SELECT * FROM `questions` WHERE `q_id` > :id_offset LIMIT :per_page');
        $stmt->bindParam(':id_offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':per_page', $perPage, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($rows as $row) {
            $questions[] = \Model\Question::initWithDBState($row);
        }

        return array_reverse($questions);
    }

    public function findRecentlyUpdated($page = 0, $perPage = 10): array
    {
        //\Validator\QuestionsList::validatePage($page);
        \Validator\QuestionsList::validatePerPage($perPage);

        $this->pdo = \Helper\PDOFactory::getConnectionToLangDB($this->lang);

        $offset = $perPage * $page;

        $query = 'SELECT * FROM `questions` WHERE (a_len > 0) ORDER BY `questions`.`a_updated_at` DESC LIMIT :offset, :per_page';
        //$query = 'SELECT * FROM `questions` ORDER BY `questions`.`a_updated_at` DESC';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':per_page', $perPage, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($rows as $row) {
            $questions[] = \Model\Question::initWithDBState($row);
        }

        return $questions;
    }

    public function findQuestionsWithImage(int $offset = 0, int $limit = 3): array
    {
        // @TODO Check params
        // \Validator\QuestionsList::validatePage($page);
        // \Validator\QuestionsList::validatePerPage($perPage);

        $this->pdo = \Helper\PDOFactory::getConnectionToLangDB($this->lang);

        $query = 'SELECT * FROM `questions` WHERE (`q_id` < :id_offset AND q_image_base_name IS NOT NULL) ORDER BY q_id DESC LIMIT :limit_count';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id_offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':limit_count', $limit, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($rows as $row) {
            $questions[] = \Model\Question::initWithDBState($row);
        }

        return $questions;
    }

    public function findNewestWithAnswer($page = 1, $perPage = 10): array
    {
        \Validator\QuestionsList::validatePage($page);
        \Validator\QuestionsList::validatePerPage($perPage);

        $this->pdo = \Helper\PDOFactory::getConnectionToLangDB($this->lang);

        $offset = $perPage * ($page - 1);

        $stmt = $this->pdo->prepare('SELECT * FROM `questions` WHERE a_len > 0 ORDER BY q_id DESC LIMIT :id_offset, :per_page');
        $stmt->bindParam(':id_offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':per_page', $perPage, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($rows as $row) {
            $questions[] = \Model\Question::initWithDBState($row);
        }

        return $questions;
    }

    /**
     * @throws NestedValidationException
     */
    public function search(string $query, int $questionsPage = 1, int $questionsPerPage = 10): array
    {
        try {
            v::stringType()->length(2, 32, true)->assert($query);
        } catch (NestedValidationException $e) {
            throw new \Exception('Search query param ' . $e->getMessages()[0], 0);
        }

        \Validator\QuestionsList::validatePage($questionsPage);
        \Validator\QuestionsList::validatePerPage($questionsPerPage);

        $id_offset = 0;

        $sql = "SELECT * FROM questions WHERE (q_title LIKE '%" . $query . "%') LIMIT :id_offset, :per_page";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_offset', $id_offset, \PDO::PARAM_INT);
        $stmt->bindParam(':per_page', $questionsPerPage, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($rows as $row) {
            $questions[] = \Model\Question::initWithDBState($row);
        }

        return $questions;
    }

    public function findCommunityChoice(int $page = 1, int $perPage = 10): array
    {
        \Validator\QuestionsList::validatePage($page);
        \Validator\QuestionsList::validatePerPage($perPage);

        $this->pdo = \Helper\PDOFactory::getConnectionToLangDB($this->lang);

        $offset = $perPage * ($page - 1);

        $stmt = $this->pdo->prepare('SELECT * FROM `questions_community_choice` ORDER BY id DESC LIMIT :id_offset, :per_page');
        $stmt->bindParam(':id_offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':per_page', $perPage, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $questions = [];
        foreach ($rows as $row) {
            $questionID = $row['q_id'];
            $question = (new \Query\Question($this->lang))->questionWithID($questionID);
            $questions[] = $question;
        }

        return $questions;
    }
}
