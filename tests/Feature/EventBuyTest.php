<?php

use App\Models\Event;
use App\Models\Transaction;
use App\Models\User;
use App\Services\MidtransService;
use Illuminate\Support\Carbon;

it('returns a snap token when a student buys a paid event', function () {
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $event = Event::create([
        'title' => 'Paid Event Test',
        'slug' => 'paid-event-test',
        'description' => 'Test event description',
        'event_type' => 'workshop',
        'delivery_type' => 'online',
        'start_time' => Carbon::now()->addDays(7),
        'end_time' => Carbon::now()->addDays(7)->addHours(2),
        'timezone' => 'Asia/Jakarta',
        'instructor_id' => $instructor->id,
        'capacity' => 50,
        'is_paid' => true,
        'price' => 200000,
        'status' => 'live',
        'is_active' => true,
    ]);

    $this->actingAs($student);

    $this->mock(MidtransService::class, function ($mock) {
        $mock->shouldReceive('generateSnapToken')->once()->andReturn('fake-snap-token');
    });

    $response = $this->postJson(route('events.buy', $event->slug));

    $response->assertStatus(200)
        ->assertJson([
            'snap_token' => 'fake-snap-token',
            'client_key' => config('midtrans.client_key'),
        ]);

    $this->assertDatabaseHas('transactions', [
        'user_id' => $student->id,
        'event_id' => $event->id,
        'status' => 'pending',
        'amount' => 200000,
        'snap_token' => 'fake-snap-token',
    ]);
});

it('returns existing snap token for a pending transaction', function () {
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $event = Event::create([
        'title' => 'Pending Event Test',
        'slug' => 'pending-event-test',
        'description' => 'Test event description',
        'event_type' => 'workshop',
        'delivery_type' => 'online',
        'start_time' => Carbon::now()->addDays(7),
        'end_time' => Carbon::now()->addDays(7)->addHours(2),
        'timezone' => 'Asia/Jakarta',
        'instructor_id' => $instructor->id,
        'capacity' => 50,
        'is_paid' => true,
        'price' => 150000,
        'status' => 'live',
        'is_active' => true,
    ]);

    Transaction::create([
        'user_id' => $student->id,
        'event_id' => $event->id,
        'invoice_number' => 'INV-TEST-PENDING',
        'amount' => 150000,
        'status' => 'pending',
        'snap_token' => 'existing-token',
    ]);

    $this->actingAs($student);

    $this->mock(MidtransService::class, function ($mock) {
        $mock->shouldReceive('getTransactionStatus')
            ->once()
            ->andReturn(['transaction_status' => 'pending', 'fraud_status' => null]);
    });

    $response = $this->postJson(route('events.buy', $event->slug));

    $response->assertStatus(200)
        ->assertJson([
            'snap_token' => 'existing-token',
        ]);
});

it('rejects purchase when student already bought the event', function () {
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $event = Event::create([
        'title' => 'Already Bought Event',
        'slug' => 'already-bought-event',
        'description' => 'Test event description',
        'event_type' => 'workshop',
        'delivery_type' => 'online',
        'start_time' => Carbon::now()->addDays(7),
        'end_time' => Carbon::now()->addDays(7)->addHours(2),
        'timezone' => 'Asia/Jakarta',
        'instructor_id' => $instructor->id,
        'capacity' => 50,
        'is_paid' => true,
        'price' => 100000,
        'status' => 'live',
        'is_active' => true,
    ]);

    Transaction::create([
        'user_id' => $student->id,
        'event_id' => $event->id,
        'invoice_number' => 'INV-TEST-PAID',
        'amount' => 100000,
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    $this->actingAs($student);

    $response = $this->postJson(route('events.buy', $event->slug));

    $response->assertStatus(422)
        ->assertJson(['error' => 'Already purchased.']);
});

it('rejects purchase when event is free', function () {
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $event = Event::create([
        'title' => 'Free Event Test',
        'slug' => 'free-event-test',
        'description' => 'Test event description',
        'event_type' => 'webinar',
        'delivery_type' => 'online',
        'start_time' => Carbon::now()->addDays(7),
        'end_time' => Carbon::now()->addDays(7)->addHours(2),
        'timezone' => 'Asia/Jakarta',
        'instructor_id' => $instructor->id,
        'capacity' => 100,
        'is_paid' => false,
        'price' => 0,
        'status' => 'live',
        'is_active' => true,
    ]);

    $this->actingAs($student);

    $response = $this->postJson(route('events.buy', $event->slug));

    $response->assertStatus(422)
        ->assertJson(['error' => 'This event is free.']);
});

it('cancels transaction when Midtrans fails to generate token', function () {
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $event = Event::create([
        'title' => 'Midtrans Fail Event',
        'slug' => 'midtrans-fail-event',
        'description' => 'Test event description',
        'event_type' => 'workshop',
        'delivery_type' => 'online',
        'start_time' => Carbon::now()->addDays(7),
        'end_time' => Carbon::now()->addDays(7)->addHours(2),
        'timezone' => 'Asia/Jakarta',
        'instructor_id' => $instructor->id,
        'capacity' => 50,
        'is_paid' => true,
        'price' => 200000,
        'status' => 'live',
        'is_active' => true,
    ]);

    $this->actingAs($student);

    $this->mock(MidtransService::class, function ($mock) {
        $mock->shouldReceive('generateSnapToken')
            ->once()
            ->andThrow(new \Exception('Midtrans API error'));
    });

    $response = $this->postJson(route('events.buy', $event->slug));

    $response->assertStatus(500)
        ->assertJson(['error' => 'Failed to generate payment link. Please try again.']);

    $this->assertDatabaseHas('transactions', [
        'user_id' => $student->id,
        'event_id' => $event->id,
        'status' => 'cancelled',
    ]);
});

it('renders payment pending page for an event transaction', function () {
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $event = Event::create([
        'title' => 'Event Pending Test',
        'slug' => 'event-pending-test',
        'description' => 'Test event description',
        'event_type' => 'workshop',
        'delivery_type' => 'online',
        'start_time' => Carbon::now()->addDays(7),
        'end_time' => Carbon::now()->addDays(7)->addHours(2),
        'timezone' => 'Asia/Jakarta',
        'instructor_id' => $instructor->id,
        'capacity' => 50,
        'is_paid' => true,
        'price' => 200000,
        'status' => 'live',
        'is_active' => true,
    ]);

    $transaction = Transaction::create([
        'user_id' => $student->id,
        'event_id' => $event->id,
        'invoice_number' => 'INV-EVENT-PENDING',
        'amount' => 200000,
        'status' => 'pending',
    ]);

    $this->actingAs($student);

    $response = $this->get(route('payment.pending', ['order_id' => $transaction->invoice_number]));

    $response->assertStatus(200)
        ->assertSee('INV-EVENT-PENDING');
});

it('renders payment finish page for an event transaction', function () {
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $event = Event::create([
        'title' => 'Event Finish Test',
        'slug' => 'event-finish-test',
        'description' => 'Test event description',
        'event_type' => 'workshop',
        'delivery_type' => 'online',
        'start_time' => Carbon::now()->addDays(7),
        'end_time' => Carbon::now()->addDays(7)->addHours(2),
        'timezone' => 'Asia/Jakarta',
        'instructor_id' => $instructor->id,
        'capacity' => 50,
        'is_paid' => true,
        'price' => 200000,
        'status' => 'live',
        'is_active' => true,
    ]);

    $transaction = Transaction::create([
        'user_id' => $student->id,
        'event_id' => $event->id,
        'invoice_number' => 'INV-EVENT-FINISH',
        'amount' => 200000,
        'status' => 'paid',
        'paid_at' => now(),
    ]);

    $this->actingAs($student);

    $response = $this->get(route('payment.finish', [
        'order_id' => $transaction->invoice_number,
        'transaction_status' => 'settlement',
    ]));

    $response->assertStatus(200)
        ->assertSee('INV-EVENT-FINISH')
        ->assertSee('Lihat Event')
        ->assertSee(route('events.show', $event->slug));
});

it('redirects to event page when cancelling an event transaction', function () {
    $student = User::factory()->create(['role' => 'student']);
    $instructor = User::factory()->create(['role' => 'instructor']);

    $event = Event::create([
        'title' => 'Event Cancel Test',
        'slug' => 'event-cancel-test',
        'description' => 'Test event description',
        'event_type' => 'workshop',
        'delivery_type' => 'online',
        'start_time' => Carbon::now()->addDays(7),
        'end_time' => Carbon::now()->addDays(7)->addHours(2),
        'timezone' => 'Asia/Jakarta',
        'instructor_id' => $instructor->id,
        'capacity' => 50,
        'is_paid' => true,
        'price' => 200000,
        'status' => 'live',
        'is_active' => true,
    ]);

    $transaction = Transaction::create([
        'user_id' => $student->id,
        'event_id' => $event->id,
        'invoice_number' => 'INV-EVENT-CANCEL',
        'amount' => 200000,
        'status' => 'pending',
    ]);

    $this->actingAs($student);

    $response = $this->post(route('payment.cancel', $transaction->id));

    $response->assertRedirect(route('events.show', $event->slug));
    expect($transaction->refresh()->status)->toBe('cancelled');
});
