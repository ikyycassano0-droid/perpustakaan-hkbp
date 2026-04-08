@extends('user.component.main')

@section('title','Inbox')

@section('user_content')
<div class="container py-4">

<h4 class="mb-4">📬 Inbox Notifikasi</h4>

@php
    use Carbon\Carbon;
@endphp

@foreach($notifications->groupBy(function($item){
    return Carbon::parse($item->created_at)->isToday() ? 'Hari Ini' :
           (Carbon::parse($item->created_at)->isYesterday() ? 'Kemarin' : 'Lama');
}) as $group => $items)

    <h6 class="mt-4 text-muted">📌 {{ $group }}</h6>

    @foreach($items as $notif)
    <div class="card mb-2 shadow-sm border-0 {{ !$notif->is_read ? 'bg-light' : '' }}">
        <div class="card-body">

            <div class="d-flex justify-content-between">
                <strong>{{ $notif->title }}</strong>
                <small class="text-muted">
                    {{ Carbon::parse($notif->created_at)->diffForHumans() }}
                </small>
            </div>

            <div class="mt-1">
                {{ $notif->message }}
            </div>

        </div>
    </div>
    @endforeach

@endforeach

</div>
@endsection