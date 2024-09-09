<style>
    select.bs-select-hidden, select.selectpicker {
        display: block!important;
    }
</style>
<!-- Tab -->
<div class="popup-tab-content" id="tab">

    <div class="row">
        <div class="col-12">
            <div class="modal-main">Increase Minimum Budget <i class="icon-feather-info" title="Amount can not be refunded once submitted unless job is cancelled." data-tippy-placement="top"></i></div>
        </div>
    </div>

    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row margin-top-10">
            <div class="col-12">
                <div class="modal-description">You may increase your budget whenever you feel necessary. Start by selecting the day you need your budget increased.</div>
            </div>
        </div>

        <div class="row margin-top-20 submit-field">
            <div class="col-12 margin-bottom-20 ">
                <select class="selectpicker" name="date_of_increase" id="selectBudget" title="Select date of increase" data-live-search="true">
                    @forelse($listing->budgetDetails as $budgetDetail)
                        <option @if($budgetDetail->date_time < $currentDate) disabled @endif value="{{ $budgetDetail->id }}_{{ $budgetDetail->budget }}">{{ $budgetDetail->date_time->format('D, F dS, Y') }} @if($budgetDetail->date_time < $currentDate) - Released @else ${{ $budgetDetail->budget }} @endif</option>
                    @empty
                    @endforelse
                </select>
            </div>
            <div class="col-12 submit-field">
                <div class="bidding-field ">
                    <!-- Quantity Buttons -->
                    <div class="qtyButtons">
                        <div class="qtyDec"></div>
                        <input type="number" min="1" id="qtyInput" value="" name="amount" placeholder="1">
                        <div class="qtyInc"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row margin-top-60">
            <div class="col-12 margin-bottom-10 submit-field">
                <input type="text" name="reason" id="reason" placeholder="Explain why you are increasing budget" />
            </div>
{{--            <div class="col-4">--}}
{{--                <input class="margin-bottom-0" placeholder="Enter Code" title="Verify code sent by text message" data-tippy-placement="top" />--}}
{{--            </div>--}}
{{--            <div class="col-auto">--}}
{{--                <a href="#" class="button ripple-effect gray">Send</a>--}}
{{--            </div>--}}
{{--            <div class="col-auto">--}}
{{--                <a href="#" class="button ripple-effect">Verify</a>--}}
{{--            </div>--}}
        </div>
        <div class="row margin-top-10">
            <div class="col-12">
                <a href="javascript:;" onclick="submitIncrease(); return false;" id="submit-increase" class="popup-with-zoom-anim button button-sliding-icon ripple-effect">Submit Increase <i class="icon-material-outline-arrow-right-alt"></i></a>
            </div>
        </div>
        <div class="row margin-top-10">
            <div class="col-6">
                <a href="javascript:;" onclick="jobDetail({{  $listing->id }})" class="popup-with-zoom-anim button-sliding-icon ripple-effect modal-button"><i class="icon-feather-arrow-left"></i> Return to job details</a>
            </div>
        </div>

    </div>

</div>
<script>
$(function(e) {


    /*--------------------------------------------------*/
    /*  Quantity Buttons
    /*--------------------------------------------------*/
    function qtySum(){
        var arr = document.getElementsByName('qtyInput');
        var tot=0;
        for(var i=0;i<arr.length;i++){
            if(parseInt(arr[i].value))
                tot += parseInt(arr[i].value);
        }
    }
    qtySum();

    $(".qtyDec, .qtyInc").on("click", function() {

        var $button = $(this);
        var oldValue = $button.parent().find("input").val() == '' ? 1 :  $button.parent().find("input").val();

        if ($button.hasClass('qtyInc')) {
            $button.parent().find("input").val(parseInt(oldValue) + 1);
        } else {
            if (oldValue > 1) {
                $button.parent().find("input").val(parseInt(oldValue) - 1);
            } else {
                $button.parent().find("input").val(1);
            }
        }

        qtySum();
        $(".qtyTotal").addClass("rotate-x");

    });




    var budgetAmount = 0;
    $('.selectpicker').selectpicker();

    // var tabs = new Tabby('[data-tabs]');
    // $('[data-tabs]').click(function(e) {
    //     var tabbyDiv = $(this).next();
    //     if(tabbyDiv.hasClass('modal-active')) {
    //         tabbyDiv.addClass('tabby-border');
    //     }
    // });
})

    function submitIncrease() {
        var value = $('#selectBudget').val();
        var amnt = $('#qtyInput').val();
        var reason = $('#reason').val();
        var fields = value.split('_');
        var vals = fields[0];
        var url = "{{ route('listing.update-budget') }}";
        $.easyAjax({
            url: url,
            type: "POST",
            data: {'date_of_increase': vals,'amount':amnt,'reason':reason },
            container: "#small-dialog-10",
            success: function (response) {
                assignedJobDetail('{{  $listing->id }}');
            }
        });
    }
</script>
