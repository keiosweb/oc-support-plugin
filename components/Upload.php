<?php namespace Keios\Support\Components;

use BackendAuth;
use Keios\Support\Models\TicketAttachment;
use Cms\Classes\ComponentBase;
use DB;

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
        ];
    }


    /**
     * Gets the post message and saves the file.
     *
     * @throws \Exception
     */
    public function onRender()
    {
        if (isset($_FILES['file']) && !empty($_FILES['file'])) {
            // Get user id
            $user = BackendAuth::getUser();
            $currDate = date("Y-m-d");
            if (isset($user) && !empty($user)) {
                $tid = post('ticket_id');
            } else {
                $tid = 0;
            }

            $basePath = base_path();
            $uploadPath = $basePath.'/storage/app/uploads/';
            $uploadDir = $uploadPath.$tid.'/'.$currDate.'/';
            $this->page['uploadPath'] = $uploadPath.$tid.'/'.$currDate.'/';

            if (!file_exists($uploadDir)) {
                $dirExist = mkdir($uploadDir, 0777, true);
                if (!$dirExist) {
                    throw new \Exception('Cannot create directory');
                }
            }

            $file = $_FILES['file'];
            $fileName = $file["name"];
            if ($file["error"] > 0) {
                throw new \Exception('Problem with file!'); //todo
            }

            if (file_exists($uploadDir.$fileName)) {
                $fileName = time().'-'.$fileName;
            }

            move_uploaded_file($file["tmp_name"], $uploadDir.$fileName);
            $filePath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $uploadDir.$fileName);
            $this->createAttachment($fileName, $filePath, $tid, $file);

            $result = [
                'status'   => 1,
                'message'  => trans('keios.support::lang.message.success'),
                'fileName' => $fileName,
                'filePath' => $filePath,
                'checkImg' => 0,
            ];
        } else {
            throw new \Exception('Problem with file!'); //todo
        }

        $this->page['output'] = json_encode($result);

    }

    /**
     * Puts file entry in the database
     *
     * @param string  $fileName
     * @param string  $filePath
     * @param integer $tid
     * @param array   $file
     *
     * @return TicketAttachment
     * @throws \Exception
     */
    private function createAttachment($fileName, $filePath, $tid, $file)
    {
        DB::beginTransaction();

        try {
            $attachment = new TicketAttachment;
            $attachment->file_name = $fileName;
            $attachment->file_path = $filePath;
            $attachment->ticket_id = $tid;
            $attachment->file_size = $file['size'];
            $attachment->content_type = $file['type'];
            $attachment->user_id = $tid;
            $attachment->save();
        } catch (\Exception $e) {
            DB::rollback();
            throw new \Exception($e); //todo
        }

        DB::commit();

        return $attachment; //todo think if necessary
    }

}