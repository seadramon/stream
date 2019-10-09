<?php

namespace Streamcms\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TvradioRequest extends FormRequest
{
    protected $errorBag = 'tvradio_store';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'key' => 'required|min:2',
            'name' => 'required|min:3',
            'stream' => 'required',
            'position' => 'integer',
        ];
    }

    public function sanitize()
    {

    }

    public function forbiddenResponse()
    {
        return Response::make('Permission denied foo!', 403);
       // return $this->redirector->route('auth.register');
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'key.required'  => 'Key wajib diisi',
            'key.min'  => 'Key terlalu pendek',

            'name.required' => 'Nama wajib diisi',
            'name.min' => 'Nama terlalu pendek',

            'stream.required' => 'Stream wajib diisi',
            'position.integer' => 'Position harus dalam bentuk angka'
        ];
    }
}
