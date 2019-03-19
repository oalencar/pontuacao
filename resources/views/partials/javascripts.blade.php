<script>
    window.deleteButtonTrans = '{{ trans("quickadmin.qa_delete_selected") }}';
    window.copyButtonTrans = '{{ trans("quickadmin.qa_copy") }}';
    window.csvButtonTrans = '{{ trans("quickadmin.qa_csv") }}';
    window.excelButtonTrans = '{{ trans("quickadmin.qa_excel") }}';
    window.pdfButtonTrans = '{{ trans("quickadmin.qa_pdf") }}';
    window.printButtonTrans = '{{ trans("quickadmin.qa_print") }}';
    window.colvisButtonTrans = '{{ trans("quickadmin.qa_colvis") }}';
</script>

{{--<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>--}}

<script src="{{ asset('js/app.js') }}"></script>

<script src="{{ asset('js/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/libs/bootstrap-datepicker/bootstrap-datepicker.pt-BR.min.js') }}"></script>

<script src="{{ asset('js/libs/jquery-datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/libs/jquery-datatables/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/libs/jquery-datatables/buttons.flash.min.js') }}"></script>
<script src="{{ asset('js/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('js/libs/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/libs/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('js/libs/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/libs/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/libs/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('js/libs/select-datatables/dataTables.select.min.js') }}"></script>
<script src="{{ asset('js/libs/jquery-masky/jquery.mask.min.js') }}"></script>

<script src="{{ url('adminlte/js') }}/bootstrap.min.js"></script>
<script src="{{ url('adminlte/js') }}/select2.full.min.js"></script>
<script src="{{ url('adminlte/js') }}/main.js"></script>


<script src="{{ url('adminlte/plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ url('adminlte/plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ url('adminlte/js/app.min.js') }}"></script>
<script>
    window._token = '{{ csrf_token() }}';
</script>
<script>
    $.extend(true, $.fn.dataTable.defaults, {
        "language": {
            "url": "{{ asset('js/libs/jquery-datatables/Portuguese-Brasil.json') }}"
        }
    });

    // Configurações globais datepicker
    $.fn.datepicker.defaults.language = 'pt-BR';
    $.fn.datepicker.defaults.autoclose = true;
</script>

<script>
    $(function(){
        /** add active class and stay opened when selected */
        var url = window.location;

        // for sidebar menu entirely but not cover treeview
        $('ul.sidebar-menu a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');

        $('ul.treeview-menu a').filter(function() {
            return this.href == url;
        }).parent().addClass('active');

        // for treeview
        $('ul.treeview-menu a').filter(function() {
             return this.href == url;
        }).parentsUntil('.sidebar-menu > .treeview-menu').addClass('menu-open').css('display', 'block');

        $('.score-mask').mask('000.000.000.000.000', {reverse: true});
    });
</script>


@yield('javascript')
