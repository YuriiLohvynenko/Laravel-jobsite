<!-- Tab -->
<div class="popup-tab-content" id="tab">

    <!-- Welcome Text -->
    <div class="padding-bottom-0">

        <div class="row">
            <div class="col-12 none">
                <div class="modal-main">Public Listing Feedback</div>
            </div>
        </div>

        <div class="row margin-top-20">
            <div class="col-12 feedback-yes-no">
                <strong>Rating Received</strong>
                <div>No rating submitted</div>
            </div>
        </div>

        <div class="row margin-top-20">
            <div class="col-12 feedback-yes-no">
                <strong>Rating Given</strong>
                <!-- Content -->
                <div class="item-content">
                    <div>{{ $freelancerFeedback->people->name }}</div>
                    <div class="row margin-top-5">
                        <div class="col-6 star-rating" data-rating="{{ $freelancerFeedback->rating }}"></div>
                        <div class="col-6 detail-item"><i class="icon-material-outline-date-range"></i> {{ $freelancerFeedback->created_at->format('F  Y ') }}</div>
                    </div>
                    <div class="item-description margin-top-10">
                        <p>{{ $freelancerFeedback->description }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    starRating('.star-rating');
    function starRating(ratingElem) {

        $(ratingElem).each(function() {

            var dataRating = $(this).attr('data-rating');

            // Rating Stars Output
            function starsOutput(firstStar, secondStar, thirdStar, fourthStar, fifthStar) {
                return(''+
                '<span class="'+firstStar+'"></span>'+
                '<span class="'+secondStar+'"></span>'+
                '<span class="'+thirdStar+'"></span>'+
                '<span class="'+fourthStar+'"></span>'+
                '<span class="'+fifthStar+'"></span>');
            }

            var fiveStars = starsOutput('star','star','star','star','star');

            var fourHalfStars = starsOutput('star','star','star','star','star half');
            var fourStars = starsOutput('star','star','star','star','star empty');

            var threeHalfStars = starsOutput('star','star','star','star half','star empty');
            var threeStars = starsOutput('star','star','star','star empty','star empty');

            var twoHalfStars = starsOutput('star','star','star half','star empty','star empty');
            var twoStars = starsOutput('star','star','star empty','star empty','star empty');

            var oneHalfStar = starsOutput('star','star half','star empty','star empty','star empty');
            var oneStar = starsOutput('star','star empty','star empty','star empty','star empty');

            // Rules
            if (dataRating >= 4.75) {
                $(this).append(fiveStars);
            } else if (dataRating >= 4.25) {
                $(this).append(fourHalfStars);
            } else if (dataRating >= 3.75) {
                $(this).append(fourStars);
            } else if (dataRating >= 3.25) {
                $(this).append(threeHalfStars);
            } else if (dataRating >= 2.75) {
                $(this).append(threeStars);
            } else if (dataRating >= 2.25) {
                $(this).append(twoHalfStars);
            } else if (dataRating >= 1.75) {
                $(this).append(twoStars);
            } else if (dataRating >= 1.25) {
                $(this).append(oneHalfStar);
            } else if (dataRating < 1.25) {
                $(this).append(oneStar);
            }

        });

    }
</script>