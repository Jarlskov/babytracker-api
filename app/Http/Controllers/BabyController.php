<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParentInviteRequest;
use App\Models\Baby;
use App\Models\Meal;
use App\Models\MealType;
use App\Models\ParentInvite;
use App\ValueObjects\Measurement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BabyController extends Controller
{
    public function index(Request $request)
    {
        return Baby::all();
    }

    public function show(Baby $baby)
    {
        return $baby->load('meals');
    }

    public function store(Request $request)
    {
        $baby = new Baby();
        $baby->name = $request->get('name');
        $baby->save();

        $baby->parents()->attach($request->user()->id);


        return $baby;
    }

    public function addMeal(Request $request, Baby $baby)
    {
        $meal = $this->mapRequest($request, new Meal());
        $meal->baby()->associate($baby->id);
        $meal->save();

        return $meal;
    }

    public function updateMeal(Request $request, Baby $baby, Meal $meal)
    {
        $meal = $this->mapRequest($request, $meal);
        $meal->save();

        return $meal;
    }

    public function getParents(Request $request, Baby $baby)
    {
        return [
            'parents' => $baby->parents,
            'invites' => $baby->parentInvites,
        ];
    }

    public function invite(ParentInviteRequest $request, Baby $baby)
    {
        $inviteExists = $baby->parentInvites->contains(function ($invite) use ($request) {
            return $invite->email === $request->email;
        });
        if ($inviteExists) {
            throw new \Exception($request->email . ' has already been invited');
        }

        $invite = new ParentInvite();
        $invite->email = $request->email;
        $baby->parentInvites()->save($invite);

        return $invite;
    }

    public function deleteInvite(Request $request, Baby $baby, ParentInvite $invite)
    {
        $invite->delete();
    }

    private function mapRequest(Request $request, Meal $meal): Meal
    {
        $meal->start = new Carbon($request->start);
        $meal->note = $request->note;
        $meal->amount = $this->toMeasurement($request);
        $meal->mealType()->associate(MealType::find($request->meal_type_id));

        return $meal;
    }

    private function toMeasurement(Request $request): Measurement
    {
        return Measurement::fromValue($request->{'amount.value'}, $request->{'amount.unit'});
    }
}
