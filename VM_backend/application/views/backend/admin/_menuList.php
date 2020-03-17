<?php foreach ($menuList[$menuId]['sub'] as $mId) { ?>
    <?php $mrow = $menuList[$mId]; ?>
    <li class="dd-item dd3-item">
        <div class="dd-handle dd3-handle">..</div>
        <?= $this->load->view('backend/admin/_authList', array('menuId' => $mId, 'name' => $mrow['title'], 'auth' => $auth), true) ?>

        <?php if (isset($mrow['sub'])) { ?>
            <ol class="dd-list">
                <?= $this->load->view('backend/admin/_menuList', array('menuId' => $mId, 'menuList' => $menuList, 'auth' => $auth), true) ?>
            </ol>
        <?php 
    } ?>
    </li>
    <?php 
} ?>