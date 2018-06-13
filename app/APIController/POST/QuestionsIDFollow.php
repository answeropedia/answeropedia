<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class QuestionsIDFollow_POST_APIController extends Abstract_APIController
{
    public function handle(Request $request, Response $response, $args): Response
    {
        try {
            $this->lang = $args['lang'];
            $this->l = Localizer::getInstance($this->lang);

            $api_key = (string) $request->getParam('api_key');
            $question_id = (int) $args['id'];

            #
            # Validate params
            #

            $user = (new User_Query())->userWithAPIKey($api_key);
            $userID = $user->getID();

            $question = (new Question_Query($this->lang))->questionWithID($question_id);
            $questionID = $question->getID();

            $relation = (new UsersFollowQuestions_Relations_Query($this->lang))->relationWithUserIDAndQuestionID($userID, $questionID);
            if ($relation) {
                throw new Exception('User with ID "'.$userID.'" already followed question with ID "'.$questionID.'"', 0);
            }

            #
            # Save follow relation
            #

            $relation = new UserFollowQuestion_Relation_Model();
            $relation->setUserID($userID);
            $relation->setQuestionID($questionID);

            $relation = (new UserFollowQuestion_Relation_Mapper($this->lang))->create($relation);

            #
            # Create activity
            #

            $activity = new Activity_Model();
            $activity->setType(Activity_Model::F_U_FOLLOW_Q);
            $activity->setSubject($user);
            $activity->setData($question);

            $activity = (new UFollowQ_Activity_Mapper($this->lang))->create($activity);

            $output = [
                'lang' => $this->lang,
                'relation_id' => $relation->getID(),
                'user_id' => $user->getID(),
                'user_name' => $user->getName(),
                'followed_question_id' => $question->getID(),
                'followed_question_title' => $question->getTitle(),
            ];
        } catch (Throwable $e) {
            $output = [
                'error_code' => $e->getCode(),
                'error_message' => $e->getMessage(),
            ];
        }

        $json = json_encode($output, JSON_UNESCAPED_UNICODE);

        return $response->withHeader('Content-Type', 'application/json')->write($json);
    }
}