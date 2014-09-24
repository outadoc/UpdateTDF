/**
 * Created by outadoc on 24/09/14.
 */


(function () {

    $(document).ready(function () {

        $('.nullable').change(function () {
            var dom = $(this).parent().parent().find('input[type=number]');
            dom.attr("disabled", (!(dom.attr("disabled") == "disabled")));
            dom.val("");
        });

    });

})();