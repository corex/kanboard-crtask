<div class="dropdown">
    <a href="#" class="dropdown-menu dropdown-menu-link-icon"><i class="fa fa-cog"></i><i class="fa fa-caret-down"></i></a>
    <ul>
        <li>
            <?= $this->modal->medium('edit', t('Edit'), 'TaskColorController', 'edit',
                array('plugin' => 'CRTask', 'id' => $color['id'])) ?>
        </li>
        <li>
            <?= $this->modal->confirm('trash-o', t('Remove'), 'TaskColorController', 'confirm',
                array('plugin' => 'CRTask', 'id' => $color['id'])) ?>
        </li>
    </ul>
</div>
