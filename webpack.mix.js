const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

let productionSourceMaps = false;

mix.scripts([
    'resources/js/custom/vendors/bower_components/jquery/dist/jquery.min.js',
    'resources/js/custom/vendors/bower_components/bootstrap/dist/js/bootstrap.min.js',
    'resources/js/custom/vendors/bower_components/jasny-bootstrap/dist/js/jasny-bootstrap.min.js',
    'resources/js/custom/vendors/bower_components/bootstrap-validator/dist/validator.min.js',
    'resources/js/custom/vendors/bower_components/moment/min/moment-with-locales.min.js',
    'resources/js/custom/vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
    'resources/js/custom/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    'resources/js/custom/vendors/bower_components/bootstrap-daterangepicker/daterangepicker.js',
    'resources/js/custom/js/form-picker-data.js',
    'resources/js/custom/vendors/bower_components/summernote/dist/summernote.min.js',
    'resources/js/custom/js/summernote-data.js',
    'resources/js/custom/vendors/bower_components/wysihtml5x/dist/wysihtml5x.min.js',
    'resources/js/custom/vendors/bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.all.js',
    'resources/js/custom/js/bootstrap-wysuhtml5-data.js',
    'resources/js/custom/js/db.js',
    'resources/js/custom/vendors/bower_components/jsgrid/dist/jsgrid.min.js',
    'resources/js/custom/js/jsgrid-data.js',
    'resources/js/custom/vendors/jquery.sparkline/dist/jquery.sparkline.min.js',
    'resources/js/custom/vendors/bower_components/echarts/dist/echarts-en.min.js',
    'resources/js/custom/vendors/echarts-liquidfill.min.js',
    'resources/js/custom/js/jquery.slimscroll.js',
    'resources/js/custom/js/dropdown-bootstrap-extended.js',
    'resources/js/custom/vendors/bower_components/owl.carousel/dist/owl.carousel.min.js',
    'resources/js/custom/vendors/bower_components/switchery/dist/switchery.min.js',
    'resources/js/custom/js/dashboard.js',
    'resources/js/custom/js/init.js',
    'resources/js/custom/js/form-advance-data.js',
    'resources/js/custom/vendors/bower_components/datatables/media/js/jquery.dataTables.min.js',
    'resources/js/custom/js/dataTables-data.js',
    'resources/js/custom/vendors/bower_components/editable-table/mindmup-editabletable.js',
    'resources/js/custom/vendors/bower_components/editable-table/numeric-input-example.js',
    'resources/js/custom/js/editable-table-data.js',
    'resources/js/custom/vendors/bower_components/waypoints/lib/jquery.waypoints.min.js',
    'resources/js/custom/vendors/bower_components/jquery.counterup/jquery.counterup.min.js',
    'resources/js/custom/vendors/bower_components/sweetalert/dist/sweetalert.min.js',
    'resources/js/custom/js/sweetalert-data.js',
    'resources/js/custom/js/sweetalert2.min.js',
    'resources/js/custom/vendors/bower_components/moment/min/moment.min.js',
    'resources/js/custom/vendors/bower_components/simpleWeather/jquery.simpleWeather.min.js',
    'resources/js/custom/js/simpleweather-data.js',
    'resources/js/custom/vendors/bower_components/fullcalendar/dist/fullcalendar.min.js',
    'resources/js/custom/js/fullcalendar-data.js',
    'resources/js/custom/vendors/chart.js/Chart.min.js',
    'resources/js/custom/vendors/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js',
    'resources/js/custom/vendors/bower_components/echarts/dist/echarts-en.min.js',
    'resources/js/custom/vendors/echarts-liquidfill.min.js',
    'resources/js/custom/vendors/ecStat.min.js',
    'resources/js/custom/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js',
    'resources/js/custom/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.js',
    'resources/js/custom/vendors/bower_components/messagebox/dist/messagebox.js',
    'resources/js/custom/vendors/bower_components/moment/min/moment-with-locales.min.js',
    'resources/js/custom/vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js',
    'resources/js/custom/vendors/bower_components/select2/dist/js/select2.full.min.js',
    'resources/js/custom/vendors/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js',
    'resources/js/custom/vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js',
    'resources/js/custom/vendors/bower_components/multiselect/js/jquery.multi-select.js',
    'resources/js/custom/vendors/bower_components/bootstrap-switch/dist/js/bootstrap-switch.min.js',
    'resources/js/custom/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js',
    'resources/js/custom/js/custom.js',
    'resources/js/custom/js/bootstrap-popover-x.js',
    'resources/js/custom/js/countdown.js',
    'resources/js/custom/js/user.js',
    'resources/js/custom/js/jobListGrid.js',
    'resources/js/custom/js/jobStatusGrid.js',
    'resources/js/custom/js/checkListGrid.js',
    'resources/js/custom/js/checkListAdd.js',
    'resources/js/custom/js/taskGrid.js',
    'resources/js/custom/js/taskAdd.js',
    'resources/js/custom/js/taskActivities.js',
    'resources/js/custom/js/notification.js',
    'resources/js/custom/js/emailListGrid.js',
    'resources/js/app.js',
], 'public/js/all.js').sourceMaps(productionSourceMaps, 'source-map');

mix.styles([
    'resources/js/custom/vendors/vectormap/jquery-jvectormap-2.0.2.css',
    'resources/js/custom/vendors/bower_components/morris.js/morris.css',
    'resources/js/custom/vendors/bower_components/fullcalendar/dist/fullcalendar.css',
    'resources/js/custom/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
    'resources/js/custom/vendors/bower_components/mjolnic-bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css',
    'resources/js/custom/vendors/bower_components/select2/dist/css/select2.min.css',
    'resources/js/custom/vendors/bower_components/switchery/dist/switchery.min.css',
    'resources/js/custom/vendors/bower_components/messagebox/dist/messagebox.css',
    'resources/js/custom/vendors/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css',
    'resources/js/custom/vendors/bower_components/bootstrap-tagsinput/dist/bootstrap-tagsinput.css',
    'resources/js/custom/vendors/bower_components/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.css',
    'resources/js/custom/vendors/bower_components/multiselect/css/multi-select.css',
    'resources/js/custom/vendors/bower_components/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css',
    'resources/js/custom/vendors/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css',
    'resources/js/custom/vendors/bower_components/jsgrid/dist/jsgrid.min.css',
    'resources/js/custom/vendors/bower_components/jsgrid/dist/jsgrid-theme.min.css',
    'resources/js/custom/vendors/bower_components/FooTable/compiled/footable.bootstrap.min.css',
    'resources/css/custom/css/style.css',
    'resources/js/custom/vendors/bower_components/bootstrap/dist/css/bootstrap.min.css',
    'resources/js/custom/vendors/bower_components/jasny-bootstrap/dist/css/jasny-bootstrap.min.css',
    'resources/js/custom/vendors/bower_components/datatables/media/css/jquery.dataTables.min.css',
    'resources/js/custom/vendors/bower_components/jquery-toast-plugin/dist/jquery.toast.min.css',
    'resources/js/custom/vendors/bower_components/sweetalert/dist/sweetalert.css',
    'resources/css/custom/css/sweetalert2.min.css',
    'resources/js/custom/vendors/bower_components/summernote/dist/summernote.css',
    'resources/js/custom/vendors/bower_components/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.css',
], 'public/css/all.css').sourceMaps(productionSourceMaps, 'source-map');

if (mix.inProduction()) {
    mix.version();
}

// multiple files
mix.browserSync({
    files: ['public/css/all.css', 'public/js/all.js'],
});