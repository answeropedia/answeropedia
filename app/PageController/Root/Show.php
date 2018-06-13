<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Show_Root_PageController extends Abstract_PageController
{
    public function handle(Request $request, Response $response, $args): Response
    {
        $supported_languages = Lang::getSupportedLangs();
        $default_language = Lang::getDefaultLang();

        $this->lang = $default_language;

        $this->l = Localizer::getInstance($this->lang);

        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $this->lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

            if (!in_array($this->lang, $supported_languages)) {
                $this->lang = $default_language;
            }
        }

        $this->template = 'root/show';
        $this->showFooter = false;
        $this->pageTitle = $this->l->t('octoanswers');
        $this->pageDescription = $this->l->t('Ask a question and get complete and competent answer');
        $this->canonicalURL = SITE_URL;

        $output = $this->renderPage();
        $response->getBody()->write($output);

        return $response;
    }
}