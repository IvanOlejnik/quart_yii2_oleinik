<?php 
namespace backend\models;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    //public $img;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }
    
    public function uploadFile()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs(Yii::getAlias('@webroot') . '/resourse/icon/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);

            return true;
        } else {
            return false;
        }
    }
}