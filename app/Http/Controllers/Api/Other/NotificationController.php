<?php

namespace App\Http\Controllers\Api\Other;

use App\Http\Controllers\Controller;
use App\Http\Resources\Notification\NotificationCollectionResource;
use App\Http\Resources\Notification\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $notificationsQuery = $user?->notifications();
        $unreadNotificationsQuery = $user?->unreadNotifications();

        $notifications = $notificationsQuery ? $notificationsQuery->paginate() : collect();
        $countAllNotifications = $notificationsQuery ? $notificationsQuery->count() : 0;
        $countUnreadNotifications = $unreadNotificationsQuery ? $unreadNotificationsQuery->count() : 0;

        return NotificationCollectionResource::collection($notifications)
            ->additional([
                'total' => $countAllNotifications,
                'unread' => $countUnreadNotifications,
            ]);
    }

    public function lastNotification(Request $request)
    {
        $limit = $request->query->getInt('limit', 6);
        $user = $request->user();

        $unreadNotificationsQuery = $user?->unreadNotifications();
        $notificationsQuery = $user?->notifications();

        $countUnreadNotifications = $unreadNotificationsQuery ? $unreadNotificationsQuery->count() : 0;

        $notifications = $notificationsQuery
            ? $notificationsQuery->orderByDesc('created_at')->limit($limit)->get()
            : collect();

        return NotificationResource::collection($notifications)
            ->additional([
                'unread' => $countUnreadNotifications,
            ]);
    }

    public function show(Request $request, string $id)
    {
        $user = $request->user();

        $notification = $user?->notifications()?->findOrFail($id);

        if ($notification && is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return new NotificationResource($notification);
    }

    public function markAsRead(Request $request)
    {
        $user = $request->user();

        if ($user && $user->unreadNotifications) {
            $user->unreadNotifications->markAsRead();
        }

        return response()->json([
            'state' => true,
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();

        $notification = $user?->notifications()?->findOrFail($id);

        $state = $notification ? $notification->delete() : false;

        return response()->json([
            'state' => $state,
        ]);
    }
}
