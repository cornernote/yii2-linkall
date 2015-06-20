<?php
/**
 * @link https://github.com/cornernote/yii2-linkall
 * @copyright Copyright (c) 2013-2015 Mr PHP <info@mrphp.com.au>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests\models;

use cornernote\linkall\LinkAllBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * PostA
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 *
 * @mixin LinkAllBehavior
 */
class Post extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            LinkAllBehavior::className(),
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('post_to_tag', ['post_id' => 'id']);
    }
}
