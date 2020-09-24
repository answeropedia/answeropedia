<?php

namespace PageController\Answer;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Edit extends \PageController\PageController
{
    public function handle(Request $request, Response $response, $args): Response
    {
        $lang = $request->getAttribute('lang');
        $answer_ID = $request->getAttribute('id');

        $this->lang = $lang;

        try {
            $this->question = (new \Query\Question($this->lang))->questionWithID($answer_ID);
        } catch (\Throwable $e) {
            return (new \PageController\Error\InternalServerError())->handle($request, $response);
        }

        $this->answer = (new \Query\Answers($this->lang))->answerWithID($this->question->id);

        if ($this->answer == null) {
            $answer = new \Model\Answer();
            $answer->id = $this->question->id;
            $answer->text = null;

            $this->answer = (new \Mapper\Answer($this->lang))->create($answer);
        }

        $this->question_how_to_edit = $this->_get_how_to_edit_question();

        $this->template = 'answer_edit';
        $this->showFooter = false;
        $this->pageTitle = $this->question->title . ' – ' . __('page_answer_edit.page_title') . ' – ' . __('common.answeropedia');
        $this->pageDescription = __('page_answer_edit.page_title');

        $this->includeJS[] = 'answer/update.js?v=1';
        $this->includeCSS[] = 'https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css';

        $output = $this->render_page();
        $response->getBody()->write($output);

        return $response;
    }

    private function _get_how_to_edit_question()
    {
        try {
            $how_to_edit_question_ID = (int) __('service_id.how_to_edit');
            $how_to_edit_question = (new \Query\Question($this->lang))->questionWithID($how_to_edit_question_ID);
        } catch (\Throwable $e) {
            $how_to_edit_question = null;
        }

        return $how_to_edit_question;
    }
}
