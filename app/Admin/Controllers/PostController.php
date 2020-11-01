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

        $grid->column('status', __('Status'));
        $grid->column('content', __('Content'));
        $grid->column('answer_list', __('Answer list'));
        $grid->column('type', __('Type'));
        $grid->column('author', __('Author'));
        $grid->column('category', __('Category'));

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
        $show->field('status', __('Status'));
        $show->field('content', __('Content'));
        $show->field('answer_list', __('Answer list'));
        $show->field('type', __('Type'));
        $show->field('author', __('Author'));
        $show->field('category', __('Category'));
        $show->field('nums_bagged', __('Nums bagged'));
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
        $form->text('status', __('Status'))->default('pending');
        $form->textarea('content', __('Content'));
        $form->textarea('answer_list', __('Answer list'));
        $form->text('type', __('Type'));
        $form->number('author', __('Author'));
        $form->number('category', __('Category'));

        $form->saved(function (Form $form) {
            $post = Post::find($form->model()->id);
            $this->checkFolderContent();
            $this->exportPost($post);
        });
        return $form;
    }

    private function exportPost($post)
    {
        // $authorData = $post->user()->first()->toArray();
        $exportData = array([
            'id' => $post->id,
            'url' => $post->pid,
            'content' => json_decode($post->content, true),
            'author' => $post->user()->select(['id','nick_name', 'full_name', 'avatar'])->first()->toArray(),
            'category' => $post->categoryRelated()->select(['id', 'name', 'slug'])->first()->toArray(),
            'tags' => $post->tags()->select(['id', 'name', 'slug'])->get()->toArray(),
            'datetime' => $post->updated_at,
            'nums_bagged' => $post->nums_bagged,
            'nums_good' => $post->nums_good,
            'nums_bad' => $post->nums_bad,
            'nums_share' => $post->nums_share,
            'nums_comment' => $post->nums_comment,
            'interact' => array('bagged' => [], 'good' => [], 'bad' => []),
            'comments' => array()
        ]);
        return file_put_contents(public_path('content/posts') . '/' . $post->pid . '.json', json_encode($exportData));
    }

    public function checkFolderContent()
    {
        if (!file_exists(public_path() . '/content/')) {
            mkdir(public_path() . '/content/', 0777);
        }
        if (!file_exists(public_path() . '/content/posts/')) {
            mkdir(public_path() . '/content/posts/', 0777);
        }
    }
}
