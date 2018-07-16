<?php if(count($errors) > 0): ?>
    <div class="alert_msg" style="display: none">
        <?php echo e($errors->all()[0]); ?>

    </div>
    <script type="text/javascript">
        $(function () {
            layer.msg($('.alert_msg').html());
        })
    </script>
<?php endif; ?>
<?php if(Session::has('success')): ?>
    <div class="alert_msg" style="display: none">
        <?php echo e(Session::get('success')); ?>

    </div>
    <script type="text/javascript">
        $(function () {
            layer.msg($('.alert_msg').html());
        })
    </script>
<?php endif; ?>