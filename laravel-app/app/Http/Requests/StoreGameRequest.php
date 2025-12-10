<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        // 認可は後で追加するので今はtrue
        return true;
    }

    public function rules(): array
    {
        return [
            'u_table_id' => ['required', 'exists:u_table,id'],
            'u_user_id'  => ['required', 'exists:u_user,id'],
            'score'      => ['required', 'integer', 'min:-200000', 'max:200000'],
            'rank'       => ['required', 'string', 'regex:/^([1-4](=[1-4])*)$/'],
            'point'      => ['nullable', 'numeric'],
            'seat'       => ['required', 'integer', 'between:1,4'],
            'mistake_count' => ['nullable', 'integer', 'min:0'],
            'played_at'  => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'u_table_id.required' => '卓IDは必須です。',
            'u_table_id.exists'   => '存在しない卓IDです。',
            'u_user_id.required'  => 'ユーザーIDは必須です。',
            'u_user_id.exists'    => '存在しないユーザーIDです。',
            'score.required'      => 'スコアは必須です。',
            'score.integer'       => 'スコアは数値で入力してください。',
            'rank.between'        => '順位は1〜4で入力してください。',
            'seat.between'        => '着順は1〜4で入力してください。',
            'played_at.date'      => '日付の形式が不正です。',
        ];
    }
}
