<?php


namespace Vendor\Exceptions\Client;

use Vendor\Exceptions\BaseException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator as ValidatorFacade;

/**
 * Class ValidationException
 *
 * @package App\Exceptions\Client
 */
class ValidationException extends BaseException
{
    /**
     * The validator instance.
     *
     * @var \Illuminate\Contracts\Validation\Validator
     */
    public $validator;

    /**
     * 返回的状态码
     *
     * @var int
     */
    public $statusCode = 422;


    /**
     * Create a new exception instance.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @param \Exception|null                            $previous
     * @param int                                        $code
     *
     * @return void
     */
    public function __construct($validator, \Exception $previous = null, $code = 0)
    {
        parent::__construct($this->statusCode, '参数验证失败', $previous, [], $code);

        $this->validator = $validator;
    }

    /**
     * Create a new validation exception from a plain array of messages.
     *
     * @param array $messages
     *
     * @return static
     */
    public static function withMessages(array $messages)
    {
        return new static(tap(ValidatorFacade::make([], []), function ($validator) use ($messages) {
            foreach ($messages as $key => $value) {
                foreach (Arr::wrap($value) as $message) {
                    $validator->errors()->add($key, $message);
                }
            }
        }));
    }

    /**
     * Get all of the validation error messages.
     *
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors()->messages();
    }

    /**
     * Set the HTTP status code to be used for the response.
     *
     * @param int $statusCode
     *
     * @return $this
     */
    public function statusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * 获取状态码
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
