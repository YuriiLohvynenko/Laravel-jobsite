
/**
 * Tuna Signup Form Wizard
 * @type Javascript Class
 */
var tunaWizard = {
    stepCount: 0,
    slider:null,
    /**
     * Resize for Responsive
     */
    setResponsive: function () {
        var self = this;
        var windowHeight = $(window).height();
        var windowWidth = $(window).width();
        windowHeight = windowHeight > 360 ? windowHeight : 360;
        var tunaContainer = $(".tuna-signup-container");
        var tunaLeft = $(".tuna-signup-left");
        var tunaRight = $(".tuna-signup-right");

        if (windowWidth >= 768) {
            tunaContainer.add(tunaLeft).add(tunaRight).innerHeight(windowHeight);
        } else {
            tunaContainer.add(tunaLeft).add(tunaRight).css("height", "auto");
        }

        //Testimonail Slider Show/Hide
        var sliderContainer = $(".tuna-slider-container");
        if (windowHeight < 600 || windowWidth < 768) {
            sliderContainer.hide();
        } else {
            sliderContainer.show();
            //Reload slider because of hidden
            self.slider.reloadSlider();
        }
        if (windowHeight < 400) {
            $(".button-container").css("bottom", "50px");
        }

    },
    /**
     * Change Step
     * @param int currentStep
     * @param int nextStep
     * @returns {void|Boolean}
     */
    changeStep: function (currentStep, nextStep) {
        var self = this;

        if (nextStep <= 0 && nextStep > 4) {
            return false;
        }

        var error = false;

            if(nextStep > currentStep){
            $('#current-step-' + currentStep + ' .active-question-opacity input, #current-step-'+ currentStep +' .active-question-opacity select').each(function(){
                var current_input_name = $(this).attr("name");

                if ( $(this).attr("type") == "text" && $(this).val().trim() === "") {
                    self.setInputError($($("input[name='"+ current_input_name +"']")));
                    error = true;
                    return;
                } else if ($(this).attr("type") == "checkbox" && $("input[name='"+ current_input_name +"']:checked").length == 0){
                    self.setInputError($("input[name='"+ current_input_name +"']"));
                    error = true;
                    return;
                } else if ($(this).attr("type") == "radio" && $("input[name='"+ current_input_name +"']:checked").val() === undefined){
                    self.setInputError($("input[name='"+ current_input_name +"']"));
                    error = true;
                    return;
                } else if($(this).attr("type") == undefined && $(this).val().trim() === ""){
                    self.setInputError($($("select[name='"+ current_input_name +"']")));
                    error = true;
                    return;
                }
            });
            if(error){
                return;
            } else {
                self.additionalQuestionStepFix(currentStep, true);

                if($('#current-step-' + currentStep + ' .active-question-opacity').length != 0){
                    return;
                } else {
                    self.additionalQuestionStepFix(parseInt(currentStep) + 1, false);
                }
            }
        } else {
            $('#current-step-' + currentStep + ' .question').removeClass('active-question-opacity');
            $('#current-step-' + nextStep + ' .question').removeClass('step-hide').removeClass('active-question-opacity').show();
            self.additionalQuestionStepFix(parseInt(nextStep), false);
        }

        //Change Step
        if (nextStep > currentStep) {
            $(".step-active").removeClass("step-active").addClass("step-hide");
        } else {
            $(".step-active").removeClass("step-active");
        }

        // change step bar
        $("#st-control-"+currentStep).removeProp("checked");
        $("#st-control-"+nextStep).prop("checked", "checked");
        $("a[href=#st-panel-" + currentStep + "]").css("cursor", "pointer");

        var nextStepEl = $(".step[data-step-id='" + nextStep + "']");
        nextStepEl.removeClass("step-hide").addClass("step-active");

        //Focus Input
        window.setTimeout(function () {
            if (nextStep !== self.stepCount) {
                nextStepEl.find("input").focus();
            }
        }, 500);

        var stepCountsEl = $(".steps-count");
        if (nextStep === self.stepCount) {
            stepCountsEl.html("CONFIRM DETAILS");
            $(".button-container").hide();
            var stepConfirm = $(".step-confirm");

            $('.step-current input, .step-current select').each(function(){
                var current_input_name = $(this).attr("name");

                if($(this).attr("type") == "text"){
                    stepConfirm.find("input[name='"+ current_input_name +"']").val($(this).val());
                } else if ($(this).attr("type") == "checkbox" && $("input[name='"+ current_input_name +"']:checked")){
                    var multiple_input = $("input[name='"+ current_input_name + "']:checked").map(function() {
                        return this.value;
                    }).get();
                    stepConfirm.find("select[name='"+ current_input_name +"']").selectpicker("val", multiple_input);
                } else if ($(this).attr("type") == "radio" && $("input[name='"+ current_input_name +"']:checked")){
                    stepConfirm.find("select[name='"+ current_input_name +"']").selectpicker("val", $("input[name='"+ current_input_name +"']:checked").val());
                } else if($(this).attr("type") == undefined){
                    stepConfirm.find("select[name='"+ current_input_name +"']").selectpicker("val", $(this).val());
                } else if ($(this).attr("type") == "file"){
                    if($('.qq-upload-list li').length > 0){
                        var html = '';
                        $('.qq-upload-list li').each(function(index){
                            var file_name = $(this).find('.qq-upload-file').clone().removeAttr('class').html();
                            var image_src = $(this).find('.qq-thumbnail-selector').first().attr('src');
                            html += '<div class="attachment-filename">'+ file_name +'</div>';
                            html += '<input type="hidden" name="attachment_filename[]" value="'+ file_name +'"/>';
                            html += '<div class="attachment-image"><img src="'+ image_src +'"/></div></br>';
                            html += '<input type="hidden" name="attachment_image[]" value="'+ image_src +'"/>';
                        });

                        $('.fine-uploader-result').html(html);
                    }
                }

            });
        }

        //Current Step Number update
        stepCountsEl.find("span.step-current").text(nextStep);

        //Hide prevButton if we are in first step
        var prevStepEl = $(".prevStep");
        if (nextStep === 1) {
            prevStepEl.hide();
        } else {
            prevStepEl.css("display", "inline-block");
        }
    },
    /**
     * Show Validation Message
     * @param HtmlElement el
     * @returns void
     */
    setInputError: function(el) {
        el.addClass("input-error");
        el.parents(".question").find(".help-info").hide();
        el.parents(".question").find(".help-error").show();
    },
    additionalQuestionStepFix: function(currentStep, submit){
        var current_steps_question = '#current-step-'+ currentStep +' .question';
        var current_steps_active_question = '#current-step-'+ currentStep +' .active-question-opacity';
        if($(current_steps_active_question).length == 0){
            $(current_steps_question).each(function (index, element) {
                // Focuses on name input, when page loaded
                window.setTimeout(function() {
                    $("#current-step-"+ currentStep +" input:first").focus();
                }, 500);

                if (index == 0) {
                    $(this).removeClass('inactive-question-opacity').addClass('active-question-opacity').show();
                } else if (index == 1) {
                    $(this).removeClass('active-question-opacity').addClass('inactive-question-opacity');
                    $(this).find('input').prop('disabled', true);
                }

                if(index > 1){
                    $(this).hide();
                }
            });
        }

        if(submit){
            var this_current_question_opacity = $('#current-step-' + currentStep + ' .active-question-opacity');

            //if(this_current_question_opacity.nextUntil('.step-current').length > 0){
                this_current_question_opacity.fadeOut(200);
                var active_question = this_current_question_opacity.next('.question');
                var inactive_question = this_current_question_opacity.next('.question').next('.question');
                active_question.find('input').prop('disabled', false).focus();
                inactive_question.find('input').prop('disabled', true);
                active_question.removeClass('inactive-question-opacity').addClass('active-question-opacity').fadeIn(200);
                inactive_question.removeClass('active-question-opacity').addClass('inactive-question-opacity').show();
                $('#current-step-' + currentStep + ' .active-question-opacity:first').removeClass('active-question-opacity');
            //}
        }

    },
    /**
     * Check email is valid or not
     * @param String value
     * @returns Boolean
     */
    isEmail: function(value) {
        value = value.toLowerCase();
        var reg = new RegExp(/^[a-z]{1}[\d\w\.-]+@[\d\w-]{3,}\.[\w]{2,3}(\.\w{2})?$/);
        return reg.test(value);
    },
    /**
     * Executes Signup Wizard
     * @returns void
     */
    start: function() {
        var self = this;
        /**
         * Testimonial Slider - Uses bxslider jquery plugin
         */
        self.slider = $('.tuna-slider').bxSlider({
            controls: false, // Left and Right Arrows
            auto: true, // Slides will automatically transition
            mode: 'horizontal', // horizontal,vertical,fade
            pager: true, // true, a pager will be added
            speed: 500, // Slide transition duration (in ms)
            pause: 5000 // The amount of time (in ms) between each auto transition
        });

        //Jquery Uniform Plugin
        //$(".tuna-signup-container input[type='checkbox'],.tuna-signup-container input[type='radio'],.tuna-signup-container input[type='file'],.select").uniform();
        $(".tuna-signup-container input[type='checkbox'],.tuna-signup-container input[type='radio'],.select").uniform();

        //Jquery Mask Plugin
        $('.tuna-signup-container input[name="phone"],.tuna-signup-container input[name="tn_phone"]').mask('000 000 00 00');

        // Responsive
        self.setResponsive();
        $(window).resize(function() {
            self.setResponsive();
        });

        // Steps Count
        self.stepCount = $(".tuna-steps .step").length;
        $(".step-count").text(self.stepCount);

        $('.file-edit').click(function(){
             var moveStep = $(this).data('move-tab');
             var stepPrevious = parseFloat(moveStep) - 1;
            $('.button-container').show();
            self.changeStep(moveStep, stepPrevious);
        });

        // Next Step
        $(".nextStep").on("click", function() {
            var currentStep = $(".step-active").attr("data-step-id")
            var nextStep = parseFloat(currentStep) + 1;
            self.changeStep(currentStep, nextStep);
        });

        // Prev Step
        $(".prevStep").on("click", function() {
            var currentStep = $(".step-active").attr("data-step-id");
            var nextStep = parseFloat(currentStep) - 1;
            self.changeStep(currentStep, nextStep);
        });

        // step tab click
        $(".st-add").on("click", function(){
            var request_step = $(this).prop("href").split("-").pop();
            request_step = parseInt(request_step, 10);

            var currentStep = $(".step-active").attr("data-step-id");

             //$("#st-control-"+currentStep).removeProp("checked");
             //$("#st-control-"+tabNumber).prop("checked", "checked");
             //
            $('.button-container').show();

            var question_length = $("#current-step-"+ currentStep +" .question").length;

            if(question_length > 0) {
                for(var i = 0; i < question_length; i++){
                    self.changeStep(currentStep, request_step);
                }
            } else {
                self.changeStep(currentStep, request_step);
            }
        });

        // Confirm Details - Show Input
        var stepConfirm = $(".step-confirm");
        stepConfirm.find(".input-container a.editInput").on("click", function() {
            $(this).parent().find("input").focus();
        });

        // Confirm Details - Show Password
        stepConfirm.find(".input-container a.showPass").on("mousedown", function() {
            $(this).parent().find("input").attr("type", "text");
        }).mouseup(function() {
            $(this).parent().find("input").attr("type", "password");
        });

        stepConfirm.find(".input-container input").on("focus", function() {
            $(this).parent().find("a").hide();
        });

        stepConfirm.find(".input-container input").on("focusout", function() {
            if (!$(this).hasClass("confirm-input-error")) {
                $(this).parent().find("a").show();
            }
        })

        stepConfirm.find("select").on('shown.bs.select', function(e) {
            $(this).parents(".form-group").find("a.editInput").hide();
        }).on('hidden.bs.select', function(e) {
            $(this).parents(".form-group").find("a.editInput").show();
        });

        //Press Enter and go to nextStep
        $(".step input").not(".step-confirm input").on("keypress", function(e) {
            if (e.keyCode === 13) {
                $(".nextStep").click();
            }
        });

        var signupForm = $("form[name='signupForm']");
        //Press Enter and submit form
        signupForm.find("input").on("keypress", function(e) {
            if (e.keyCode === 13) {
                signupForm.submit();
            }
        });

        //Finish Button
        $(".finishBtn").on("click", function() {
            signupForm.submit();
        })

        // Form Submit
        signupForm.on("submit", function(e) {

            e.preventDefault();

            $(this).find(".confirm-input-error").removeClass("confirm-input-error");

            var error = false;

            $('.step-current input, .step-current select').each(function(){
                var current_input_name = $(this).attr("name");

                if($(this).attr("type") == "text"){
                    var textInput = $(".step-confirm").find("input[name='"+ current_input_name +"']");
                    if (textInput.val().trim() === "") {
                        textInput.addClass("confirm-input-error").focus();
                        error = true;
                        return;
                    }
                } else if ($(this).attr("type") == "checkbox"){
                    var multipleCheckbox = $(".step-confirm").find("select[name='"+ current_input_name +"']");
                    if (multipleCheckbox.find("option:selected").length === 0) {
                        //add class to parent element, because this is bootstrap-select.
                        multipleCheckbox.parents(".bootstrap-select").addClass("confirm-input-error").focus();
                        multipleCheckbox.selectpicker('toggle');
                        error = true;
                        return;
                    }
                } else if ($(this).attr("type") == "radio" && $("input[name='"+ current_input_name +"']:checked")){

                } else if($(this).attr("type") == undefined){

                }

            });

            if(error){
                return;
            }

            if (!$("input[name='agreement']").prop("checked")) {
                swal({
                    title: "Warning!",
                    text: "You must agree with the terms and conditions.",
                    type: "warning",
                    confirmButtonText: "Ok"
                });
                return;
            }

            swal({
                title: null,
                text: "<img class='tuna_loading' src='images/loading.svg'/> Saving...",
                html: true,
                showConfirmButton: false
            });

            //Send form to php file
            $.post("../php/smtp.php", $(this).serialize(), function(result) {
                if (result.success) {
                    swal({
                        title: "Success",
                        text: "Your information submitted successfully!",
                        type: "success",
                        confirmButtonText: "Ok"
                    });
                } else {
                    swal({
                        title: "Error!",
                        text: result.msg,
                        type: "error",
                        confirmButtonText: "Ok"
                    });
                }
            }, 'json');

        });

        self.additionalQuestionStepFix('1', false);
    },
}


/**
 * Material Input 
 * @returns object
 */
$.fn.materialInput = function() {

    var label;
    var el = this;

    el.find('input.formInput').keydown(function(e) {
        el.setLabel(e.target);
        el.checkFocused(e.target);
    });

    el.find('input.formInput').focusout(function(e) {
        el.setLabel(e.target);
        el.checkUnFocused(e.target);
    });

    this.setLabel = function(target) {
        label = el.find('label[for=' + target.id + ']');
    };

    this.getLabel = function() {
        return label;
    };

    this.checkFocused = function(target) {
        el.getLabel().addClass('active', '');
        $(target).removeClass("input-error");
        $(target).next().hide();
        $(target).parent().find(".info").show();
    };

    this.checkUnFocused = function(target) {
        if ($(target).val().length === 0) {
            el.getLabel().removeClass('active');
        }
    };
};


$(document).ready(function() {

    /**
     * Page Loader
     * If you remove loader, you can delete .tuna-loader-container element from Html, and delete this two rows.
     */
    $(".tuna-loader-container").fadeOut("slow");
    $(".tuna-signup-container").show();


    /**
     * Material Inputs
     * Makes, inputs in selected element material design.
     */
    $(".tuna-steps").materialInput();

    /**
     * Bootstrap Select Plugin
     */
    $(".selectpicker").selectpicker();

    /**
     * Tuna Signup Form Wizard
     * Let's Start
     */
    tunaWizard.start();

});

(function() {
  $('active') .find('.question-box, textarea') .each(function() {
	  $(this).on('change', function() {
		$this = $(this);
		if (this.value !== "") {
		  $this.addClass('transformit');
		} else {
		  $this.removeClass('transformit');
		}
	  });
	});
})();


jQuery.fn.extend({
  autoHeight: function () {
    function autoHeight_(element) {
      return jQuery(element)
        .css({ 'height': 'auto', 'overflow-y': 'hidden' })
        .height(element.scrollHeight);
    }
    return this.each(function() {
      autoHeight_(this).on('input', function() {
        autoHeight_(this);
      });
    });
  }
});

$('.textarea').autoHeight();

$(function() {
            $(".focused").focus();
        });


function autosize(textarea) {
    $(textarea).height(1); // temporarily shrink textarea so that scrollHeight returns content height when content does not fill textarea
    $(textarea).height($(textarea).prop("scrollHeight"));
}

$(document).ready(function () {
    $(document).on("input", ".textarea", function() {
        autosize(this);
    });
    $(".textarea").each(function () {
        autosize(this);
    });
});

var anyFieldReceivedFocus = false;

function fieldReceivedFocus() {
    anyFieldReceivedFocus = true;
}

function focusFirstField() {
    if (!anyFieldReceivedFocus) {
        $(".focused").focus();
    }
}