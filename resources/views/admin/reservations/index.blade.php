@extends('layouts.client')

@if(auth()->user()->unreadNotifications->count())
    <div class="alert alert-info">
        <strong>Notifications</strong>
        <ul class="mt-2">
            @foreach(auth()->user()->unreadNotifications as $notif)
                <li>
                    {{ $notif->data['message'] }}
                    <form method="POST" action="{{ route('notifications.markAsRead', $notif->id) }}" style="display:inline;">
                        @csrf
                        <button class="btn btn-sm btn-outline-success">Marquer comme lu</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endif

