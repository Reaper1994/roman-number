<?php

namespace Tests\Feature;

use App\Http\Requests\Api\v1\ConvertRequest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;


class ConvertRequestTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Get the validation rules for the ConvertRequest.
     *
     * @return array
     */
    private function getValidationRules(): array
    {
        return (new ConvertRequest())->rules();
    }

    /**
     * Test valid input passes validation.
     *
     * @return void
     */
    public function testValidInputPassesValidation()
    {
        $data = ['integer' => 123];

        $validator = Validator::make($data, $this->getValidationRules());

        $this->assertFalse($validator->fails());
    }

    /**
     * Test missing integer fails validation.
     *
     * @return void
     */
    public function testMissingIntegerFailsValidation()
    {
        $data = [];

        $validator = Validator::make($data, $this->getValidationRules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('integer', $validator->errors()->toArray());
    }

    /**
     * Test non-integer value fails validation.
     *
     * @return void
     */
    public function testNonIntegerValueFailsValidation()
    {
        $data = ['integer' => 'abc'];

        $validator = Validator::make($data, $this->getValidationRules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('integer', $validator->errors()->toArray());
    }

    /**
     * Test integer less than 1 fails validation.
     *
     * @return void
     */
    public function testIntegerLessThanOneFailsValidation()
    {
        $data = ['integer' => 0];

        $validator = Validator::make($data, $this->getValidationRules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('integer', $validator->errors()->toArray());
    }

    /**
     * Test integer greater than 3999 fails validation.
     *
     * @return void
     */
    public function testIntegerGreaterThan3999FailsValidation()
    {
        $data = ['integer' => 4000];

        $validator = Validator::make($data, $this->getValidationRules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('integer', $validator->errors()->toArray());
    }
}
