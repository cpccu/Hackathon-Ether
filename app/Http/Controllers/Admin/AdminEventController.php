<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminEventController extends Controller
{
    public function index()
    {
        $categories = EventCategory::all();
        $events = Event::with('category')->latest()->get();
        return view('admin.events', compact('categories', 'events'));
    }

    public function storeCategory(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:event_categories,name']);
        EventCategory::create($request->all());
        return redirect()->back()->with('success', 'Event category added successfully!');
    }

   public function storeEvent(Request $request)
{
    $request->validate([
        'event_category_id' => 'required|exists:event_categories,id',
        'title' => 'required|string|max:255',
        'banner' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        'date_time' => 'required|date',
        'location' => 'required|string',
        'description' => 'required|string',
        'tags' => 'nullable|string',
        'custom_fields' => 'nullable|array',
    ]);

    $image = $request->file('banner');
    $filename = time() . '_' . uniqid() . '.webp';
    $directory = storage_path('app/public/event_banners');

    if (!file_exists($directory)) {
        mkdir($directory, 0755, true);
    }

    $destinationPath = $directory . '/' . $filename;
    $filePath = $image->getPathname();

    // Convert to WebP using GD safely if available, otherwise fallback to direct storage
    if (function_exists('imagewebp')) {
        $info = getimagesize($filePath);
        $mime = $info['mime'] ?? '';

        $img = match($mime) {
            'image/jpeg' => imagecreatefromjpeg($filePath),
            'image/png' => imagecreatefrompng($filePath),
            default => imagecreatefromstring(file_get_contents($filePath))
        };

        if ($img) {
            if ($mime == 'image/png') {
                imagepalettetotruecolor($img);
                imagealphablending($img, true);
                imagesavealpha($img, true);
            }
            imagewebp($img, $destinationPath, 80);
            imagedestroy($img);
            $bannerPath = 'event_banners/' . $filename;
        } else {
            $bannerPath = $image->store('event_banners', 'public');
        }
    } else {
        $bannerPath = $image->store('event_banners', 'public');
    }

    Event::create([
        'event_category_id' => $request->event_category_id,
        'title' => $request->title,
        'banner' => $bannerPath,
        'date_time' => $request->date_time,
        'location' => $request->location,
        'description' => $request->description,
        'tags' => $request->tags,
        'custom_fields' => $request->custom_fields ?? [],
    ]);

    return redirect()->back()->with('success', 'Event created and optimized to WebP successfully!');
    }

    public function viewRegistrations($id)
{
    $event = Event::with('registrations.user')->findOrFail($id);
    return view('admin.event-registrations', compact('event'));
}

}