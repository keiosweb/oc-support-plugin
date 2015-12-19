<?php namespace Keios\Support\Components;

use Log;
use BackendAuth;
use Cms\Classes\Page;
use Cms\Classes\ComponentBase;

/**
 * Class UploadForm
 * @package Keios\Support\Components
 */
class UploadForm extends ComponentBase
{

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'Upload Form',
            'description' => 'Insert Upload Form.',
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'uploadPage' => [
                'title'       => 'keios.support::lang.settings.upload_page',
                'description' => 'keios.support::lang.settings.upload_page_description',
                'type'        => 'dropdown',
                'default'     => 'upload',
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function getUploadPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     *
     */
    public function onRender()
    {
        $urlPage = $this->property('uploadPage');
        //$path = Page::url($urlPage, array(), false);
        $path = Page::url($urlPage);
        $this->page['uploadPage'] = $path;
    }
}