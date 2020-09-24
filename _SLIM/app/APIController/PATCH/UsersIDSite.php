<?php

namespace APIController\PATCH;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UsersIDSite extends \APIController\APIController
{
    public function handle(Request $request, Response $response, $args): Response
    {
        try {
            $lang = $request->getAttribute('lang');
            $userID = (int) $request->getAttribute('id');

            $request_body_params = $request->getParsedBody();
            $api_key = (string) $request_body_params['api_key'];
            $new_site = @$request_body_params['site'];

            // Validate params

            if (!$new_site) {
                throw new \Exception('User "site" property null must be a string', 0);
            }

            $user = (new \Query\User())->userWithAPIKey($api_key);
            $old_site = $user->site;

            if ($user->id != $userID) {
                throw new \Exception('Incorrect user id or API-key', 0);
            }

            // Change user signature

            $user->site = $new_site;
            $user = (new \Mapper\User())->update($user);

            $output = [
                'user' => [
                    'id'       => $user->id,
                    'name'     => $user->name,
                    'site_old' => $old_site,
                    'site_new' => $new_site,
                ],
                'message' => 'User site saved!',
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
