<h1>Yii2 module for editing models table in a modal window.</h1>

<h2>Installation</h2>

<pre>
$ composer require --prefer-dist sergmoro1/yii2-modal-crud "dev-master"
</pre>

<h3>Usage</h3>

For example, there is a model <code>Property</code> with two fields: <code>id</code>, <code>name</code>. 

<h4>Controller</h4>

<pre>
namespace backend\controllers;

use sergmoro1\modal\controllers\ModalController;

use common\models\Property;
use common\models\PropertySearch;

class PropertyController extends ModalController
{
  public function newModel() { return new Property(); }
  public function newSearch() { return new PropertySearch(); }
}
</pre>

<h4>View</h4>

Only matters <code>index.php</code>. Other are ordinary.

<pre>
&lt;?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

// bind actions
$this-&gt;registerJs('var popUp = {"id": "property", "actions": ["update"]};', yii\web\View::POS_HEAD);
sergmoro1\modal\assets\PopUpAsset::register($this);

$this-&gt;title = \Yii::t('app', 'Properties');

echo Modal::widget([
  'id' =&gt; 'property-win',
  'toggleButton' =&gt; false,
  'header' =&gt; $this-&gt;title,
  'footer' =&gt; 
    '&lt;button type="button" class="btn btn-default" data-dismiss="modal"&gt;Cancel&lt;/button&gt;'. 
    '&lt;button type="button" class="btn btn-primary"&gt;Save&lt;/button&gt;',
]);
?&gt;

&lt;div class="property-index"&gt;
  // create action
  &lt;p&gt;
    &lt;?= Html::a('glyphicon glyphicon-plus', ['create'], [
      'id' =&gt; 'property-add',
      'data-toggle' =&gt; 'modal',
      'data-target' =&gt; '#property-win',
      'class' =&gt; 'btn btn-success',
    ]) ?&gt;
  &lt;/p&gt;
  &lt;div class="table-responsive"&gt;
    &lt;?= GridView::widget([
      'dataProvider' =&gt; $dataProvider,
      'filterModel' =&gt; $searchModel,
      'columns' =&gt; [
        'id'
        'name',
        // update, delete actions
        [
          'class' =&gt; 'yii\grid\ActionColumn',
          'template' =&gt; '{update} {delete}',
          'buttons' =&gt; [
            'update' =&gt; function ($url, $model) {
              return Html::a(
                '&lt;span class="glyphicon glyphicon-pencil"&gt;&lt;/span&gt;', 
                $url, [
                  'class' =&gt; 'update',
                  'data-toggle' =&gt; 'modal',
                  'data-target' =&gt; '#property-win',
                ]
              );
            },
          ],
        ],
      ],
    ]); ?&gt;
  &lt;/div&gt;
&lt;/div&gt;
</pre>

The entire code can be found at - https://github.com/sergmoro1/yii2-lookup.
