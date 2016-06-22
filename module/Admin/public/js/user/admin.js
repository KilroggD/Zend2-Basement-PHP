/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function () {
    $("form.empty-filter").submit(function () {
        $(this).find('input,select').filter(function () {
            return this.value === ''
        }).prop("disabled", true);
        $(this).find('input[type="submit"]').removeAttr("name");
    });

    $("input[type='checkbox'].checkall").click(function () {
        //на что нацелен чеколл
        var ns = $(this).attr("data-items");
        if ($(this).is(":checked")) {
            $("input[data-item='" + ns + "']").map(function () {
                $(this).prop("checked", true);
            });
        }
        else {
            $("input[data-item='" + ns + "']").map(function () {
                $(this).prop("checked", false);
            });
        }
    });

    $("form[role='list-aggregate']").submit(function () {
        var ns = $(this).attr("data-list"), $form = $(this);
        $("input[data-item='" + ns + "']").map(function () {
            if ($(this).is(':checked')) {
                console.log($(this));
                $form.append("<input type='hidden' name='user[]' value='" + $(this).val() + "' />");
            }
        });
    });

});
