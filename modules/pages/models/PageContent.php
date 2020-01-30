<?php

namespace app\modules\pages\models;

use Yii;
use modules\pages\Module;
/**
 * This is the model class for table "tbl_page_content".
 *
 * @property int $id
 * @property int $page_id
 * @property string $content
 */
class PageContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_page_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id'], 'required'],
            [['page_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Module::t('module', 'ID'),
            'page_id' => Module::t('module', 'Page ID'),
            'content' => Module::t('module', 'Content'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return PageContentQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageContentQuery(get_called_class());
    }

    public static function getAllPages($parent = 0, $level = 0, $exclude = 0)
    {
        $children = Pages::find()
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

        if ($root) {
        }
        foreach ($data as $item) {

                $tree[$item['id']] = $item['name'];

        }
        return $tree;
    }

    public static function getContent($id)
    {
        return self::find()->where(['page_id' => $id] )->one();
    }
}
