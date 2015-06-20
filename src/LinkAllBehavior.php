<?php
/**
 * @link https://github.com/cornernote/yii2-linkall-behavior
 * @copyright Copyright (c) 2015 Mr PHP
 * @license https://raw.githubusercontent.com/cornernote/yii2-linkall-behavior/master/LICENSE
 */

namespace cornernote\linkall;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * LinkAllBehavior
 *
 * Wraps the functionality of `ActiveRecordBase::link()` and `ActiveRecordBase::unlink()`
 * to allow a list of models to be linked, and optionally unlinking existing models.
 *
 * Checks are performed to ensure existing links are not duplicated.
 *
 * @property BaseActiveRecord $owner
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 */
class LinkAllBehavior extends Behavior
{

    /**
     * Manages the relationships between models.
     *
     * @param string $name the case sensitive name of the relationship.
     * @param BaseActiveRecord[] $models the related models to be linked.
     * @param array $extraColumns additional column values to be saved into the junction table.
     * This parameter is only meaningful for a relationship involving a junction table
     * (i.e., a relation set with `ActiveRelationTrait::via()` or `ActiveQuery::viaTable()`.)
     * @param bool $unlink whether to unlink models that are not in the $models array.
     * @param bool $delete whether to delete the models that are not in the $models array.
     * If $unlink is false then this is ignored.
     * If false, the model's foreign key will be set null and saved.
     * If true, the model containing the foreign key will be deleted.
     */
    public function linkAll($name, $models, $extraColumns = [], $unlink = true, $delete = true)
    {
        $modelPk = key(call_user_func([$this->owner, 'get' . $name])->link);
        $newModelPks = ArrayHelper::map($models, $modelPk, $modelPk);
        $oldModels = $this->owner->{$name};
        $oldModelPks = ArrayHelper::map($oldModels, $modelPk, $modelPk);

        if ($unlink) {
            $this->unlink($name, $modelPk, $oldModels, $newModelPks, $delete);
        }
        $this->link($name, $modelPk, $models, $oldModelPks, $extraColumns);
    }

    /**
     * Remove old links
     *
     * @param string $name
     * @param int|string $modelPk
     * @param BaseActiveRecord[] $oldModels
     * @param array $newModelPks
     * @param bool $delete
     */
    protected function unlink($name, $modelPk, $oldModels, $newModelPks, $delete)
    {
        foreach ($oldModels as $oldModel) {
            if (!in_array($oldModel->{$modelPk}, $newModelPks)) {
                $this->owner->unlink($name, $oldModel, $delete);
            }
        }
    }

    /**
     * Add new links
     *
     * @param string $name
     * @param int|string $modelPk
     * @param BaseActiveRecord[] $models
     * @param array $oldModelPks
     * @param array $extraColumns
     */
    protected function link($name, $modelPk, $models, $oldModelPks, $extraColumns)
    {
        foreach ($models as $newModel) {
            if (!in_array($newModel->{$modelPk}, $oldModelPks)) {
                $this->owner->link($name, $newModel, $extraColumns);
            }
        }
    }

}
