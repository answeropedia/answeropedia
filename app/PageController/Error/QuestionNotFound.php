<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class QuestionNotFound_Error_PageController extends Abstract_PageController
{
    public function handle(string $lang, Request $request, Response $response, $args): Response
    {
        $this->lang = $lang;
        $this->l = Localizer::getInstance($this->lang);

        $questionURI = $args['question_uri'];

        $this->questionTitle = Question_URL_Helper::titleFromURI($questionURI);

        $question = new Question_Model();
        $question->setTitle($this->questionTitle);

        $this->template = 'error/question_not_found';
        $this->showFooter = false;
        $this->pageTitle = _('Question not found - Page title').' '.$this->questionTitle.' - '._('OctoAnswers');
        $this->pageDescription = _('Question not found - Page description');

        $this->questionURI = $questionURI;
        $this->additionalJavascript[] = 'goal/question_not_found';

        $output = $this->renderPage();
        $response->getBody()->write($output);

        return $response->withStatus(404);
    }
}
