<?php

namespace Jtrw\Store\Fields;

use Jtrw\Store\Exceptions\FieldValidationException;
use Jtrw\StoreView\Exceptions\FieldNotFoundPropertyException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class File extends AbstractFieldType
{
    public function __construct(array $filed)
    {
        parent::__construct($filed);

        $this->doUploadFile();

    } // end __construct

    protected function doUploadFile()
    {
        $file = $this->getUploadedFile();
        $uploadfile = $this->getUploadDir() ."/". basename($file->getClientOriginalName());

        if (!$this->copy($file->getPathname(), $uploadfile)) {
            $msg = __("Can't Upload File %s", $uploadfile);
            throw new FieldValidationException($msg);
        }
    } // end doUploadFile

    protected function getUploadedFile(): UploadedFile
    {
        if (!array_key_exists('files', $this->field)) {
            throw new FieldValidationException("File Not Found");
        }

        if (!($this->field['files'] instanceof UploadedFile)) {
            throw new FieldValidationException("Files must be instance UploadedFile");
        }

        return $this->field['files'];
    } // end getUploadedFile

    public function getUploadDir()
    {
        if (!array_key_exists('uploadDir', $this->field)) {
            throw new FieldValidationException("UploadDir Not Found");
        }
        return $this->field['uploadDir'];
    } // end getUploadDir

    protected function copy(string $from, string $to)
    {
        return move_uploaded_file($from, $to);
    } // end copy

    public function getValue()
    {
        return basename($this->field['value']);
    } // end getValue
}
