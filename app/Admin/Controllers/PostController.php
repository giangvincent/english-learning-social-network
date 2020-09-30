<?php

namespace App\Admin\Controllers;

use App\Models\Post;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PostController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Post';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Post());

        $grid->column('id', __('Id'));
        $grid->column('pid', __('Pid'));
        $grid->column('title', __('Title'));
        $grid->column('cover', __('Cover'));
        $grid->column('description', __('Description'));
        $grid->column('url', __('Url'));
        $grid->column('status', __('Status'));
        $grid->column('content', __('Content'));
        $grid->column('delta_content', __('Delta content'));
        $grid->column('medias', __('Medias'));
        $grid->column('answer_list', __('Answer list'));
        $grid->column('type', __('Type'));
        $grid->column('author', __('Author'));
        $grid->column('category', __('Category'));
        $grid->column('nums_pocket', __('Nums pocket'));
        $grid->column('nums_good', __('Nums good'));
        $grid->column('nums_bad', __('Nums bad'));
        $grid->column('nums_share', __('Nums share'));
        $grid->column('nums_comment', __('Nums comment'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Post::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('pid', __('Pid'));
        $show->field('title', __('Title'));
        $show->field('cover', __('Cover'));
        $show->field('description', __('Description'));
        $show->field('url', __('Url'));
        $show->field('status', __('Status'));
        $show->field('content', __('Content'));
        $show->field('delta_content', __('Delta content'));
        $show->field('medias', __('Medias'));
        $show->field('answer_list', __('Answer list'));
        $show->field('type', __('Type'));
        $show->field('author', __('Author'));
        $show->field('category', __('Category'));
        $show->field('nums_pocket', __('Nums pocket'));
        $show->field('nums_good', __('Nums good'));
        $show->field('nums_bad', __('Nums bad'));
        $show->field('nums_share', __('Nums share'));
        $show->field('nums_comment', __('Nums comment'));
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
        $form = new Form(new Post());

        $form->text('pid', __('Pid'));
        $form->text('title', __('Title'));
        $form->image('cover', __('Cover'));
        $form->text('description', __('Description'));
        $form->url('url', __('Url'));
        $form->text('status', __('Status'))->default('pending');
        $form->textarea('content', __('Content'));
        $form->textarea('delta_content', __('Delta content'));
        $form->textarea('medias', __('Medias'));
        $form->textarea('answer_list', __('Answer list'));
        $form->text('type', __('Type'));
        $form->number('author', __('Author'));
        $form->number('category', __('Category'));
        $form->number('nums_pocket', __('Nums pocket'));
        $form->number('nums_good', __('Nums good'));
        $form->number('nums_bad', __('Nums bad'));
        $form->number('nums_share', __('Nums share'));
        $form->number('nums_comment', __('Nums comment'));

        return $form;
    }
}
