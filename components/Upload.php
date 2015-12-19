<?php namespace Keios\Support\Components;

use Log;
use BackendAuth;
use Keios\Support\Models\TicketAttachment;
use Cms\Classes\ComponentBase;

/**
 * Class Upload
 * @package Keios\Upload\Components
 */
class Upload extends ComponentBase
{

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'Upload',
            'description' => 'Upload Form Settings.',
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'uploadPath' => [
                'title'       => 'keios.support::lang.settings.upload_path',
                'description' => 'keios.support::lang.settings.upload_path_description',
                'default'     => '',
                'type'        => 'string',
            ],
            'fileType'   => [
                'title'       => 'keios.support::lang.settings.file_type',
                'description' => 'keios.support::lang.settings.file_type_description',
                'type'        => 'dropdown',
                'default'     => '1',
                'options'     => ['0' => 'Files', '1' => 'Images'],
            ],
        ];
    }


    /**
     *
     */
    public function onRender()
    {
        if (isset($_FILES['file']) && !empty($_FILES['file'])) {
            // Get user id
            $user = BackendAuth::getUser();
            $currDate = date("Y-m-d");
            if (isset($user) && !empty($user)) {
                $uid = $user->email;
            } else {
                $uid = 0;
            }

            $uploadPath = $this->property('uploadPath');
            if (!empty($uploadPath)) {
                $uploadDir = $uploadPath.$uid.'/'.$currDate.'/';
                $this->page['uploadPath'] = $uploadPath.$uid.'/'.$currDate.'/';
            } else {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'].'/uploads/'.$uid.'/'.$currDate.'/';
                $this->page['uploadPath'] = '/uploads/'.$uid.'/'.$currDate.'/';
            }

            if (!file_exists($uploadDir)) {
                $dirExist = mkdir($uploadDir, 0777, true);
            } else {
                $dirExist = true;
            }

            if ($dirExist) {

                $file = $_FILES['file'];
                $fileName = $file["name"];
                if ($file["error"] > 0) {
                    // Error!
                    $res = array(
                        'status'  => 0,
                        'message' => $file["error"],
                    );
                } else {
                    //TODO check file type and size here

                    if (
                        (substr($file['type'], 0, 5) == 'image' && $this->property('fileType') == 1) ||
                        (substr($file['type'], 0, 5) != 'image' && $this->property('fileType') == 0)
                    ) {
                        // Check if file exist
                        if (file_exists($uploadDir.$fileName)) {
                            $fileName = time().'-'.$fileName;
                        }

                        // Upload File
                        move_uploaded_file($file["tmp_name"], $uploadDir.$fileName);
                        $filePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $uploadDir.$fileName);

                        // Create File
                        $object = new TicketAttachment;
                        $object->file_name = $fileName;
                        $object->file_path = $filePath;
                        $object->file_size = $file['size'];
                        $object->content_type = $file['type'];
                        $object->user_id = $uid;
                        $object->title = '';
                        $object->description = '';
                        $object->save();

                        $res = array(
                            'status'   => 1,
                            'message'  => e(trans('keios.support::lang.message.success')),
                            'fileName' => $fileName,
                            'filePath' => $filePath,
                            'checkImg' => $this->property('fileType'),
                        );
                    } else {
                        $res = array(
                            'status'  => 0,
                            'message' => e(trans('keios.support::lang.message.extension')),
                        );
                    }
                }
            } else {
                $res = array(
                    'status'  => 0,
                    'message' => e(trans('keios.support::lang.message.dir')),
                );
            }
        } else {
            $res = array(
                'status'  => 0,
                'message' => e(trans('keios.support::lang.message.empty')),
            );
        }

        $this->page['output'] = json_encode($res);
    }


}