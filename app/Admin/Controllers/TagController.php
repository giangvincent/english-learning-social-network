<?php

namespace App\Admin\Controllers;

use App\Models\Tag;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class TagController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Tag';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Tag());

        $grid->column('id', __('Id'));
        $grid->column('name', __('Name'))->filter('like');
        $states = [
            'off' => ['value' => 'pending', 'text' => 'Pending', 'color' => 'default'],
            'on' => ['value' => 'publish', 'text' => 'Publish', 'color' => 'primary'],
        ];
        $grid->column('status', __('Status'))->switch($states);
        $grid->column('created_at', __('Created at'))->display(function ($created_at) {
            return date("Y-m-d H:i:s", strtotime($created_at));
        });
        $grid->column('updated_at', __('Updated at'))->display(function ($created_at) {
            return date("Y-m-d H:i:s", strtotime($created_at));
        });

        $grid->quickSearch('name');
        $grid->filter(function ($filter) {

            // $filter->date('updated_at', 'Lọc theo ngày tháng');
            $filter->between('updated_at', 'Lọc theo ngày tháng')->datetime();
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Tag::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('slug', __('Slug'));
        $show->field('status', __('Status'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Tag());

        $form->text('name', __('Name'));
        $form->hidden('slug', __('Slug'));
        $states = [
            'on' => ['value' => 'publish', 'text' => 'Publish', 'color' => 'success'],
            'off' => ['value' => 'pending', 'text' => 'Pending', 'color' => 'default'],
        ];
        $form->switch('status', __('Status'))->states($states);
        $form->saving(function (Form $form) {
            $form->name = Str::of($form->name)->lower();
            $form->slug = Str::slug($form->name, "-");
        });

        $form->saved(function (Form $form) {
            $tag = Tag::find($form->model()->id);
            $this->checkFolderContent();
            $this->exportToJson($tag);
            $this->exportTags();
        });

        return $form;
    }

    public function checkFolderContent()
    {
        if (!file_exists(public_path() . '/content/')) {
            mkdir(public_path() . '/content/', 0777);
        }
        if (!file_exists(public_path() . '/content/tags/')) {
            mkdir(public_path() . '/content/tags/', 0777);
        }
    }

    public function exportToJson($tag)
    {
        $data = $tag->toArray();
        // $data['posts'] = $category->posts()->where('status', 1)->select('id', 'title', 'slug', 'summary', 'feature_image', 'updated_at')->orderBy('id', 'desc')->limit(12)->get()->toArray();
        file_put_contents(public_path() . '/content/tags/' . $tag->slug . '.json', json_encode($data));
    }

    public function exportTags()
    {
        $allTags = Tag::where('status', 'publish')->get();
        $allTagsData = [];
        foreach ($allTags as $tag) {
            $tagData = $tag->toArray();
            $tagData['posts'] = $tag->posts()->count();
            array_push($allTagsData, $tagData);
        }
        file_put_contents(public_path() . '/content/tags.json', json_encode($allTagsData));
    }
}
