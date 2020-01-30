<?php

namespace app\modules\pages\models;


/**
 * This is the model class for table "tbl_pages".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $name
 * @property int $sort_order
 * @property string $title
 */
class Pages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_pages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id', 'sort_order'], 'integer'],
            [['name', 'title'], 'required'],
            [['name', 'title'], 'string', 'max' => 32],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'name' => 'Name',
            'sort_order' => 'Sort Order',
            'title' => 'Title',
        ];
    }

    public static function getAllPages($parent = 0, $level = 0, $exclude = 0)
    {
        $children = self::find()
            ->where( ['parent_id' => $parent] )
            ->asArray()
            ->all();
        $result = [];
        foreach ($children as $pages) {
            // при выборе родителя категории нельзя допустить
            // чтобы она размещалась внутри самой себя
            if ($pages['id'] == $exclude) {
                continue;
            }
            if ($level) {
                $pages['title'] = str_repeat( '— ', $level ) . $pages['title'];
            }
            $result[] = $pages;
            $result = array_merge(
                $result,
                self::getAllPages( $pages['id'], $level + 1, $exclude )
            );
        }
        return $result;
    }

    public static function getTree($exclude = 0, $root = false, $parents = false)
    {
        $data = self::getAllPages( 0, 0, $exclude );
        $tree = [];
        // при выборе родителя категории можно выбрать значение «Без родителя»,
        // т.е. создать категорию верхнего уровня, у которой не будет родителя
        if ($root) {
            $tree[0] = 'Без родителя';
        }
        foreach ($data as $item) {
            if ($parents = true && $item['parent_id'] == 0) {
                $tree[$item['id']] = $item['name'];
            }

        }
        return $tree;
    }

    public static function getPage($parent_id)
    {
        return self::findOne( $parent_id );
    }



}
