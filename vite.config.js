import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js',
        },
    },
});
Route: get('post/create', 'PostController@create');

Route: post('post', 'PostController@store');
?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Показать форму для создания новой записи в блоге.
     *
     * @return Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Хранить новую запись в блоге.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        // Validate and store the blog post...
    }
}
/**
 * Store a new blog post.
 *
 * @param  Request  $request
 * @return Response
 */
public function store(Request $request)
{
    $this->validate($request, [
        'title' = 'required|unique:posts|max:255',
        'body' = 'required',
    ]);

    // The blog post is valid, store in database...
}
$this->validate($request, [
    'title' = 'bail|unique:posts|max:255',
    'body' = 'required',
]);
$this- validate($request, [
    'title' = 'required|unique:posts|max:255',
    'author.name' = 'required',
    'author.description' = 'required',
]);
!-- /resources/views/post/create.blade.php -->

<h1>Create Post</h1>

@if ($errors- any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

!-- Create Post Form -->
$this- validate($request, [
    'title' = 'required|unique:posts|max:255',
    'body' = 'required',
    'publish_at' = 'nullable|date',
]);
?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    /**
     * {@inheritdoc}
     */
    protected function formatValidationErrors(Validator $validator)
    {
        return $validator- errors()- all();
    }
}
/**
 * Получить правила валидации, применимые к запросу.
 *
 * @return array
 */
public function rules()
{
    return [
        'title' = 'required|unique:posts|max:255',
        'body' = 'required',
    ];
}
/**
 * Store the incoming blog post.
 *
 * @param  StoreBlogPost  $request
 * @return Response
 */
public function store(StoreBlogPost $request)
{
    // The incoming request is valid...
}
/**
 * Настройка экземпляра валидатора.
 *
 * @param  \Illuminate\Validation\Validator  $validator
 * @return void
 */
public function withValidator($validator)
{
    $validator-after(function ($validator) {
        if ($this-somethingElseIsInvalid()) {
            $validator-errors()-add('field', 'Something is wrong with this field!');
        }
    });
}
/**
 * Определить авторизован ли пользователь делать такой запрос.
 *
 * @return bool
 */
public function authorize()
{
    $comment = Comment: find($this-route('comment'));

    return $comment && $this-user()-can('update', $comment);
}
Route:post('comment/{comment}');
/**
 * Определить авторизован ли пользователь делать такой запрос.
 *
 * @return bool
 */
public function authorize()
/**
 * {@inheritdoc}
 */
protected function formatErrors(Validator $validator)
{
    return $validator-errors()-all();
}
/**
 * Get the error messages for the defined validation rules.
 *
 * @return array
 */
public function messages()
{
    return [
        'title.required' => 'A title is required',
        'body.required'  => 'A message is required',
    ];
}{
    return true;
}
?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    /**
     * Store a new blog post.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' = 'required|unique:posts|max:255',
            'body' = 'required',
        ]);

        if ($validator-fails()) {
            return redirect('post/create')
                        -withErrors($validator)
                        -withInput();
        }

        // Store the blog post...
    }
}
Validator:make($request-all(), [
    'title' = 'required|unique:posts|max:255',
    'body' = 'required',
])-validate();
return redirect('register')
            -withErrors($validator, 'login');
{{ $errors-login-first('email') }}
$validator = Validator::make(...);

$validator-after(function ($validator) {
    if ($this-somethingElseIsInvalid()) {
        $validator-errors()-add('field', 'Something is wrong with this field!');
    }
});

if ($validator-fails()) {
    //
}
$errors = $validator-errors();

echo $errors-first('email');
foreach ($errors-get('email') as $message) {
    //
}
foreach ($errors-get('attachments.*') as $message) {
    //
}
foreach ($errors-all() as $message) {
    //
}
if ($errors-has('email')) {
    //
}
$messages = [
    'required' = 'The :attribute field is required.',
];

$validator = Validator:make($input, $rules, $messages);
$messages = [
    'same'    = 'The :attribute and :other must match.',
    'size'    = 'The :attribute must be exactly :size.',
    'between' = 'The :attribute must be between :min - :max.',
    'in'      = 'The :attribute must be one of the following types: :values',
];
$messages = [
    'email.required' = 'We need to know your e-mail address!',
];
'custom' = [
    'email' = [
        'required' = 'We need to know your e-mail address!',
    ],
],
'attributes' = [
    'email' = 'email address',
],
use App\Http\Controllers\PostController;
 
Route:get('/post/create', [PostController:class, 'create']);
Route:post('/post', [PostController:class, 'store']);
use Illuminate\Http\Request;
 
public function store(Request $request): mixed
{
    $validated = $request- validate([
        'title' = 'required|unique:posts|max:255',
        'body' = 'required',
    ]);
 
    // The input is valid...
}
!-- /resources/views/post/create.blade.php -->
 
<h1>Create Post</h1>
 
@if ($errors-any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors-all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
 
!-- Create Post Form -->
php artisan make:request StorePostRequest
public function rules(): array
{
    return [
        'title' = 'required|unique:posts|max:255',
        'body' = 'required',
    ];
}
public function authorize(): bool
{
    /* Retrieve the comment that the user wants to update */
    $comment = Comment:find($this-route('comment'));
 
    /* Check if the comment exists and if the user is allowed to update this particular comment. If you want to learn more about the user()->can() method, you should checkout the Laravel docs on guards and authorization. */
    return $comment && $this-user()-can('update', $comment);
}
use \App\Http\Requests\StorePostRequest;
 
public function store(StorePostRequest $request): mixed
{
    // The incoming request is valid...
    // else the Form Request would have returned the error messages and we wouldn't be here then.
 
    // Retrieve the validated input data...
    $validated = $request- validated();
}
public function messages(): array
{
    return [
        'title.required' = 'A title is required',
        'body.required' = 'A message is required',
    ];
}
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
 
public function store(Request $request): mixed
{
    $validator = Validator: make($request-all(), [
        'title' = 'required|unique:posts|max:255',
        'body' = 'required',
    ]);
 
    if ($validator-fails()) {
        // For example:
        return redirect('post/create')
                -withErrors($validator)
                -withInput();
 
        // Also handy: get the array with the errors
        $validator-errors();
 
        // or, for APIs:
        $validator-errors()-toJson();
    }
 
    // Input is valid, continue...
}

