# Yii2 LinkAll

[![Latest Version](https://img.shields.io/github/tag/cornernote/yii2-linkall.svg?style=flat-square&label=release)](https://github.com/cornernote/yii2-linkall/tags)
[![Software License](https://img.shields.io/badge/license-BSD-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/cornernote/yii2-linkall/master.svg?style=flat-square)](https://travis-ci.org/cornernote/yii2-linkall)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/cornernote/yii2-linkall.svg?style=flat-square)](https://scrutinizer-ci.com/g/cornernote/yii2-linkall/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/cornernote/yii2-linkall.svg?style=flat-square)](https://scrutinizer-ci.com/g/cornernote/yii2-linkall)
[![Total Downloads](https://img.shields.io/packagist/dt/cornernote/yii2-linkall.svg?style=flat-square)](https://packagist.org/packages/cornernote/yii2-linkall)

Behavior to handle saving multiple many to many related records in Yii2.

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ composer require cornernote/yii2-linkall "*"
```

or add

```
"cornernote/yii2-linkall": "*"
```

to the `require` section of your `composer.json` file.

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
        $tags = [Tag::findOne(2), Tag::findOne(3)];
        
        $extraColumns = []; // extra columns to be saved to the many to many table
        $unlink = true; // unlink tags not in the list
        $delete = true; // delete unlinked tags
        
        $post->linkAll('tags', $tags, $extraColumns, $unlink, $delete);
    }
}
```
