<style>
    h3  {
        border-bottom: 1px solid #eee;
    }
</style>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <?php foreach ($permissions as $name => $value): ?>
                <h3>{{ ucfirst($name) }}</h3>
                <?php foreach ($value as $subPermissionTitle => $permissionName): ?>
                    <?php $subPermissionTitle = strstr($subPermissionTitle, '.'); ?>
                    <?php $subPermissionTitle = str_replace('.', '', $subPermissionTitle); ?>
                    <h4>{{ ucfirst($subPermissionTitle) }}</h4>
                    <?php foreach ($permissionName as $permissionAction): ?>
                        <div class="checkbox">
                            <label for="<?php echo "$subPermissionTitle.$permissionAction" ?>">
                                <input name="permissions[<?php echo "$subPermissionTitle.$permissionAction" ?>]" type="hidden" value="false" />
                                <input id="<?php echo "$subPermissionTitle.$permissionAction" ?>" name="permissions[<?php echo "$subPermissionTitle.$permissionAction" ?>]" type="checkbox" class="flat-blue" <?php echo $model->hasAccess("$subPermissionTitle.$permissionAction") ? 'checked' : '' ?> value="true" /> {{ ucfirst($permissionAction) }}
                            </label>
                        </div>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
