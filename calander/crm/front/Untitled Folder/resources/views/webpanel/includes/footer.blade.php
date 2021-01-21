

<div class="footer clearfix">
    <div class="pull-center">&copy; 2016. Moretti Milano</div>
</div>

@yield('modals')
<div class="modal remoteModal"></div>
<script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/custom.js') }}"></script>

<script>

    $(function () {
        $(".ajaxTable").ajaxtable();

        $(".select2").select2();

        $('.remoteModal').on('shown.bs.modal', function () {
            $(this).removeData('bs.modal');
        });

        $(document).on('focus', '.dp', function (e) {
            $(this).datepicker({
                dateFormat: 'dd/mm/yy',
                autoclose: true
            });
        });

    });

</script>

@yield('scripts')

</body>
</html>