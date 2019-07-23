Yii2 module for editing models table in a modal window
======================================================

Installation
------------

The preferred way to install this extension is through composer.

Either run

`composer require --prefer-dist sergmoro1/yii2-modal-crud`

or add

`"sergmoro1/yii2-modal-crud": "dev-master"`

to the require section of your composer.json.

Usage
-----

For example, there is a model `Property` with two fields: `id`, `name`. 

###Controller

```php
namespace backend\controllers;

use sergmoro1\modal\controllers\ModalController;

use common\models\Property;
use common\models\PropertySearch;

class PropertyController extends ModalController
{
    public function newModel() { return new Property(); }
    public function newSearch() { return new PropertySearch(); }
}
```

###View

Only matters `index.php`. Other are ordinary.

```php
<?php
use Yii;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

// bind actions
$this->registerJs('var popUp = {"id": "property", "actions": ["update"]};', yii\web\View::POS_HEAD);
sergmoro1\modal\assets\PopUpAsset::register($this);

$this->title = Yii::t('app', 'Properties');

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
```

The entire code can be found at [sergmoro1/yii2-lookup](https://github.com/sergmoro1/yii2-lookup).
