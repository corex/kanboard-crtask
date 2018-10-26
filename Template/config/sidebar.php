<li <?= $this->app->checkMenuSelection('ConfigStatusController', 'show', 'CRTask') ?>>
    <?= $this->url->link(t('Task colors'), 'TaskColorController', 'show', ['plugin' => 'CRTask']) ?>
</li>
