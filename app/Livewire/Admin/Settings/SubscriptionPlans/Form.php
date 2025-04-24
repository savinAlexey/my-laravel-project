<?php

namespace App\Livewire\Admin\Settings\SubscriptionPlans;

use App\Models\Platform;
use App\Models\SubscriptionPlan;
use Livewire\Component;

class Form extends Component
{
    public $planId;
    public $name;
    public $platform_id;
    public $price;
    public $currency = 'RUB';
    public $period;
    public $description;

    public $platforms = [];

    public function mount(SubscriptionPlan $plan = null)
    {
        $this->platforms = Platform::all();

        if ($plan) {
            $this->planId = $plan->id;
            $this->name = $plan->name;
            $this->platform_id = $plan->platform_id;
            $this->price = $plan->price;
            $this->currency = $plan->currency;
            $this->period = $plan->period;
            $this->description = $plan->description;
        }
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'platform_id' => 'required|exists:platforms,id',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'period' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ];
    }

    public function save()
    {
        $this->validate();

        $plan = $this->planId ? SubscriptionPlan::findOrFail($this->planId) : new SubscriptionPlan();
        $plan->name = $this->name;
        $plan->platform_id = $this->platform_id;
        $plan->price = $this->price;
        $plan->currency = $this->currency;
        $plan->period = $this->period;
        $plan->description = $this->description;
        $plan->save();

        session()->flash('success', 'Подписка успешно сохранена!');
        return redirect()->route('admin.subscription-plans.index');
    }

    public function render()
    {
        return view('livewire.admin.settings.subscription-plans.form');
    }
}



