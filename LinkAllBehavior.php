<?php

namespace cornernote\linkall;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * LinkAllBehavior
 *
 * @property BaseActiveRecord $owner
 */
class LinkAllBehavior extends Behavior
{

    /**
     * @param string $name
     * @param BaseActiveRecord[] $models
     * @param array $extraColumns
     * @param bool $unlink
     * @param bool $delete
     */
    public function linkAll($name, $models, $extraColumns, $unlink = false, $delete = false)
    {
        $modelPk = key(call_user_func([$this->owner, 'get' . $name])->link);
        $newModelPks = ArrayHelper::map($models, $modelPk, $modelPk);
        $oldModels = $this->owner->{$name};
        $oldModelPks = ArrayHelper::map($oldModels, $modelPk, $modelPk);

        // remove old links
        if ($unlink) {
            foreach ($oldModels as $oldModel) {
                if (!in_array($oldModel->{$modelPk}, $newModelPks)) {
                    $this->owner->unlink($name, $oldModel, $delete);
                }
            }
        }

        // add new links
        foreach ($models as $newModel) {
            if (!in_array($newModel->{$modelPk}, $oldModelPks)) {
                $this->owner->link($name, $newModel, $extraColumns);
            }
        }
    }

}