<?php

namespace APIController\POST\Questions\ID;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Image extends \APIController\APIController
{
    const JPEG_QUALITY = 90;
    const WIDTH_LG = 1140;  // col-12 width
    const WIDTH_MD = 760;  // col-8 width
    const UPLOAD_FOLDER = ROOT_PATH . '/uploads/img';

    private $verot_upload = null;

    public function handle(Request $request, Response $response, $args)
    {
        try {

            // Check params

            if ($_FILES['upload_image_form__image_file']['size'] == 0 || $_FILES['upload_image_form__image_file']['name'] == '') {
                throw new \Exception('No file was selected for upload', 1);
            }

            $lang = $request->getAttribute('lang');
            $question_id = (int) $request->getAttribute('id');

            $post_params = $request->getParsedBody();
            $API_key = $post_params['api_key'];

            $this->question = (new \Query\Question($lang))->questionWithID($question_id);

            if (!$this->question) {
                throw new \Exception('No QUESTION', 0);
            }

            $this->user = (new \Query\User())->userWithAPIKey($API_key);

            if (!$this->user) {
                throw new \Exception('No user', 0);
            }

            // Upload image

            $this->verot_upload = new \Verot\Upload\Upload($_FILES['upload_image_form__image_file']);
            if ($this->verot_upload->uploaded) {
                $image_base_name = $this->_get_image_base_name();

                $this->_makeUserAvatarWithSize($lang, $image_base_name . '_lg', self::WIDTH_LG);
                $this->_makeUserAvatarWithSize($lang, $image_base_name . '_md', self::WIDTH_MD);

                // delete the original uploaded file
                $this->verot_upload->clean();
            } else {
                throw new \Exception('Image don`t upload', 0);
            }

            // Update question image base name
            $this->question->imageBaseName = $image_base_name;
            $this->question = (new \Mapper\Question($lang))->update($this->question);

            $output = [
                'lang'         => $lang,
                'question_id'  => $this->question->id,
                'user_id'      => $this->user->id,
                'image_url_lg' => $this->question->getImageURLLarge($lang),
                'image_url_md' => $this->question->getImageURLMedium($lang),
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

    protected function _makeUserAvatarWithSize($lang, $image_filename, $image_width)
    {
        $uploadFolder = self::UPLOAD_FOLDER . '/' . $lang . '/' . $this->question->id . '/';

        $this->verot_upload->allowed = ['image/jpeg', 'image/jpg', 'image/gif', 'image/png'];
        $this->verot_upload->image_convert = 'jpg';
        $this->verot_upload->jpeg_quality = self::JPEG_QUALITY;
        $this->verot_upload->image_resize = true;
        $this->verot_upload->image_ratio_crop = true;
        $this->verot_upload->file_overwrite = true;
        $this->verot_upload->image_x = $image_width;
        $this->verot_upload->image_y = (int) ($image_width * (1 / 2) - 10);
        $this->verot_upload->file_src_name_body = $image_filename;
        $this->verot_upload->process($uploadFolder);
        if ($this->verot_upload->processed) {
            return $this->verot_upload->file_dst_pathname;
        } else {
            return $this->verot_upload->error;
        }
    }

    protected function _get_image_base_name()
    {
        $dateChunk = date('Ymj');
        $rand = mt_rand(1, 999);

        return $this->user->id . '_' . $dateChunk . '_' . $rand;
    }
}
