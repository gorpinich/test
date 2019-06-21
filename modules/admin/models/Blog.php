<?php

namespace app\modules\admin\models;

use Yii;
use yii\data\Pagination;
use yii\widgets\LinkPager;
use yii\web\UploadedFile;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property int $date
 * @property int $user_id
 */
class Blog extends \yii\db\ActiveRecord
{
    // Название таблицы
    public static function tableName()
    {
        return '{{blog}}';
    }

    // Настройки модели
    public static function settings()
    {

        return [
            'pl' => 10, // Записей на странице
            'isEdit' => true, // Возможность редактировать
            'isDel' => true, // Возможность удаления
            'isAdd' => true, // Возможность добавления
            'page' => 'index', // Название страницы
            'title' => 'Блог', // Название страницы
            'baseUrl' => 'blog',
            'model_name' => 'Blog'

        ];
    }


    // Все поля
    public function attributeLabels()
    {
        return [
            'id' => '#',
            'title' => 'Заголовок',
            'text' => 'Текст',
            'photo' => 'Фото',
            'date' => 'Дата',
        ];
    }
    // Поля которые отображаем в таблице, в порядке отображения
    public function showInTable()
    {
        return [
//            'id',
            'title',
            'text',
            'date',
        ];
    }

    // Правила для полей
    public function rules() {
        return [
            [['title','date'], 'required', 'message'=>'Не может быть пустым'],
            [['photo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],

        ];
    }

    // Массив полей для редактировани/добавления
    public function fieldArray()
    {
        return ['title','text','date','photo'];
    }

    public function replace_field($field_name,$field_val)
    {
        if($field_name=='date') {
            return date("d.m.Y H:i", $field_val);
        }
        else {
            return $field_val;
        }
    }



    /** public function afterSave(){
    $this->updateAttributes([
    'unquie_id'=>(new UnuioqeIdGen())->run($this->id)
    ]);
    }**/

    public function setFields($arr)
    {
        foreach($arr as $k=>$p){
            if(in_array($k,$this->fieldArray())){
                $this->$k=$p;
            }
        }
        return true;
    }
    public function uploadImg()
    {

        $img = UploadedFile::getInstanceByName('Blog[photo]');

        if(!empty($img->name)){
            $img->saveAs('assets/upload/'.time().'.jpg');
            return 'assets/upload/'.time().'.jpg';

        }

    }
    // Удаление записей
    public function Del($id)
    {
        if($this->settings()['isDel']){
            $this->findOne($id)->delete();
        }
    }

    // Обновление записей
    public function Up($id,$arr)
    {

        if($this->settings()['isEdit']){
            $this->findOne($id);
            $photo = $this->uploadImg();

            if(!empty($photo)){
                $arr['photo'] = $photo;
            }else {
                $arr['photo'] = $this->findOne($id)->photo;
            }
            $this->setFields($arr);
            $this->update();
        }

    }
    // Добавление записей
    public function Add($arr)
    {
        if($this->settings()['isAdd']) {
            $this->setFields($arr);
            $this->user_id = yii::$app->user->id;
            $this->date = time();
            $this->photo = $photo = $this->uploadImg();
            $this->save();
        }

    }


    private function GetSearch($form_arr)
    {
        $search = $this->find();
        $thisArr=[];
        $andWhr = '';
        if(is_array($form_arr)){
            foreach ($form_arr as $k=> $field){
                if(in_array($k,$this->showInTable()) and !empty($field)){
                    if($k == 'name'){
                        $andWhr = " name LIKE '%".$field."%'";
                    }else {
                        $thisArr = array_merge([$k=>$field],$thisArr);
                    }
                }
            }
        }
        return $search->where($thisArr)->andWhere($andWhr)->andWhere(['user_id'=>yii::$app->user->id]);

    }
    // Получение записей


    public function GetRows($form_arr)
    {
        $gs = $this->GetSearch($form_arr);

        $pages = new Pagination(['totalCount' => $gs->count(), 'pageSize' => $this->settings()['pl']]);
        $pages_html = LinkPager::widget([
            'pagination' => $pages,
        ]);
        $rows = $gs
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('id DESC')
            ->asArray()
            ->all();


        return [
            'rows'=>$rows,
            'p'=>$pages,
            'p_html'=>$pages_html
        ];
    }

}
