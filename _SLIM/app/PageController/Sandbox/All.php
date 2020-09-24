<?php

namespace PageController\Sandbox;

class All extends \PageController\PageController
{
    const LIST_NEWEST = 'newest';
    const LIST_WITH_ANSWERS = 'with-answers';
    const LIST_WITHOUT_ANSWERS = 'without-answers';

    const QUESTIONS_PER_PAGE = 10;

    public function handle($request, $response, $args)
    {
        $lang = $request->getAttribute('lang');

        $this->list = 'newest';

        $query_params = $request->getQueryParams();
        $this->page = @$query_params['page'] ? (int) $query_params['page'] : 1;

        $this->lang = $lang;

        $questionsCount = (new \Query\QuestionsCount($this->lang))->questionsLastID();

        $this->questions = (new \Query\Questions($this->lang))->findNewest($this->page);

        foreach ($this->questions as $question) {
            if ($question->isRedirect) {
                $redirect = (new \Query\Redirects\Question($this->lang))->redirectForQuestionWithID($question->id);
                $this->redirects[$question->id] = $redirect;
            }
        }

        $this->template = 'sandbox';
        $this->pageTitle = $this->_get_page_title();
        $this->pageDescription = $this->_get_page_description();

        if ($this->questions[9]->id > 1) {
            $this->nextPageURL = \Helper\URL\Sandbox::getAllURL($this->lang, ($this->page + 1));
        }

        $output = $this->render_page();
        $response->getBody()->write($output);

        return $response;
    }

    //
    // Helper methods
    //

    public function _get_page_title()
    {
        return __('page_sandbox.title') . ' – ' . __('common.page') . ' ' . $this->page . ' – ' . __('common.answeropedia');
    }

    public function _get_page_description(): string
    {
        $description = __('page_sandbox.title') . ' – ' . __('common.page') . ' ' . $this->page . ' – ' . __('common.answeropedia');

        return $description;
    }
}
