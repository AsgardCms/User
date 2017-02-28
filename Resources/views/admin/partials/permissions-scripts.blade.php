<script>
    $( document ).ready(function() {
        $('.jsSelectAllInGroup').on('click',function (event) {
            event.preventDefault();
            $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
                $('input[type=hidden][name="' +$(value).attr('name')+ '"]').attr('disabled', false);
                $(value).iCheck('check').iCheck('determinate');
            });
        });
        $('.jsDeselectAllInGroup').on('click',function (event) {
            event.preventDefault();
            $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
                $('input[type=hidden][name="' +$(value).attr('name')+ '"]').attr('disabled', false);
                $(value).iCheck('uncheck').iCheck('determinate');
            });
        });
        $('.jsInheritAllInGroup').on('click',function (event) {
            event.preventDefault();
            $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
                $('input[type=hidden][name="' +$(value).attr('name')+ '"]').attr('disabled', true);
                $(value).iCheck('indeterminate');
            });
        });
        $('.jsSwapAllInGroup').on('click',function (event) {
            event.preventDefault();
            $(this).closest('.permissionGroup').find('input[type=checkbox]').each(function (index, value) {
                $('input[type=hidden][name="' +$(value).attr('name')+ '"]').attr('disabled', false);
                $(value).iCheck('toggle').iCheck('determinate');
            });
        });
    });
</script>
