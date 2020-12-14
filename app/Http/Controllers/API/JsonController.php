<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

class JsonController extends Controller
{
    public $contentPath = 'content';
    public function getPost($id)
    {
        return file_get_contents(public_path($this->contentPath . '/posts') . '/' . $id . '.json');
    }

    public function getCategories()
    {
        return file_get_contents(public_path($this->contentPath . '/categories.json'));
    }

    public function getCategory($slug)
    {
        return file_get_contents(public_path($this->contentPath . '/categories') . '/' . $slug . '.json');
    }

    public function getTags()
    {
        return file_get_contents(public_path($this->contentPath . '/tags.json'));
    }

    public function getTag($slug)
    {
        return file_get_contents(public_path($this->contentPath . '/tags') . '/' . $slug . '.json');
    }

    public function getUser($user)
    {
        # code...
    }

    public function getUserProgress($link)
    {
        return file_get_contents(public_path($this->contentPath . '/progress') . '/' . $link . '.json');
    }
}
