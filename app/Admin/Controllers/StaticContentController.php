<?php

namespace App\Admin\Controllers;

use App\Models\StaticContent;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Str;

class StaticContentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'StaticContent';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new StaticContent());
        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();
        $grid->column('title', __('Title'));
        // $grid->column('content', __('Content'));
        $grid->column('type', __('Type'))->filter([
            'flashCard' => 'flashCard',
            'quiz' => 'quiz',
            'normalPost' => 'Post',
        ]);
        // $grid->column('value', __('Value'));
        $states = [
            'off' => ['value' => 'pending', 'text' => 'Pending', 'color' => 'default'],
            'on' => ['value' => 'publish', 'text' => 'Publish', 'color' => 'primary'],
        ];
        $grid->column('status', __('Status'))->switch($states)->filter([
            'pending' => 'Pending',
            'publish' => 'Publish',
        ]);

        $grid->column('created_at', __('Created at'))->display(function ($created_at) {
            return date("Y-m-d H:i:s", strtotime($created_at));
        });
        $grid->column('updated_at', __('Updated at'))->display(function ($created_at) {
            return date("Y-m-d H:i:s", strtotime($created_at));
        });
        $grid->quickSearch('title', 'content');
        $grid->filter(function ($filter) {
            $filter->like('title');
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
        $show = new Show(StaticContent::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        $show->field('type', __('Type'));
        $show->field('value', __('Value'));
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
        $form = new Form(new StaticContent());

        $form->text('title', __('Title'));
        $form->hidden('slug', __('Slug'));
        $form->quill('content');
        $form->text('type', __('Type'))->default('common');
        $form->textarea('value', __('Value'))->default('{}');
        $states = [
            'on' => ['value' => 'publish', 'text' => 'Publish', 'color' => 'success'],
            'off' => ['value' => 'pending', 'text' => 'Pending', 'color' => 'default'],
        ];
        $form->switch('status', __('Status'))->states($states);
        $form->saving(function (Form $form) {
            $form->slug = Str::slug($form->title, "-");
        });

        $form->saved(function (Form $form) {
            $data = ['title' => $form->title, 'content' => $form->content];
            file_put_contents(public_path('dist/content') . '/' . $form->type . '.json', json_encode($data));
        });

        return $form;
    }
}
