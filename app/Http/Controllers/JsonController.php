<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class JsonController extends Controller
{
    public $contentPath = 'content';

    public function getPost($id)
    {
        if (file_exists(public_path($this->contentPath . '/posts') . '/' . $id . '.json')) {
            return @file_get_contents(public_path($this->contentPath . '/posts') . '/' . $id . '.json');
        }
        return response()->json([]);
    }

    public function getCategories()
    {
        if (file_exists(public_path($this->contentPath . '/categories.json'))) {
            return @file_get_contents(public_path($this->contentPath . '/categories.json'));
        }

        return response()->json([]);
    }

    public function getCategory($slug)
    {
        if (file_exists(public_path($this->contentPath . '/categories') . '/' . $slug . '.json')) {
            return @file_get_contents(public_path($this->contentPath . '/categories') . '/' . $slug . '.json');
        }

        return response()->json([]);
    }

    public function getTags()
    {
        if (file_exists(public_path($this->contentPath . '/tags.json'))) {
            return @file_get_contents(public_path($this->contentPath . '/tags.json'));
        }

        return response()->json([]);
    }

    public function getTag($slug)
    {
        if (file_exists(public_path($this->contentPath . '/tags') . '/' . $slug . '.json')) {
            return @file_get_contents(public_path($this->contentPath . '/tags') . '/' . $slug . '.json');
        }

        return response()->json([]);
    }

    public function getUser($user)
    {
        # code...
    }

    public function getUserProgress($link)
    {
        if (file_exists(public_path($this->contentPath . '/progress') . '/' . $link . '.json')) {
            return @file_get_contents(public_path($this->contentPath . '/progress') . '/' . $link . '.json');
        }

        return response()->json([]);
    }

    public function getUserNotification($link)
    {
        if (file_exists(public_path($this->contentPath . '/notification') . '/' . $link . '.json')) {
            return @file_get_contents(public_path($this->contentPath . '/notification') . '/' . $link . '.json');
        }

        return response()->json([]);
    }
}
