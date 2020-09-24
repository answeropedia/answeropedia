<?php

namespace APIController\POST;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsersIDFollow extends \APIController\APIController
{
    public function handle(Request $request, Response $response, $args): Response
    {
        try {
            $lang = $request->getAttribute('lang');

            $post_params = $request->getParsedBody();
            $api_key = (string) $post_params['api_key'];
            $followed_user_ID = (int) $request->getAttribute('id');

            //
            // Validate params
            //

            $user = (new \Query\User())->userWithAPIKey($api_key);

            $followed_user = (new \Query\User())->userWithID($followed_user_ID);

            $relation = (new \Query\Relations\UsersFollowUsers($lang))->relationWithUserIDAndFollowedUserID($user->id, $followed_user_ID);
            if ($relation) {
                throw new \Exception('User with ID "' . $followed_user_ID . '" already followed by user with ID "' . $user->id . '"', 0);
            }

            //
            // Create follow record
            //

            $relation = new \Model\Relation\UserFollowUser();
            $relation->userID = $user->id;
            $relation->followedUserID = $followed_user_ID;

            $relation = (new \Mapper\Relation\UserFollowUser($lang))->create($relation);

            // Create activity

            $activity = new \Model\Activity();
            $activity->type = \Model\Activity::F_U_FOLLOW_U;
            $activity->subject = $user;
            $activity->data = $followed_user;

            $activity = (new \Mapper\Activity\UFollowU($lang))->create($activity);

            $output = [
                'relation_id'        => $relation->id,
                'user_id'            => $user->id,
                'user_name'          => $user->name,
                'followed_user_id'   => $followed_user->id,
                'followed_user_name' => $followed_user->name,
            ];
        } catch (\Throwable $e) {
            $output = [
                'error_code'    => $e->getCode(),
                'error_message' => $e->getMessage(),
            ];
        }

        $json = json_encode($output, JSON_UNESCAPED_UNICODE);

        return $response->withHeader('Content-Type', 'application/json')->write($json);
    }
}
