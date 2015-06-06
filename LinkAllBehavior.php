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
    public function linkAll($name, $models, $unlink = false)
    {
        $modelPk = key(call_user_func([$this->owner, 'get' . $name])->link);
        $newModelPks = ArrayHelper::map($models, $modelPk, $modelPk);
        $oldModels = $this->owner->{$name};
        $oldModelPks = ArrayHelper::map($oldModels, $modelPk, $modelPk);

        // remove old links
        if ($unlink) {
            foreach ($oldModels as $oldModel) {
                if (!in_array($oldModel->{$modelPk}, $newModelPks)) {
                    $this->owner->unlink($name, $oldModel, true);
                }
            }
        }

        // add new links
        foreach ($models as $newModel) {
            if (!in_array($newModel->{$modelPk}, $oldModelPks)) {
                $this->owner->link($name, $newModel);
            }
        }
    }
}