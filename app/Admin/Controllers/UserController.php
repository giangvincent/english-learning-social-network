<?php

namespace App\Admin\Controllers;

use App\Models\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Table;

class UserController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('id', __('Id'));
        $grid->column('full_name', __('Full name'))->modal('Details', function ($detail) {
            $userInfo = $detail->info()->select('bio', 'socials_conn', 'notification_conn', 'others', 'cover_image')->first()->toArray();
            $userInfo['bagged'] = $detail->interacts()->where('interact', 'bagged')->count();
            $userInfo['vote_good'] = $detail->interacts()->where('interact', 'good')->count();
            $userInfo['vote_bad'] = $detail->interacts()->where('interact', 'bad')->count();
            $userInfo['progress'] = $detail->progress()->count();
            return new Table(['Detail', 'content'], $userInfo);
        });
        $grid->column('nick_name', __('Nick name'));
        $grid->column('avatar', __('Avatar'))->image('/../', 100, 100);
        $grid->column('phone', __('Phone'));
        $grid->column('birthday', __('Birth day'));
        $grid->column('email', __('Email'));
        $grid->column('created_at', __('Created at'))->display(function ($created_at) {
            return date("Y-m-d H:i:s", strtotime($created_at));
        });
        $grid->column('updated_at', __('Updated at'))->display(function ($created_at) {
            return date("Y-m-d H:i:s", strtotime($created_at));
        });

        $grid->quickSearch('full_name', 'email');
        $grid->filter(function ($filter) {
            $filter->like('full_name');
            $filter->like('nick_name');
            $filter->like('email');

            $filter->between('created_at', 'Lọc theo ngày đăng ký')->datetime();

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
        $show = new Show(User::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('full_name', __('Full name'));
        $show->field('nick_name', __('Nick name'));
        $show->field('avatar', __('Avatar'));
        $show->field('email', __('Email'));
        $show->field('email_verified_at', __('Email verified at'));
        $show->field('password', __('Password'));
        $show->field('remember_token', __('Remember token'));
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
        $form = new Form(new User());

        $form->text('full_name', __('Full name'));
        $form->text('nick_name', __('Nick name'));
        $form->image('avatar', __('Avatar'));
        $form->email('email', __('Email'));
        $form->datetime('email_verified_at', __('Email verified at'))->default(date('Y-m-d H:i:s'));
        $form->password('password', __('Password'));
        $form->text('remember_token', __('Remember token'));

        return $form;
    }
}
