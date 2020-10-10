<?php

// $eventCalendarUrl = "https://outlook.office365.com/calendar/published/4f0028cdb6c24a169d85c4e29376f7fd@spi-global.com/d783d195c73d4b929c1d92ef445d283010132039746096336154/calendar.html#authRedirect=true";

// $eventCalendarUrl = "";

//if($eventCalendarUrl) { ?>

<div class="row pa-0 event-calendar-block" style="display:none;">

    <iframe class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pa-0 event-calendar-frame" style="height:650px;"
        src="" title="events"></iframe>

</div>

<?php //} else { ?>

    <div class="row pa-0 event-calendar-form-block" style="display:none;">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            <div class="col-md-offset-3 col-md-6 col-md-offset-3 pa-20">

                <div class="form-wrap">

                    <form id="event-calendar-form" class="event-calendar-form" action="{{ $userEventCalendarUpdateUrl ?? '' }}">
                        <div class="form-group">
                            <label class="control-label mb-10" for="calendar_url">Please provide published outlook calendar url:</label>
                            <textarea class="form-control" rows="5" id="event-calendar-link" class="event-calendar-link" name="calendar_link"></textarea>
                        </div>
                        <div class="form-group mb-0">
                            <span class="pull-left">
                                For more help please click
                                <a href="{{route('file') . Config::get('constants.emailImageDownloadPathParams') .'GENERIC/calendar_events.mp4'}}"> here </a>
                            </span>
                            <button type="button" class="event-calendar-save-btn btn btn-success btn-anim pull-right">
                                <i class="fa fa-check"></i>
                                <span class="btn-text">save</span>
                            </button>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>

<?php //}?>
