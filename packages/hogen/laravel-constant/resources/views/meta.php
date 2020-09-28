<?= '<?php' ?>

namespace PHPSTORM_META {

/**
* PhpStorm meta file, to provide autocomplete information for PhpStorm
* Generated on <?= date("Y-m-d H:i:s") ?>.
*/

<?php foreach ($keyMethods as $method): ?>
    override(<?= $method ?>, map([
    '' => '@',
    <?php foreach ($constantKeys as $key): ?>
        '<?= $key ?>' => \stdClass::class,
    <?php endforeach; ?>
    ]));
<?php endforeach; ?>

<?php foreach ($valueMethods as $method): ?>
    override(<?= $method ?>, map([
    '' => '@',
    <?php foreach ($constantValueKeys as $key): ?>
        '<?= $key ?>' => \stdClass::class,
    <?php endforeach; ?>
    ]));
<?php endforeach; ?>

}
