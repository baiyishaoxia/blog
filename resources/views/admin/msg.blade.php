@if(count($errors) > 0)
    <div class="alert_msg" style="display: none">
        {{$errors->all()[0]}}
    </div>
    <script type="text/javascript">
        $(function () {
            layer.msg($('.alert_msg').html());
        })
    </script>
@endif
@if (Session::has('success'))
    <div class="alert_msg" style="display: none">
        {{ Session::get('success') }}
    </div>
    <script type="text/javascript">
        $(function () {
            layer.msg($('.alert_msg').html());
        })
    </script>
@endif