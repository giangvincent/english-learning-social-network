<?php

namespace App\Admin\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\User;
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

        $grid->model()->orderBy('id', 'desc');
        $grid->column('id', __('Id'))->sortable();
        $grid->column('subject', __('Subject'));
        $grid->column('content', __('Content'))->display(function ($content) {
            $contentArr = json_decode($content, true);
            $contentDisplay = '';
            $numParagraph = count($contentArr);
            $contentDisplay .= "<p>Số para: $numParagraph</p>";

            return $contentDisplay;
        })->width(300);
        $grid->column('type', __('Type'))->filter([
            'flashCard' => 'flashCard',
            'quiz' => 'quiz',
            'normalPost' => 'Post'
        ]);

        $grid->column('author', __('Author'))->display(function ($user_id) {
            if ($user_id !== 0) {
                return User::findOrFail($user_id)->full_name;
            } else {
                return "";
            }
        });
        $categories = Category::select('name', 'id')->get()->toArray();
        $categoryArr = array();
        foreach ($categories as $category) {
            $categoryArr[$category['id']] = $category['name'];
        }
        $grid->column('category', __('Category'))->display(function ($cat_id) use ($categoryArr) {
            if ($cat_id !== 0) {
                return $categoryArr[$cat_id];
            } else {
                return "";
            }
        })->filter($categoryArr);

        $states = [
            'on' => ['value' => 'publish', 'text' => 'Publish', 'color' => 'primary'],
            'off' => ['value' => 'pending', 'text' => 'Pending', 'color' => 'default'],
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

        $grid->quickSearch('subject', 'content');
        $grid->filter(function ($filter) {
            $filter->like('subject');
            // $filter->date('updated_at', 'Lọc theo ngày tháng');
            $filter->between('updated_at', 'Lọc theo ngày tháng')->datetime();

            $cats = Category::get()->pluck('name', 'id')->toArray();
            $filter->where(function ($query) {
                $query->whereHas('category', function ($query) {
                    $query->where('id', $this->input);
                });
            }, 'Category')->select($cats);
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

        $form->text('pid', __('Pid'))->readonly();
        $states = [
            'on' => ['value' => 'publish', 'text' => 'Publish', 'color' => 'success'],
            'off' => ['value' => 'pending', 'text' => 'Pending', 'color' => 'default'],
        ];
        $form->switch('status', __('Status'))->states($states);

        $form->text('subject', __('Subject'))->autofocus();
        $form->textarea('content', __('Content'));

        $form->textarea('answer_list', __('Answer list'));

        $form->radio('type', __('Type'))->options([
            'normalPost' => 'Normal Post',
            'flashCard' => 'Flash Card',
            'quiz' => 'Quiz',
        ])->default('normalPost');

        $form->display('author', __('Author ID'));

        $form->display('category', __('Category ID'));

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
            'subject' => $post->subject,
            'content' => json_decode($post->content, true),
            'author' => $post->user()->select(['id', 'nick_name', 'full_name', 'avatar'])->first()->toArray(),
            'category' => $post->categoryRelated()->select(['id', 'name', 'slug'])->first()->toArray(),
            'tags' => $post->tags()->select(['id', 'name', 'slug'])->get()->toArray(),
            'datetime' => $post->updated_at,
            'nums_bagged' => $post->nums_bagged,
            'nums_good' => $post->nums_good,
            'nums_bad' => $post->nums_bad,
            'nums_share' => $post->nums_share,
            'nums_comment' => $post->nums_comment,
            'interact' => array('bagged' => [], 'good' => [], 'bad' => []),
            'comments' => array(),
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
