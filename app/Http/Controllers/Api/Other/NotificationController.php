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

        $notifications = $user->notifications()->paginate();
        $countAllNotifications = $user->notifications()->count();
        $countUnreadNotifications = $user->unreadNotifications()->count();

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

        $countUnreadNotifications = $user->unreadNotifications()->count();


        $notifications = $user->notifications()
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();

        return NotificationResource::collection($notifications)
            ->additional([
                'unread' => $countUnreadNotifications
            ]);
    }

    public function show(Request $request, string $id)
    {
        $user = $request->user();

        $notification = $user->notifications()->findOrFail($id);

        if ($notification->read_at === null) {
            $notification->markAsRead();
        }

        return new NotificationResource($notification);
    }

    public function markAsRead(Request $request)
    {
        $user = $request->user();

        $user->unreadNotifications->markAsRead();

        return response()->json([
            'state' => true,
        ]);
    }

    public function destroy(Request $request, string $id)
    {
        $user = $request->user();

        $notification = $user->notifications()->findOrFail($id);

        $state = $notification->delete();

        return response()->json([
            'state' => $state,
        ]);
    }
}
