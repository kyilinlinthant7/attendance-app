/**
 * Created by Kanak on 2/8/16.
 */

'use strict';
//  Author: ThemeREX.com
//  forms-wizard.html scripts
//

(function($) {

    $(document).ready(function() {
    // Form Wizard
    var form = $("#custom-form-wizard");
    form.validate({
        errorPlacement: function errorPlacement(error, element) {
            element.before(error);
        },
        rules: {
            confirm: {
                equalTo: "#password"
            }
        }
    });
    form.children(".wizard").steps({
        headerTag: ".wizard-section-title",
        bodyTag: ".wizard-section",
        onStepChanging: function(event, currentIndex, newIndex) {
            form.validate().settings.ignore = ":disabled,:hidden";
            return form.valid();
        },
        onFinishing: function(event, currentIndex) {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function(event, currentIndex) {
            event.preventDefault();
            
            // Collect form data
            var formData = new FormData();
            formData.append('id', $('#url').val());
            formData.append('emp_code', $('#emp_code').val());
            formData.append('fingerprint', $('#fingerprint').val());
            formData.append('name', $('#name').val());
            formData.append('father', $('#father').val());
            formData.append('position', $('#position').val());
            formData.append('department', $('#department').val());
            formData.append('subdepartment', $('#subdepartment').val());
            formData.append('branch', $('#branch').val());
            formData.append('site', $('#site').val());
            formData.append('shift', $('#shift').val());
            formData.append('status', $('#status').val());
            formData.append('probation_date_from', $('#probation_date_from').val());
            formData.append('probation_date_to', $('#probation_date_to').val());
            formData.append('permanent_date_from', $('#permanent_date_from').val());
            formData.append('permanent_date_to', $('#permanent_date_to').val());
            formData.append('resign_date_from', $('#resign_date_from').val());
            formData.append('resign_date_to', $('#resign_date_to').val());
            formData.append('warning_date_from', $('#warning_date_from').val());
            formData.append('warning_date_to', $('#warning_date_to').val());
            formData.append('dismiss_date_from', $('#dismiss_date_from').val());
            formData.append('dismiss_date_to', $('#dismiss_date_to').val());
            formData.append('terminate_date_from', $('#terminate_date_from').val());
            formData.append('terminate_date_to', $('#terminate_date_to').val());
            formData.append('promotion_date_from', $('#promotion_date_from').val());
            formData.append('promotion_date_to', $('#promotion_date_to').val());
            formData.append('increment_date_from', $('#increment_date_from').val());
            formData.append('increment_date_to', $('#increment_date_to').val());
            formData.append('reason', $('#reason').val());
            formData.append('sbu', $('#sbu').val());
            formData.append('city', $('#city').val());
            formData.append('gender', $('#gender').val());
            formData.append('dob', $('#dob').val());
            formData.append('joindate', $('#joindate').val());
            formData.append('service', $('#service').val());
            formData.append('age', $('#age').val());
            formData.append('agegroup', $('#agegroup').val());
            formData.append('basicsalarymonthly', $('#basicsalarymonthly').val());
            formData.append('basicsalaryyearly', $('#basicsalaryyearly').val());
            formData.append('currency', $('#currency').val());
            formData.append('covid', $('#covid').val());
            formData.append('marital', $('#marital').val());
            formData.append('child', $('#child').val());
            formData.append('parent', $('#parent').val());
            formData.append('nrc', $('#nrc').val());
            formData.append('sbb', $('#sbb').val());
            formData.append('education', $('#education').val());
            formData.append('phone', $('#phone').val());
            formData.append('resaddress', $('#resaddress').val());
            formData.append('principle', $('#principle').val());
            formData.append('email', $('#email').val());
            formData.append('report', $('#report').val());
            
            formData.append('_token', "{{ csrf_token() }}");

            // Send AJAX request
            $.ajax({
                type: 'post',
                url: '/add-employee',
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function (result) {
                    $('#modal-header').attr('class', 'modal-header ');
                    $('.modal-title').append("Success Message");

                    if ($('#url').val()) {
                        $('.modal-body').append("Update Successful");
                    } else {
                        $('.modal-body').append("Add Successful");
                    }

                    $('#notification-modal').modal('show');

                    $('#ok').on("click",function() {
                        window.location.reload();
                    });
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });

        }
    });

    // Init Wizard
    var formWizard = $('.wizard');
    var formSteps = formWizard.find('.steps');

    $('.wizard-options .holder-style').on('click', function(e) {
        e.preventDefault();

        var stepStyle = $(this).data('steps-style');

        var stepRight = $('.holder-style[data-steps-style="steps-right"]');
        var stepLeft = $('.holder-style[data-steps-style="steps-left"]');
        var stepJustified = $('.holder-style[data-steps-style="steps-justified"]');

        if (stepStyle === "steps-left") {
            stepRight.removeClass('holder-active');
            stepJustified.removeClass('holder-active');
            formWizard.removeClass('steps-right steps-justified');
        }
        if (stepStyle === "steps-right") {
            stepLeft.removeClass('holder-active');
            stepJustified.removeClass('holder-active');
            formWizard.removeClass('steps-left steps-justified');
        }
        if (stepStyle === "steps-justified") {
            stepLeft.removeClass('holder-active');
            stepRight.removeClass('holder-active');
            formWizard.removeClass('steps-left steps-right');
        }

        if ($(this).hasClass('holder-active')) {
            formWizard.removeClass(stepStyle);
        } else {
            formWizard.addClass(stepStyle);
        }

        $(this).toggleClass('holder-active');
    });
});


})
(jQuery);
