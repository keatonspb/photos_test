<?php


namespace app\models;


use Yii;
use yii\base\Model;
use yii\web\UploadedFile;

class AddForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public $email;

    public $description;

    public function rules()
    {
        return array_merge(parent::rules(), [
            [['email', 'description'], 'required'],
            [['email'], 'email'],
            [['description'], 'string', 'max' => 255],
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif, jpeg'],
            [['email'], 'unique', 'targetClass' => User::class, 'message' => "Пользователь с таким email уже существует - авторизуйтесь", "when" => function ($model) {
                return Yii::$app->user->isGuest;
            }],
        ]);
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return array_merge(parent::rules(), [
            'email' => 'Email',
            'file' => 'Выберите фото',
        ]);
    }

    public function upload()
    {
        if ($this->validate()) {
            /**
             * @var yii\image\ImageDriver Yii::$app->image
             */
            $transaction = Yii::$app->getDb()->beginTransaction();
            $success = false;
            $mailBody = "";
            try {
                if (Yii::$app->user->isGuest) {
                    $User = new User();
                    $User->email = $this->email;
                    $password = \Yii::$app->security->generateRandomString(8);
                    $User->setPassword($password);
                    $User->save();
                    Yii::$app->user->login($User);
                    $mailBody .= "Ваш логин и пароль: {$User->email} {$password}\n";
                } else {
                    $User = Yii::$app->user;
                }
                $Photo = new Photo();
                $Photo->description = $this->description;
                $Photo->user_id = $User->id;
                $Photo->save();
                $photoName = $Photo->id . "." . $this->file->extension;
                $image = Yii::$app->image->load($this->file->tempName);
                $pubFolder = "/uploads";
                $folder = Yii::getAlias("@webroot") . $pubFolder;
                if (!file_exists($folder)) {
                    mkdir($folder);
                }
                $file = $folder . "/" . $photoName;
                $Photo->filepath = $pubFolder . "/" . $photoName;
                $Photo->save();
                if ($image->resize(320)->crop(320, 240)->save($file)) {
                    $transaction->commit();
                    $success = true;
                }

            } catch (\Exception $e) {
                $transaction->rollBack();
                $this->addError("file", $e->getMessage());
                return false;
            }
            if ($success) {
                $mailBody .= "Успешная загрузка фото";
            } else {
                $mailBody .= "Загрузить фото не удалось";
            }
            Yii::$app->mailer->compose()
                ->setTo($this->email)
                ->setFrom("info@discode.ru")
                ->setSubject("Загрузка фото")
                ->setTextBody($mailBody)->send();
            return $success;
        } else {
            return false;
        }
    }
}
