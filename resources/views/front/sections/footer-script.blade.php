<script src="{{ asset('js/jquery-3.3.1.min.js')}}"></script>
<script src="{{ asset('js/jquery-migrate-3.0.0.min.js')}}"></script>
<script src="{{ asset('js/mmenu.min.js')}}"></script>
<script src="{{ asset('js/tippy.all.min.js')}}"></script>
<script src="{{ asset('js/simplebar.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-slider.min.js')}}"></script>
<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('js/snackbar.js')}}"></script>
<script src="{{ asset('js/clipboard.min.js')}}"></script>
<script src="{{ asset('js/counterup.min.js')}}"></script>
<script src="{{ asset('js/magnific-popup.min.js')}}"></script>
<script src="{{ asset('js/slick.min.js')}}"></script>
<script src="{{ asset('js/custom.js')}}"></script>
<script src="{{ asset('js/datepicker.min.js')}}"></script>
<script src="{{ asset('js/datepicker.en.js')}}"></script>
<script src="{{ asset('js/tabby.js')}}"></script>
<script src="{{ asset('js/dropzone.js')}}"></script>
<script src="{{ asset('plugins/helper/helper.js') }}"></script>
<!-- Snackbar // documentation: https://www.polonel.com/snackbar/ -->
<script>
    // Snackbar for user status switcher
    $('#snackbar-user-status label').click(function() {
        Snackbar.show({
            text: 'Your status has been changed!',
            pos: 'bottom-center',
            showAction: false,
            actionText: "Dismiss",
            duration: 3000,
            textColor: '#fff',
            backgroundColor: '#383838'
        });
    });


    // Snackbar for copy to clipboard button
    $('.copy-url-button').click(function() {
        Snackbar.show({
            text: 'Copied to clipboard!',
        });
    });

    // Snackbar for "place a bid" button
    $('#payment-release').click(function() {
        Snackbar.show({
            text: 'Payment Released!',
        });
    });$('#message-sent').click(function() {
        Snackbar.show({
            text: 'Message Sent',
        });
    });$('#submit-increase').click(function() {
        Snackbar.show({
            text: 'Increase Submitted',
        });
    });$('#send-tip').click(function() {
        Snackbar.show({
            text: 'Tip Sent',
        });
    });$('#send-counter').click(function() {
        Snackbar.show({
            text: 'Counter Offer Sent',
        });
    });$('#offer-declined').click(function() {
        Snackbar.show({
            text: 'Offer Declined',
        });
    });$('#offer-accepted').click(function() {
        Snackbar.show({
            text: 'Offer Accepted',
        });
        $('#feedback-left').click(function () {
            Snackbar.show({
                text: 'Feedback/Rating Left',
            });
        });

        var about = document.getElementById("about")
        zenscroll.to(about)


        $('.profilepicker').datepicker({
            language: 'en',
            inline: true,
        })

        var eventDates = [1, 10, 12, 22],
            $picker = $('#custom-cells'),
            $content = $('#custom-cells-events'),
            sentences = [
                'Unloading furniture from Container',
                'Clean my 5 bedroom / 3 bathroom apartment',
                'Carpenter - Skirting and moulding install',
                'Pickup Groceries Every Two Weeks'
            ]
        $picker.datepicker({
            language: 'en',
            onRenderCell: function (date, cellType) {
                var currentDate = date.getDate();
                if (cellType == 'day' && eventDates.indexOf(currentDate) != -1) {
                    return {
                        html: currentDate + '<span class="dp-note"></span>'
                    }
                }
            },
            onSelect: function onSelect(fd, date) {
                var title = '', content = ''
                if (date && eventDates.indexOf(date.getDate()) != -1) {
                    title = fd;
                    content = sentences[Math.floor(Math.random() * eventDates.length)];
                }
                $('strong', $content).html(title)
                $('p', $content).html(content)
            }
        })
        var currentDate = new Date();
        $picker.data('datepicker').selectDate(new Date(currentDate.getFullYear(), currentDate.getMonth(), 10))
    });
</script>

<!-- Chart.js // documentation: http://www.chartjs.org/docs/latest/ -->
<script src="{{ asset('js/chart.min.js')}}"></script>

<!-- Google Autocomplete -->
<script>
    // Autocomplete adjustment for homepage
    if ($('.intro-banner-search-form')[0]) {
        setTimeout(function(){
            $(".pac-container").prependTo(".intro-search-field.with-autocomplete");
        }, 300);
    }
</script>

<script>
    Chart.defaults.global.defaultFontFamily = "Nunito";
    Chart.defaults.global.defaultFontColor = '#888';
    Chart.defaults.global.defaultFontSize = '14';

    new Chart(document.getElementsByClassName("liveupdate"), {
        type: 'doughnut',
        // The data for our dataset
        data: {
            labels: ["Completed", "Cancelled"],
            // Information about the dataset
            datasets: [{
                label: "Views",
                backgroundColor: ["#2a41e8", "#FF9A19"],
                data: [20,4],
                pointRadius: 5,
                pointHoverRadius:5,
                pointHitRadius: 10,
                pointBackgroundColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointBorderWidth: "2",
            }]
        },

        // Configuration options
        options: {
            elements: {
                center: {
                    text: '24',
                    color: '#666', //Default black
                    fontStyle: 'Helvetica', //Default Arial
                    sidePadding: 15 //Default 20 (as a percentage)
                }
            },
            layout: {
                padding: 10,
            },

            legend: { display: false },
            title:  { display: false },

            scales: { display: false },

            tooltips: {
                backgroundColor: '#333',
                titleFontSize: 13,
                titleFontColor: '#fff',
                bodyFontColor: '#fff',
                bodyFontSize: 13,
                displayColors: false,
                xPadding: 10,
                yPadding: 10,
                intersect: false
            }
        },
    });

    new Chart(document.getElementsByClassName("liveupdate1"), {
        type: 'doughnut',
        // The data for our dataset
        data: {
            labels: ["Completed", "Cancelled"],
            // Information about the dataset
            datasets: [{
                label: "Views",
                backgroundColor: ["#2a41e8", "#FF9A19"],
                data: [8,5],
                pointRadius: 5,
                pointHoverRadius:5,
                pointHitRadius: 10,
                pointBackgroundColor: "#fff",
                pointHoverBackgroundColor: "#fff",
                pointBorderWidth: "2",
            }]
        },

        // Configuration options
        options: {

            elements: {
                center: {
                    text: '13',
                    color: '#666', //Default black
                    fontStyle: 'Helvetica', //Default Arial
                    sidePadding: 15 //Default 20 (as a percentage)
                }
            },
            layout: {
                padding: 10,
            },

            legend: { display: false },
            title:  { display: false },

            scales: { display: false },

            tooltips: {
                backgroundColor: '#333',
                titleFontSize: 13,
                titleFontColor: '#fff',
                bodyFontColor: '#fff',
                bodyFontSize: 13,
                displayColors: false,
                xPadding: 10,
                yPadding: 10,
                intersect: false
            }
        },
    });

    Chart.pluginService.register({
        beforeDraw: function (chart) {
            if (chart.config.options.elements.center) {
                //Get ctx from string
                var ctx = chart.chart.ctx;

                //Get options from the center object in options
                var centerConfig = chart.config.options.elements.center;
                var fontStyle = centerConfig.fontStyle || 'Arial';
                var txt = centerConfig.text;
                var color = centerConfig.color || '#000';
                var sidePadding = centerConfig.sidePadding || 20;
                var sidePaddingCalculated = (sidePadding/100) * (chart.innerRadius * 2)
                //Start with a base font of 30px
                ctx.font = "30px " + fontStyle;

                //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                var stringWidth = ctx.measureText(txt).width;
                var elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                // Find out how much the font can grow in width.
                var widthRatio = elementWidth / stringWidth;
                var newFontSize = Math.floor(20 * widthRatio);
                var elementHeight = (chart.innerRadius * 2);

                // Pick a new font size so it will not be larger than the height of label.
                var fontSizeToUse = Math.min(newFontSize, elementHeight);

                //Set font settings to draw it correctly.
                ctx.textAlign = 'center';
                ctx.textBaseline = 'middle';
                var centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                var centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                ctx.font = fontSizeToUse+"px " + fontStyle;
                ctx.fillStyle = color;

                //Draw text in center
                ctx.fillText(txt, centerX, centerY);
            }
        }
    });

    var tabs = new Tabby('[data-tabs]');
    $('[data-tabs]').click(function(e) {
        var tabbyDiv = $(this).next();
        if(tabbyDiv.hasClass('modal-active')) {
            tabbyDiv.addClass('tabby-border');
        }
    });
</script>

<script src="{{ asset('js/zenscroll-min.js')}}"></script>

<!-- Google API -->
{{--<script src=https://maps.googleapis.com/maps/api/js?key=AIzaSyDw9cQQsGxYkPicGbigZG1koUGRC4TAbSs&libraries=places"></script>--}}
{{--<script src="{{ asset('js/infobox.min.js')}}"></script>--}}
{{--<script src="{{ asset('js/markerclusterer.js')}}"></script>--}}
{{--<script src="{{ asset('js/maps.js')}}"></script>--}}
@yield('footerjs')
