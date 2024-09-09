  
var funcBtns ={
  // Display a warning toast, with no title
   alertWarning: function(){
    toastr.warning('Please enter valid ZIP');
  },
  alertOK2:function(){
    // Display a success toast, with a title
    toastr.success('Have fun storming the castle!', 'Miracle Max Says')
  },
  alertError:function(){
    // Display an error toast, with a title
    toastr.error('Please enter valid ZIP!');
  },
  alertError2:function(){
    // Display an error toast, with a title
    toastr.error('More then 2 category not allow!');
  },
  alertError3:function(){
    // Display an error toast, with a title
    toastr.error('Please increse your budget');
  },
  
  alertOK:function(){
    // Override global options
  toastr.success('We do have the Kapua suite available.', 'Turtle Bay Resort', {timeOut: 5000});
  }
  
  alertcreate:function(){
    // Override global options
  toastr.success('List creating successfully', {timeOut: 5000});
  }
};

$(function() {

    function Toast(type, css, msg) {
        this.type = type;
        this.css = css;
        this.msg = 'This is positioned in the ' + msg + '. You can also style the icon any way you like.';
    }

    var toasts = [
        new Toast('error', 'toast-bottom-full-width', 'This is positioned in the bottom full width. You can also style the icon any way you like.'),
        new Toast('info', 'toast-top-full-width', 'top full width'),
        new Toast('warning', 'toast-top-left', 'This is positioned in the top left. You can also style the icon any way you like.'),
        new Toast('success', 'toast-top-right', 'top right'),
        new Toast('warning', 'toast-bottom-right', 'bottom right'),
        new Toast('error', 'toast-bottom-left', 'bottom left')
    ];

    toastr.options.positionClass = 'toast-top-full-width';
    toastr.options.extendedTimeOut = 0; //1000;
    toastr.options.timeOut = 3000;
    toastr.options.fadeOut = 250;
    toastr.options.fadeIn = 0;

    var i = 0;

    $('#tryMe').click(function () {
        $('#tryMe').prop('disabled', true);
        delayToasts();
    });

    function delayToasts() {
        if (i === toasts.length) { return; }
        var delay = i === 0 ? 0 : 2100;
        window.setTimeout(function () { showToast(); }, delay);

        // re-enable the button        
        if (i === toasts.length-1) {
            window.setTimeout(function () {
                $('#tryMe').prop('disabled', false);
                i = 0;
            }, delay + 1000);
        }
    }

    function showToast() {
        var t = toasts[i];
        toastr.options.positionClass = t.css;
        toastr[t.type](t.msg);
        i++;
        delayToasts();
    }
})
