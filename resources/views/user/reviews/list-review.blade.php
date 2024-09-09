@if($type == 'freelancer')
    <!-- Content -->
    <div class="item-content">
        <h4>{{ ucfirst($listing->job_title) }}</h4>
        <div class="item-details margin-top-10" >
            <div class="star-rating rating{{$listing->id}}" data-rating="{{ $listing->freelance_feedback->rating }}"></div>
            <div class="detail-item"><i class="icon-material-outline-date-range"></i>{{ $listing->freelance_feedback->created_at->format('F  Y ')}}</div>
        </div>
        <div class="item-description">
            <p> {{ $listing->freelance_feedback->description }}</p>
        </div>
    </div>

@else
    <!-- Content -->
        <div class="item-content">
                <h4>{{ ucfirst($listing->job_title) }}</h4>
                <div class="item-details margin-top-10" >
                    <div class="star-rating rating{{$listing->id}}" data-rating="{{ $listing->freelance_client->rating }}"></div>
                    <div class="detail-item"><i class="icon-material-outline-date-range"></i>{{ $listing->freelance_client->created_at->format('F  Y ')}}</div>
                </div>
                <div class="item-description">
                    <p> {{ $listing->freelance_client->description }}</p>
                </div>
            </div>
@endif