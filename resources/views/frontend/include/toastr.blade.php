<script type="text/javascript">
    $(document).ready(function () {
        var success = '{{ Session::has('success') }}';
        var info = '{{ Session::has('info') }}';
        var error = '{{ Session::has('error') }}';
        var warning = '{{ Session::has('warning') }}';

        if (success) {
            iziToast.success({
                title: 'Yeay!',
                message: '{{ Session::get('success') }}',
                position: 'topRight'
            });
        } else if (info) {
            iziToast.info({
                title: 'Hello!',
                message: '{{ Session::get('info') }}',
                position: 'topRight'
            });
        } else if (error) {
            iziToast.error({
                title: 'Auch!',
                message: '{{ Session::get('error') }}',
                position: 'topRight'
            });
        } else if (warning) {
            iziToast.warning({
                title: 'Caution!',
                message: '{{ Session::get('warning') }}',
                position: 'topRight'
            });
        }
    });

</script>