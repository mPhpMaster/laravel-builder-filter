<?php

namespace mPhpMaster\BuilderFilter\Tests;

use mPhpMaster\BuilderFilter\BuilderFilterRequest;

class BuilderFilterRequestTest extends TestCase
{
    /** @test */
    public function it_can_filter_nested_arrays()
    {
        $expected = [
            'info' => [
                'foo' => [
                    'bar' => 1,
                ],
            ],
        ];

        $request = new BuilderFilterRequest([
            'filter' => $expected,
        ]);

        $this->assertEquals($expected, $request->filters()->toArray());
    }

    /** @test */
    public function it_can_get_empty_filters_recursively()
    {
        $request = new BuilderFilterRequest([
            'filter' => [
                'info' => [
                    'foo' => [
                        'bar' => null,
                    ],
                ],
            ],
        ]);

        $expected = [
            'info' => [
                'foo' => [
                    'bar' => '',
                ],
            ],
        ];

        $this->assertEquals($expected, $request->filters()->toArray());
    }

    /** @test */
    public function it_will_map_true_and_false_as_booleans_recursively()
    {
        $request = new BuilderFilterRequest([
            'filter' => [
                'info' => [
                    'foo' => [
                        'bar' => 'true',
                        'baz' => 'false',
                        'bazs' => '0',
                    ],
                ],
            ],
        ]);

        $expected = [
            'info' => [
                'foo' => [
                    'bar' => true,
                    'baz' => false,
                    'bazs' => '0',
                ],
            ],
        ];

        $this->assertEquals($expected, $request->filters()->toArray());
    }

    /** @test */
    public function it_can_get_the_sort_query_param_from_the_request()
    {
        $request = new BuilderFilterRequest([
            'sort' => 'foobar',
        ]);

        $this->assertEquals(['foobar'], $request->sorts()->toArray());
    }

    /** @test */
    public function it_can_get_different_sort_query_parameter_name()
    {
        config(['builder-filter.parameters.sort' => 'sorts']);

        $request = new BuilderFilterRequest([
            'sorts' => 'foobar',
        ]);

        $this->assertEquals(['foobar'], $request->sorts()->toArray());
    }

    /** @test */
    public function it_will_return_an_empty_collection_when_no_sort_query_param_is_specified()
    {
        $request = new BuilderFilterRequest();

        $this->assertEmpty($request->sorts());
    }

    /** @test */
    public function it_can_get_multiple_sort_parameters_from_the_request()
    {
        $request = new BuilderFilterRequest([
            'sort' => 'foo,bar',
        ]);

        $expected = collect(['foo', 'bar']);

        $this->assertEquals($expected, $request->sorts());
    }

    /** @test */
    public function it_will_return_an_empty_collection_when_no_sort_query_params_are_specified()
    {
        $request = new BuilderFilterRequest();

        $expected = collect();

        $this->assertEquals($expected, $request->sorts());
    }

    /** @test */
    public function it_can_get_the_filter_query_params_from_the_request()
    {
        $request = new BuilderFilterRequest([
            'filter' => [
                'foo' => 'bar',
                'baz' => 'qux',
            ],
        ]);

        $expected = collect([
            'foo' => 'bar',
            'baz' => 'qux',
        ]);

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_can_get_different_filter_query_parameter_name()
    {
        config(['builder-filter.parameters.filter' => 'filters']);

        $request = new BuilderFilterRequest([
            'filters' => [
                'foo' => 'bar',
                'baz' => 'qux,lex',
            ],
        ]);

        $expected = collect([
            'foo' => 'bar',
            'baz' => ['qux', 'lex'],
        ]);

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_can_get_empty_filters()
    {
        config(['builder-filter.parameters.filter' => 'filters']);

        $request = new BuilderFilterRequest([
            'filters' => [
                'foo' => 'bar',
                'baz' => null,
            ],
        ]);

        $expected = collect([
            'foo' => 'bar',
            'baz' => '',
        ]);

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_will_return_an_empty_collection_when_no_filter_query_params_are_specified()
    {
        $request = new BuilderFilterRequest();

        $expected = collect();

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_will_map_true_and_false_as_booleans_when_given_in_a_filter_query_string()
    {
        $request = new BuilderFilterRequest([
            'filter' => [
                'foo' => 'true',
                'bar' => 'false',
                'baz' => '0',
            ],
        ]);

        $expected = collect([
            'foo' => true,
            'bar' => false,
            'baz' => '0',
        ]);

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_will_map_comma_separated_values_as_arrays_when_given_in_a_filter_query_string()
    {
        $request = new BuilderFilterRequest([
            'filter' => [
                'foo' => 'bar,baz',
            ],
        ]);

        $expected = collect(['foo' => ['bar', 'baz']]);

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_will_map_array_in_filter_recursively_when_given_in_a_filter_query_string()
    {
        $request = new BuilderFilterRequest([
            'filter' => [
                'foo' => 'bar,baz',
                'bar' => [
                    'foobar' => 'baz,bar',
                ],
            ],
        ]);

        $expected = collect(['foo' => ['bar', 'baz'], 'bar' => ['foobar' => ['baz', 'bar']]]);

        $this->assertEquals($expected, $request->filters());
    }

    /** @test */
    public function it_will_map_comma_separated_values_as_arrays_when_given_in_a_filter_query_string_and_get_those_by_key()
    {
        $request = new BuilderFilterRequest([
            'filter' => [
                'foo' => 'bar,baz',
            ],
        ]);

        $expected = ['foo' => ['bar', 'baz']];

        $this->assertEquals($expected, $request->filters()->toArray());
    }

    /** @test */
    public function it_can_get_the_include_query_params_from_the_request()
    {
        $request = new BuilderFilterRequest([
            'include' => 'foo,bar',
        ]);

        $expected = collect(['foo', 'bar']);

        $this->assertEquals($expected, $request->includes());
    }

    /** @test */
    public function it_can_get_different_include_query_parameter_name()
    {
        config(['builder-filter.parameters.include' => 'includes']);

        $request = new BuilderFilterRequest([
            'includes' => 'foo,bar',
        ]);

        $expected = collect(['foo', 'bar']);

        $this->assertEquals($expected, $request->includes());
    }

    /** @test */
    public function it_will_return_an_empty_collection_when_no_include_query_params_are_specified()
    {
        $request = new BuilderFilterRequest();

        $expected = collect();

        $this->assertEquals($expected, $request->includes());
    }

    /** @test */
    public function it_can_get_requested_fields()
    {
        $request = new BuilderFilterRequest([
            'fields' => [
                'table' => 'name,email',
            ],
        ]);

        $expected = collect(['table' => ['name', 'email']]);

        $this->assertEquals($expected, $request->fields());
    }

    /** @test */
    public function it_can_get_different_fields_parameter_name()
    {
        config(['builder-filter.parameters.fields' => 'field']);

        $request = new BuilderFilterRequest([
            'field' => [
                'column' => 'name,email',
            ],
        ]);

        $expected = collect(['column' => ['name', 'email']]);

        $this->assertEquals($expected, $request->fields());
    }

    /** @test */
    public function it_can_get_the_append_query_params_from_the_request()
    {
        $request = new BuilderFilterRequest([
            'append' => 'foo,bar',
        ]);

        $expected = collect(['foo', 'bar']);

        $this->assertEquals($expected, $request->appends());
    }

    /** @test */
    public function it_can_get_different_append_query_parameter_name()
    {
        config(['builder-filter.parameters.append' => 'appendit']);

        $request = new BuilderFilterRequest([
            'appendit' => 'foo,bar',
        ]);

        $expected = collect(['foo', 'bar']);

        $this->assertEquals($expected, $request->appends());
    }

    /** @test */
    public function it_will_return_an_empty_collection_when_no_append_query_params_are_specified()
    {
        $request = new BuilderFilterRequest();

        $expected = collect();

        $this->assertEquals($expected, $request->appends());
    }

    /** @test */
    public function it_takes_custom_delimiters_for_splitting_request_parameters()
    {
        $request = new BuilderFilterRequest([
            'filter' => [
                'foo' => 'values, contain, commas|and are split on vertical| lines',
            ],
        ]);

        BuilderFilterRequest::setArrayValueDelimiter('|');

        $expected = ['foo' => ['values, contain, commas', 'and are split on vertical', ' lines']];

        $this->assertEquals($expected, $request->filters()->toArray());
    }
}
