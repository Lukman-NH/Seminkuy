<?php

namespace App\Http\Controllers\Python;
use App\Http\Controllers\Controller;

use\App\User;
use\App\Rating;
use\App\Event;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PythonController extends Controller {
    public function index() {
        // Call method export
        (new PythonController)->export();


        // Execute Phyton script
        $command = base_path('app\Http\Controllers\Python\ibcf-events.py');
        $output  = shell_exec($command);

        // Setup data
        $rating_predictions = file(storage_path('app/public/assets/ibcf-test/prediction.csv'), FILE_IGNORE_NEW_LINES);
        $collection_users   = User::all();
        $collection_events  = Event::all();

        foreach ($collection_users as $key => $value) {
            $users[]        = $value['name'];
        }

        foreach ($collection_events as $key => $value) {
            $events_id[]    = $value['id'];
            $names[]        = $value['name'];
            $slugs[]        = $value['slug'];
            $harga[]        = $value['harga'];
        }

        // Merge same events_id to one row only and manipulate to array
        $collection_images = DB::table('events')
            ->join('event_galleries', 'events.id', '=', 'event_galleries.events_id')
            ->select('event_galleries.events_id', 'event_galleries.photos')
            ->groupBy('event_galleries.events_id')
            ->get();

        $array_images = json_decode(json_encode($collection_images), true);

        foreach ($array_images as $key => $value) {
            $images[] = $value['photos'];
        }


        // Mapping to array
        $result1 = array_map(function ($name, $rating_predictions) {
            return array('name' => $name, 'rating_prediction' => $rating_predictions);
        }, $users, $rating_predictions);


        // Search value in multidimensional array
        $search = Auth::user()->name;
        $found  = array_filter($result1, function ($result1) use ($search) {
            return $result1['name'] == $search;
        }, ARRAY_FILTER_USE_BOTH);

        $prediction = array_values($found);


        // Separate rating prediction
        foreach ($prediction as $key => $value) {
            $prediction_separate_values = explode('|', $value['rating_prediction']);
        }


        // Mapping rating prediction with item
        $prediction_for_user_login = array_map(function (
                                                    $id, $name, $slug, $harga, $image, $prediction_separate_value) {
            return array(
                'id'                => $id,
                'name'              => $name,
                'slug'              => $slug,
                'harga'             => $harga,
                'image'             => $image,
                'rating_prediction' => floatval($prediction_separate_value)
            );
        }, $events_id, $names, $slugs, $harga, $images, $prediction_separate_values);

        // Set session
        session()->put('recommender', $prediction_for_user_login);

        return true;
    }

    public function export() {
        // Export users
        $users        = User::all();
        $column_users = array('id', 'name', 'email');

        $handle_users = fopen(storage_path('app/public/assets/ibcf-test/users.csv'), 'w');
        fputcsv($handle_users, $column_users);

        foreach ($users as $user) {
            $row['id']     = $user->id;
            $row['name']   = $user->name;
            $row['email']  = $user->email;

            fputcsv($handle_users, array($row['id'], $row['name'], $row['email']));
        }

        fclose($handle_users);


        // Export items
        $events       = Event::all();
        $column_events= array('id', 'name', 'slug', 'harga');

        $handle_events= fopen(storage_path('app/public/assets/ibcf-test/events.csv'), 'w');
        fputcsv($handle_events, $column_events);

        foreach ($events as $item) {
            $row['id']       = $item->id;
            $row['name']     = $item->name;
            $row['slug']     = $item->slug;
            $row['harga']    = $item->harga;

            fputcsv($handle_events, array($row['id'], $row['name'], $row['slug'],$row['harga']));
        }

        fclose($handle_events);


        // Export ratings
        $ratings        = Rating::all();
        $column_ratings = array('users_id', 'events_id', 'rating');

        $handle_ratings = fopen(storage_path('app/public/assets/ibcf-test/ratings.csv'), 'w');
        fputcsv($handle_ratings, $column_ratings);

        foreach ($ratings as $rating) {
            $row['users_id']           = $rating->users_id;
            $row['events_id']          = $rating->events_id;
            $row['rating']             = $rating->rating;

            fputcsv($handle_ratings, array($row['users_id'], $row['events_id'], $row['rating']));
        }

        fclose($handle_ratings);
    }
}
