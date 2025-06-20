<?php

use App\Models\User;
use App\Models\Items;
use App\Http\Controllers\Shopping;

test('guests are redirected to the login page', function () {
    $response = $this->get('/shopping');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the shopping page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/shopping');
    $response->assertStatus(200);
});

test('authenticated user can create an item', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $make = Items::factory()->create();
    $item = Shopping::add($make->order, $make->name, $make->price);
    
    expect($item->user_id)->toEqual($user->id);
    expect($item->order)->toEqual($make->order);
    expect($item->name)->toEqual($make->name);
    expect($item->price)->toEqual($make->price);
    expect($item->complete)->toBeFalse();
});

test('authenticated user can mark an item as complete', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $make = Items::factory()->create();
    $add = Shopping::add($make->order, $make->name, $make->price);
    $item = Shopping::complete($add->id);

    expect($item->complete)->toBeTrue();
});

test('authenticated user can delete an item', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $make = Items::factory()->create();
    $add = Shopping::add($make->order, $make->name, $make->price);
    $item = Shopping::delete($add->id);

    $find = Items::find($add->id);

    expect($find)->toBeNull();
});

test('authenticated user can reorder their items', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $makes = Items::factory(10)->create();

    $ids = [];
    foreach ($makes as $make) {
        $add = Shopping::add($make->order, $make->name, $make->price);
        $ids[] = $add->id;
    }
    shuffle($ids);

    Shopping::order($ids);

    $shopping = new Shopping;

    $match_ids = [];
    foreach ($shopping->items as $item) {
        $match_ids[] = $item->id;
    }

    expect($match_ids)->toEqual($ids);
});