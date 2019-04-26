@component('mail::message')
# استعادة كلمة المرور

لقد ارسلنا لك هذه الرسالة لاننا استلمنا طلبا لتغيير كلمة مرور حسابك ، اذا لم تقم بهذا الطلب يرجى فقط تجاهل الرسالة او حذفها ، تنتهي صلاحية هذه الرسالة خلال 60 دقيقة.

@component('mail::button', ['url' => route('admin.password.reset', $token)])
استعادة كلمة المرور
@endcomponent

شكرا,<br>
فريق صحيفة خيبر
@endcomponent
