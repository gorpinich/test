<?php

namespace app\models;

use Yii;
use yii\data\Pagination;
use yii\widgets\LinkPager;

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
            'page' => 'post', // Название страницы
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
            [['title','text','date'], 'required', 'message'=>'Не может быть пустым'],

        ];
    }

    // Массив полей для редактировани/добавления
    public function fieldArray()
    {
        return ['title','text','date'];
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
            $this->setFields($arr);
            $this->update();
        }

    }
    // Добавление записей
    public function Add($arr)
    {
        if($this->settings()['isAdd']) {
            $this->setFields($arr);
            $this->date = time();
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
        return $search->where($thisArr)->andWhere($andWhr);

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
