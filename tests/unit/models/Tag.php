<?php
/**
 * @link https://github.com/cornernote/yii2-linkall
 * @copyright Copyright (c) 2013-2015 Mr PHP <info@mrphp.com.au>
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests\models;

use yii\db\ActiveRecord;

/**
 * Tag
 *
 * @property integer $id
 * @property string $name
 */
class Tag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }
}
