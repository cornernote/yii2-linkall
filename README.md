# Yii2 LinkAll Behavior

Behavior to handle saving multiple many to many related records.

## Installation

```
composer require cornernote/yii2-linkall-behavior
```


## Usage

Post Model

```php
class Post extends ActiveRecord
{
    public function behaviors()
    {
        return [
            \cornernote\linkall\LinkAllBehavior::className(),
        ];
    }

    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
            ->viaTable('post_to_tag', ['post_id' => 'id']);
            //->via('postToTag');
    }
}
```

Tag Model

```php
class Tag extends ActiveRecord
{

}
```

Post Controller

```php
class PostController extends Controller
{
    public function actionExample()
    {
        $post = Post::findOne(1);
        $post->linkAll('tags', [Tag::findOne(2), Tag::findOne(3)], true);
    }
}
```


## License

- Author: Brett O'Donnell <cornernote@gmail.com>
- Source Code: https://github.com/cornernote/yii2-linkall-behavior
- Copyright © 2015 Mr PHP <info@mrphp.com.au>
- License: BSD-3-Clause https://raw.github.com/cornernote/yii2-linkall-behavior/master/LICENSE
