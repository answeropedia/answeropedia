<?php

class Show_Topic_PageController extends Abstract_PageController
{
    protected $topic_questions;

    // @TODO Deprecated
    public function handleByURI($request, $response, $args)
    {
        $this->lang = $args['lang'];
        $topic_uri = $args['uri'];

        try {
            $topic_title = Topic_URL_Helper::titleFromURI($topic_uri);
            // var_dump($topic_title);
            // exit;
            $this->topic = (new Topic_Query($this->lang))->findWithTitle($topic_title);
            if ($this->topic === null) {
                throw new \Exception("Topic not exists", 1);
            }
        } catch (\Exception $e) {
            //return (new QuestionNotFound_Error_PageController($this->container))->handle($this->lang, $request, $response, $args);
            return (new InternalServerError_Error_PageController($this->container))->handle($this->lang, $request, $response, $args);
        }

        return $response->withRedirect($this->topic->getURL($this->lang), 301);
    }

    public function handle($request, $response, $args)
    {
        $this->lang = $args['lang'];
        $topic_id = $args['id'];
        $topic_uri_slug = $args['uri_slug'];

        try {
            $this->topic = (new Topic_Query($this->lang))->topicWithID($topic_id);
        } catch (\Exception $e) {
            //return (new QuestionNotFound_Error_PageController($this->container))->handle($this->lang, $request, $response, $args);
            return (new InternalServerError_Error_PageController($this->container))->handle($this->lang, $request, $response, $args);
        }

        $this->parsedown = new ExtendedParsedown($this->lang);

        $humanDateTimezone = new DateTimeZone('UTC');
        $dateHumanizer = new HumanDate($humanDateTimezone, $this->lang);

        $topic_questions = (new TopicsToQuestions_Relations_Query($this->lang))->findNewestFortopicWithID($this->topic->getID());
        foreach ($topic_questions as $topic_question_er) {
            //var_dump($topic_question_er);
            $this->topic_questions[] = (new Question_Query($this->lang))->questionWithID($topic_question_er->getQuestionID());

            //$question['date_humanized'] = $dateHumanizer->format($question->getCreatedAt());
        }

        // recount questions count if GET-param on 20% random
        try {
            // if ((mt_rand(0, 10) > 7) || isset($_GET['upd'])) {
            //     $questionsCount = api_v1_get_topics_ID_questions_count($args['topic_id']);
            //     $topic->setQuestionsCount($questionsCount);
            //     $topicMapper = new CategoryMapper($pdo);
            //     $topicMapper->saveTopic($topic);
            // }
        } catch (Throwable $e) {
            // do nothing
        }

        if (count($this->topic_questions) == 10) {
            $data['next_page_button'] = [
                'title' => _('Topic - Next page button'),
                'url' => '#',
            ];
        }

        //$data['alternate_url_prefix'] = $topic['url'].'?';

        //$data['most_viewed_writers'] = $this->__get_most_viewed_writers();

        $this->related_topics = $this->_get_related_topics($this->topic_questions);

        $this->_prepareFollowButton();

        $this->template = 'topic/show';
        $this->pageTitle = $this->_get_page_title();
         //str_replace('%topic%', , _('Topic - Page title')).' • '._('OctoAnswers');
        $this->pageDescription = $this->_get_page_description();
        $this->nextPageURL = null;

        $this->openGraph = $this->_getOpenGraph();
        $this->share = $this->_getOpenGraph();

        $output = $this->renderPage();
        $response->getBody()->write($output);

        return $response;
    }

    protected function _get_page_title()
    {
        return str_replace('%topic', $this->topic->getTitle(), _('Topic - Page title')).' &mdash; '._('OctoAnswers');
    }

    protected function _prepareFollowButton()
    {
        if ($this->authUser) {
            $authUserID = $this->authUser->getID();
            $topicID = $this->topic->getID();

            $relation = (new UsersFollowTopics_Relations_Query($this->lang))->relationWithUserIDAndTopicID($authUserID, $topicID);

            $this->followed = $relation ? true : false;
            $this->additionalJavascript[] = 'topic/follow';
        }
    }

    protected function _getOpenGraph()
    {
        $og = [
            'url' => $this->topic->getURL($this->lang),
            'type' => "website",
            'title' => $this->_get_page_title(),
            'description' => $this->_get_page_description(),
            'image' => IMAGE_URL.'/og-image.png'
        ];
        return $og;
    }

    protected function _get_page_description()
    {
        return str_replace('%topic', $this->topic->getTitle(), _('Topic - Page description'));
    }

    /**
     * Get most_viewed_writers.
     */
    public function __get_most_viewed_writers()
    {
        $most_viewed_writers = [
            [
                'name' => 'Александр Гомзяков',
                'url' => 'https://octoanswers.com/user/1/aleksandr-gomzyakov',
                'signature' => 'Менеджер ИТ-проектов, octoanswers.com',
                'avatar_url' => 'http://placehold.it/48x48',
                'avatar_alt' => 'Александр Гомзяков',
            ],
            [
                'name' => 'Виктор Белохвостов',
                'url' => 'https://octoanswers.com/user/13/viktor-belohvostov',
                'signature' => 'Менеджер, продавец корпоративных услуг в области ИТ',
                'avatar_url' => 'http://placehold.it/48x48',
                'avatar_alt' => 'Виктор Белохвостов',
            ],
            [
                'name' => 'Александр Гомзяков',
                'url' => 'https://octoanswers.com/user/1/aleksandr-gomzyakov',
                'signature' => 'Менеджер ИТ-проектов, octoanswers.com',
                'avatar_url' => 'http://placehold.it/48x48',
                'avatar_alt' => 'Александр Гомзяков',
            ],
        ];

        return $most_viewed_writers;
    }

    public function _get_related_topics($questions)
    {
        if (count($questions) == 0) {
            return [];
        }

        foreach ($questions as $question) {
            $topics_titles = $question->getTopics();
            if (count($topics_titles)) {
                foreach ($topics_titles as $title) {
                    //@TODO need a query
                    $related_titles[] = $title;
                }
            }
        }

        $related_titles = array_unique($related_titles);
        $related_titles = array_reverse($related_titles);

        $del_val = $this->topic->getTitle();
        if (($key = array_search($del_val, $related_titles)) !== false) {
            unset($related_titles[$key]);
        }

        $related_topics = [];
        foreach ($related_titles as $title) {
            $topic = Topic_Model::initWithTitle($title);
            $related_topics[] = $topic;
        }

        return $related_topics;
    }
}
