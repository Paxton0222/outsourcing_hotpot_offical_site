<?php

namespace App\Http\Requests\Traits;

use JsonException;

trait ResponseMessage
{
    /**
     * 定義錯誤回傳訊息
     *
     * @throws JsonException
     */
    public function messages(): array
    {
        return [
            'required' => $this->generateRuleMessage('required'),
            'string' => $this->generateRuleMessage('string'),
            'integer' => $this->generateRuleMessage('integer'),
            'max' => $this->generateRuleMessage('max', extraParams: [
                'max_length' => ':max',
            ]),
            'min' => $this->generateRuleMessage('min', extraParams: [
                'min_length' => ':min',
            ]),
            'unique' => $this->generateRuleMessage('unique'),
            'exists' => $this->generateRuleMessage('exists'),
            'email' => $this->generateRuleMessage('email'),
            'gender' => $this->generateRuleMessage('gender'),
            'phone' => $this->generateRuleMessage('phone'),
        ];
    }

    /**
     * 定義前端顯示訊息模板
     *
     * @return string[]
     */
    public function frontendMessages(): array
    {
        return [
            'unique' => '${attr}: ${input} 已存在',
            'exists' => '${attr}: ${input} 不存在',
            'required' => '${attr} 是必填欄位',
            'required_if' => '${attr} 是必填欄位',
            'email' => '${attr} 必須為電子郵件',
            'string' => '${attr} 必須是字串',
            'integer' => '${attr} 必須是數字',
            'gender' => '${attr} 無效的性別格式',
            'phone' => '${attr} 無效的手機號碼格式',
        ];
    }

    /**
     * 生成錯誤回傳訊息
     *
     * @throws JsonException
     */
    protected function generateRuleMessage(
        string $rule,
        string $key = ':attribute',
        mixed $value = ':input',
        array $extraParams = [],
    ): false|string {
        $params = collect([
            'attr' => $key,
            'input' => $value ? (string) $value : 'empty',
            'rule' => $rule,
        ])->merge($extraParams)->toArray();

        return json_encode($params, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);
    }
}
