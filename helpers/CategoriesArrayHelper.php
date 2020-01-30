<?php
namespace app\helpers;
use \yii\helpers\ArrayHelper as YiiArrayHelper;
class CategoriesArrayHelper extends YiiArrayHelper
{
    protected static $_childCategories;
    /**
     * Формируем массив категорий
     * @param $array
     * @return array
     */
    public static function formCategoriesArray($array)
    {
        $out = [];
        foreach ($array as $item) {
            if($item['parent_id'] == null){
                $out[0][] = $item;
            } else{
                $out[$item['parent_id']][] = $item;
            }
        }
        return $out;
    }
    /**
     * Отсеиваем все дочернии категории и текущию категорию,
     * формируем массив для выбора категорий при обновлении
     * @param $array
     * @param $from
     * @param $to
     * @param $categoryId
     * @return array
     */
    public static function mapCategories($array, $from, $to, $categoryId)
    {
        $categoriesArr = static::formCategoriesArray($array);
        static::getChildcategories($categoriesArr, $categoryId);
        $arrMap = static::map($array, $from, $to);
        $result = [];
        foreach ($arrMap as $key => $value)
        {
            if(!is_array(static::$_childCategories) && $key !== $categoryId ){
                $result[$key] = $value;
            } elseif ($key !== $categoryId && !in_array($key, static::$_childCategories)){
                $result[$key] = $value;
            }
        }
        return $result;
    }
    /**
     * Получить все дочернии категории
     * @param $array
     * @param $categoryId
     */
    protected static function getChildcategories($array, $categoryId)
    {
        if (isset($array[$categoryId])) {
            foreach ($array[$categoryId] as $value) {
                static::$_childCategories[] = $value['id'];
                static::getChildcategories($array, $value['id']);
            }
        }
    }
}