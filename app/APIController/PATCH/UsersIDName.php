<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class UsersIDName_PATCH_APIController extends Abstract_APIController
{
    public function handle(Request $request, Response $response, $args): Response
    {
        try {
            $this->lang = $args['lang'];
            $this->l = Localizer::getInstance($this->lang);

            $api_key = (string) $request->getParam('api_key');
            $userID = (int) $args['id'];
            $name = $request->getParam('name');

            # Validate params

            if (!$name) {
                throw new Exception('User "name" property null must be a string', 0);
            }

            $user = (new User_Query())->userWithAPIKey($api_key);
            $oldName = $user->getName();

            if ($user->getID() != $userID) {
                throw new \Exception("Incorrect user id or API-key", 0);
            }

            # Change user signature

            $user->setName($name);
            $user = (new User_Mapper())->update($user);

            $output = [
                'user' => [
                    'id' => $user->getID(),
                    'name' => $user->getName(),
                    'name_old' => $oldName,
                ],
                'message' => 'Name saved!',
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