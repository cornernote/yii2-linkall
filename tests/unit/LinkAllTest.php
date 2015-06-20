<?php
/**
 * LinkAllTest.php
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @link https://mrphp.com.au/
 */

namespace tests;

use tests\models\Post;
use tests\models\Tag;
use Yii;

/**
 * LinkAllTest
 */
class LinkAllTest extends DatabaseTestCase
{

    /**
     * Link All
     */
    public function testLinkAll()
    {
        /** @var Post $post */
        $post = Post::findOne(1);
        $tags = [Tag::findOne(2), Tag::findOne(3)];
        $post->linkAll('tags', $tags);

        $dataSet = $this->getConnection()->createDataSet(['post', 'tag', 'post_to_tag']);
        $expectedDataSet = $this->createFlatXMLDataSet(__DIR__ . '/data/test-linkall.xml');
        $this->assertDataSetsEqual($expectedDataSet, $dataSet);
    }
}