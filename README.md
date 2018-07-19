<h1>Yii2 module for editing models table in a modal window.</h1>

<h2>Installation</h2>

<pre>
$ composer require --prefer-dist sergmoro1/yii2-modal-crud "dev-master"
</pre>

<h3>Usage</h3>

For example, there is a model <code>Property</code> with two fields: <code>id</code>, <code>name</code>. 

<h4>Controller</h4>

<pre>
<?php
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
<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

use sergmoro1\lookup\Module;

// bind actions
$this->registerJs('var popUp = {"id": "property", "actions": ["update"]};', yii\web\View::POS_HEAD);
sergmoro1\modal\assets\PopUpAsset::register($this);

$this->title = \Yii::t('app', 'Properties');

echo Modal::widget([
    'id' => 'property-win',
    'toggleButton' => false,
    'header' => $this->title,
    'footer' => 
        '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>'. 
        '<button type="button" class="btn btn-primary">Save</button>',
]);
?>

<div class="property-index">
  // create action
  <p>
    <?= Html::a('glyphicon glyphicon-plus', ['create'], [
      'id' => 'property-add',
      'data-toggle' => 'modal',
      'data-target' => '#property-win',
      'class' => 'btn btn-success',
    ]) ?>
  </p>
  <div class="table-responsive">
    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
        'id'
        'name',
        // update, delete actions
        [
          'class' => 'yii\grid\ActionColumn',
          'template' => '{update} {delete}',
          'buttons' => [
            'update' => function ($url, $model) {
              return Html::a(
                '<span class="glyphicon glyphicon-pencil"></span>', 
                $url, [
                  'class' => 'update',
                  'data-toggle' => 'modal',
                  'data-target' => '#property-win',
                ]
              );
            },
          ],
        ],
      ],
    ]); ?>
  </div>
</div>
</pre>

The entire code can be found at - https://github.com/sergmoro1/yii2-lookup.
