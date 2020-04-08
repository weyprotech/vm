<div class="dd3-content"><?= $name ?>
    <div class="pull-right hidden-xs">
        <label for="auth[<?= $menuId ?>][1]">
            <span>View</span>

            <div class="onoffswitch">
                <input type="hidden" name="auth[<?= $menuId ?>][1]" value="0">
                <input type="checkbox" name="auth[<?= $menuId ?>][1]" class="onoffswitch-checkbox" id="auth[<?= $menuId ?>][1]" value="1" <?= ($auth & @$auth[$menuId][1]) ? "checked" : "" ?>>
                <label class="onoffswitch-label" for="auth[<?= $menuId ?>][1]">
                    <span class="onoffswitch-inner" data-swchon-text="Yes" data-swchoff-text="No"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </label>

        <label for="auth[<?= $menuId ?>][2]">
            <span>Edit</span>

            <div class="onoffswitch">
                <input type="hidden" name="auth[<?= $menuId ?>][2]" value="0">
                <input type="checkbox" name="auth[<?= $menuId ?>][2]" class="onoffswitch-checkbox" id="auth[<?= $menuId ?>][2]" value="1" <?= ($auth & @$auth[$menuId][2]) ? "checked" : "" ?>>
                <label class="onoffswitch-label" for="auth[<?= $menuId ?>][2]">
                    <span class="onoffswitch-inner" data-swchon-text="Yes" data-swchoff-text="No"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </label>

        <label for="auth[<?= $menuId ?>][3]">
            <span>Add</span>

            <div class="onoffswitch">
                <input type="hidden" name="auth[<?= $menuId ?>][3]" value="0">
                <input type="checkbox" name="auth[<?= $menuId ?>][3]" class="onoffswitch-checkbox" id="auth[<?= $menuId ?>][3]" value="1" <?= ($auth & @$auth[$menuId][3]) ? "checked" : "" ?>>
                <label class="onoffswitch-label" for="auth[<?= $menuId ?>][3]">
                    <span class="onoffswitch-inner" data-swchon-text="Yes" data-swchoff-text="No"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </label>

        <label for="auth[<?= $menuId ?>][4]">
            <span>Delete</span>

            <div class="onoffswitch">
                <input type="hidden" name="auth[<?= $menuId ?>][4]" value="0">
                <input type="checkbox" name="auth[<?= $menuId ?>][4]" class="onoffswitch-checkbox" id="auth[<?= $menuId ?>][4]" value="1" <?= ($auth & @$auth[$menuId][4]) ? "checked" : "" ?>>
                <label class="onoffswitch-label" for="auth[<?= $menuId ?>][4]">
                    <span class="onoffswitch-inner" data-swchon-text="Yes" data-swchoff-text="No"></span>
                    <span class="onoffswitch-switch"></span>
                </label>
            </div>
        </label>
    </div>
</div>