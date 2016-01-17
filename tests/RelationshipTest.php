<?php

use App\Endpoint;
use App\Field;
use App\Rule;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class RelationshipTest extends TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    /** @test */
    public function a_field_has_many_rules()
    {
        $rules = factory(Rule::class, 5)->create();
        $field = factory(Field::class)->create();

        $field->rules()->sync($rules);

        $this->assertCount(5, $field->rules);
    }

    /** @test */
    public function an_endpoint_has_many_fields()
    {
        $fields   = factory(Field::class, 4)->create();
        $endpoint = factory(Endpoint::class)->create();

        $endpoint->fields()->sync($fields);

        $this->assertCount(4, $endpoint->fields);
    }

    /** @test */
    public function an_endpoint_can_have_many_fields_and_this_connection_can_have_many_rules()
    {
        // A Field may have a default set of Rules, which are always applied
        $fieldRules = factory(Rule::class, 2)->create();
        $field      = factory(Field::class)->create();
        $endpoint   = factory(Endpoint::class)->create();

        // Attach default Rules to Field
        $field->rules()->sync($fieldRules);

        // Attach Field with default set of Rules to Endpoint
        $endpoint->fields()->attach($field);

        // Create 5 new Rules which will be stored to the pivot table Model
        $fieldEndpointRules = factory(Rule::class, 5)->create();

        /**
         * This is the "not so nice part". We have to receive the Pivot Model,
         * which connects Endpoint and Fields. In this example we only have
         * one Field which connects with the Endpoint, so we can simply
         * call `first()`. In your implementation you would have to
         * do `whereName($field->name)` or something similar.
         */
        $pivotModel = $endpoint->fields()->first()->pivot;

        // Attach Rules to the Pivot Model
        $pivotModel->rules()->sync($fieldEndpointRules);

        $this->assertCount(2, $field->rules);
        $this->assertCount(1, $endpoint->fields);
        $this->assertCount(5, $endpoint->fields()->first()->pivot->rules);
    }

    /** @test */
    public function rules_attached_to_endpoints_and_fields_can_have_attached_parameters()
    {
        $field      = factory(Field::class)->create();
        $endpoint   = factory(Endpoint::class)->create();

        // Attach Field with default set of Rules to Endpoint
        $endpoint->fields()->attach($field);

        // Create new RUle which will be stored to the pivot table Model
        $fieldEndpointRule = factory(Rule::class)->create(["parameters" => "this_is_passed_to_the_validator"]);

        /**
         * This is the "not so nice part". We have to receive the Pivot Model,
         * which connects Endpoint and Fields. In this example we only have
         * one Field which connects with the Endpoint, so we can simply
         * call `first()`. In your implementation you would have to
         * do `whereName($field->name)` or something similar.
         */
        $pivotModel = $endpoint->fields()->first()->pivot;

        // Attach Rule to the Pivot Model
        $pivotModel->rules()->attach($fieldEndpointRule);

        $this->assertEquals(
            "this_is_passed_to_the_validator",
            $endpoint->fields()->first()->pivot->rules()->first()->parameters
        );
    }

}
