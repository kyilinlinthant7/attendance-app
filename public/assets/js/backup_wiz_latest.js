/**
 * Created by Kanak on 2/8/16.
 */

'use strict';
//  Author: ThemeREX.com
//  forms-wizard.html scripts
//

(function($) {

    $(document).ready(function() {

        "use strict";

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
                var id = $('#url').val();
                var emp_code = $('#emp_code').val();
                var fingerprint = $('#fingerprint').val();
                var name = $('#name').val();
                var father = $('#father').val();
                var position = $('#position').val();
                var department = $('#department').val();
                var subdepartment = $('#subdepartment').val();
                var branch = $('#branch').val();
                var site = $('#site').val();
                var shift = $('#shift').val();
                var status = $('#status').val();
                var probation_date_from = $('#probation_date_from').val();
                var probation_date_to = $('#probation_date_to').val();
                var permanent_date_from = $('#permanent_date_from').val();
                var permanent_date_to = $('#permanent_date_to').val();
                var resign_date_from = $('#resign_date_from').val();
                var resign_date_to = $('#resign_date_to').val();
                var warning_date_from = $('#warning_date_from').val();
                var warning_date_to = $('#warning_date_to').val();
                var dismiss_date_from = $('#dismiss_date_from').val();
                var dismiss_date_to = $('#dismiss_date_to').val();
                var terminate_date_from = $('#terminate_date_from').val();
                var terminate_date_to = $('#terminate_date_to').val();
                var promotion_date_from = $('#promotion_date_from').val();
                var promotion_date_to = $('#promotion_date_to').val();
                var increment_date_from = $('#increment_date_from').val();
                var increment_date_to = $('#increment_date_to').val();
                var reason = $('#reason').val();
                var sbu = $('#sbu').val();
                var city = $('#city').val();
                var gender = $('#gender').val();
                var dob = $('#dob').val();
                var joindate = $('#joindate').val();
                var service = $('#service').val();
                var age = $('#age').val();
                var agegroup = $('#agegroup').val();
                var basicsalarymonthly = $('#basicsalarymonthly').val();
                var basicsalaryyearly = $('#basicsalaryyearly').val();
                var currency = $('#currency').val();
                var covid = $('#covid').val();
                var marital = $('#marital').val();
                var child = $('#child').val();
                var parent = $('#parent').val();
                var nrc = $('#nrc').val();
                var sbb = $('#sbb').val();
                var education = $('#education').val();
                var phone = $('#phone').val();
                var resaddress = $('#resaddress').val();
                var principle = $('#principle').val();
                var email = $('#email').val();
                var report = $('#report').val();
                
                // var formData = new FormData();
                // formData.append('photo', $('#photo')[0].files[0]);
                
                var attach_file = $('#attach_file').val();
                // var photo = $('#photo').val();
                var url = $('#url').val();
                var photo = $('#photo')[0].files[0];
                
                $.ajax({
                        type: 'post',
                        url: '/add-employee',
                        data: {
                            "_token": "{{ csrf_token() }}",
                            'id':id,
                            'emp_code':emp_code,
                            'fingerprint':fingerprint,
                            'name':name,
                            'father':father,
                            'position':position,
                            'department':department,
                            'subdepartment':subdepartment,
                            'branch':branch,
                            'site':site,
                            'shift':shift,
                            'status':status,
                            'probation_date_from':probation_date_from,
                            'probation_date_to':probation_date_to,
                            'permanent_date_from':permanent_date_from,
                            'permanent_date_to':permanent_date_to,
                            'resign_date_from':resign_date_from,
                            'resign_date_to':resign_date_to,
                            'warning_date_from':warning_date_from,
                            'warning_date_to':warning_date_to,
                            'dismiss_date_from':dismiss_date_from,
                            'dismiss_date_to':dismiss_date_to,
                            'terminate_date_from':terminate_date_from,
                            'terminate_date_to':terminate_date_to,
                            'promotion_date_from':promotion_date_from,
                            'promotion_date_to':promotion_date_to,
                            'increment_date_from':increment_date_from,
                            'increment_date_to':increment_date_to,
                            'reason':reason,
                            'sbu' : sbu,
                            'city':city,
                            'gender':gender,
                            'dob':dob,
                            'joindate':joindate,
                            'service':service,
                            'age':age,
                            'agegroup':agegroup,
                            'basicsalarymonthly':basicsalarymonthly,
                            'basicsalaryyearly':basicsalaryyearly,
                            'currency':currency,
                            'covid':covid,
                            'marital':marital,
                            'child':child,
                            'parent':parent,
                            'nrc':nrc,
                            'sbb':sbb,
                            'education':education,
                            'phone':phone,
                            'resaddress':resaddress,
                            'principle':principle,
                            'email':email,
                            'report':report,
                            'attach_file':attach_file,
                            'photo':photo,    
                        },
                        dataType:"json",
                        success: function (result) {
                           
                            $('#modal-header').attr('class', 'modal-header ');
                            $('.modal-title').append("Success Message");
                            
                            if (id) {
                                $('.modal-body').append("Update Successful");
                            } else {
                                $('.modal-body').append("Add Successful");
                            }
                            
                            $('#notification-modal').modal('show'); 
                            
                            $('#ok').on("click",function() {
                              window.location.reload();
                            });
                            
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

})(jQuery);
