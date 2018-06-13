<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class UsersIDFollow_DELETE_APIController extends Abstract_APIController
{
    public function handle(Request $request, Response $response, $args): Response
    {
        try {
            $this->lang = $args['lang'];
            $followedUserID = (int) $args['id'];
            $api_key = (string) $request->getParam('api_key');

            $this->l = Localizer::getInstance($this->lang);

            #
            # Validate params
            #

            $user = (new User_Query())->userWithAPIKey($api_key);
            $userID = $user->getID();

            $followed_user = (new User_Query())->userWithID($followedUserID);

            $relation = (new UsersFollowUsers_Relations_Query($this->lang))->relationWithUserIDAndFollowedUserID($userID, $followedUserID);
            if (!$relation) {
                throw new Exception('User with ID "'.$followedUserID.'" not followed by user with ID "'.$userID.'"', 0);
            }

            #
            # Delete follow record
            #

            (new UserFollowUser_Relation_Mapper($this->lang))->deleteRelation($relation);

            $output = [
                'user_id' => $user->getID(),
                'user_name' => $user->getName(),
                'followed_user_id' => $followed_user->getID(),
                'followed_user_name' => $followed_user->getName(),
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