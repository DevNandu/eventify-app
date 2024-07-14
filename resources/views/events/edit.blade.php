@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="display-4">Edit Event</h1>
        <a href="{{ url('/') }}" class="btn btn-link">Eventify</a>
    </div>
    <form action="{{ route('events.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Event Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $event->name) }}" required>
            @if ($errors->has('name'))
                <span class="text-danger">{{ $errors->first('name') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="text" class="form-control" id="start_date" name="start_date" value="{{ old('start_date', $event->start_date) }}" required>
            @if ($errors->has('start_date'))
                <span class="text-danger">{{ $errors->first('start_date') }}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="text" class="form-control" id="end_date" name="end_date" value="{{ old('end_date', $event->end_date) }}" required>
            @if ($errors->has('end_date'))
                <span class="text-danger">{{ $errors->first('end_date') }}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="invite-email">Invite guests (optional):</label>
            <input type="text" id="invite-email" name="invite_emails" class="form-control" placeholder="Enter email addresses, separated by commas">
            <small class="form-text text-muted">You can invite multiple guests by separating their email addresses with commas.</small>
            <button type="button" class="btn btn-primary mt-2" id="send-invite">Send Invite</button>
        </div>

        <button type="submit" class="btn btn-success mt-3">Update</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const startDatePicker = flatpickr("#start_date", {
            minDate: "today",
            dateFormat: "Y-m-d",
            onChange: function(selectedDates, dateStr, instance) {
                endDatePicker.set('minDate', dateStr);
            }
        });
        const endDatePicker = flatpickr("#end_date", {
            minDate: "today",
            dateFormat: "Y-m-d"
        });
    });
</script>
@endsection
