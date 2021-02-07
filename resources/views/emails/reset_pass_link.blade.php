@component('mail::message')
# Khởi tạo lại mật khẩu

@component('mail::button', ['url' => 'https://thatsgood.info/auth/update-password?token='. $token . '&email='. $email])
Nhấn vào đây để đi tới đường dẫn khởi tạo lại mật khẩu
@endcomponent

<p>Nếu bạn không thể sử dụng được nút trên vui lòng copy và dán đường dẫn sau lên vài trình duyệt:</p>
<p><a
        href="{{'https://thatsgood.info/auth/update-password?token='. $token . '&email='. $email}}">{{ 'https://thatsgood.info/auth/update-password?token='. $token . '&email='. $email}}</a>
</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent